<?php


namespace App\Mytheresa;

use Illuminate\Support\Collection;
use App\Models\CategoryDiscountRules;
use App\Models\SKUDiscountRules;
use App\Models\Product;

class DiscountHelper
{
    private $skuDiscountMap;
    private $categoryDiscountMap;

    /**
     * @param $products Collection
     */
    function __construct(Collection $products) {
        $this->getSKUDiscountsForProducts($products);
        $this->getCategoryDiscountsForProducts($products);
    }

    /**
     * @param $products Collection
     */
    public function getSKUDiscountsForProducts(Collection $products){
        //get only those rows from `discount_rules_by_sku` tables which are relevant to this result set
        $productSKUs = $products->map(function ($product) {
            return  $product->sku;
        })->toArray();
        $records = SKUDiscountRules::whereIn('sku', $productSKUs)->get()->toArray(); // [ [sku=>'00003', discount_percentage=>20], ...[] ]
        $this->skuDiscountMap = self::convertToHashMap($records, 'sku');   // ['00003'=>20, ..]
    }

    /**
     * @param Collection Product
     */
    public function getCategoryDiscountsForProducts(Collection $products){
        //get only those rows from `discount_rules_by_category` tables which are relevant to this result set
        $productCategoryIDs = $products->map(function ($product) {
            return  $product->category_id;
        })->toArray();
        $records = CategoryDiscountRules::whereIn('category_id', $productCategoryIDs)->get()->toArray(); // [ [category_id=>1, discount_percentage=>20], ...[] ]
        $this->categoryDiscountMap = self::convertToHashMap($records, 'category_id'); // [1=>20, ..]
    }

    public function getApplicableDiscount(Product $product){
        $original_price = $final_price = $product->price;

        //product has discount entry for both - its sku as well as its category
        if(isset($this->skuDiscountMap[$product->sku]) && isset($this->categoryDiscountMap[$product->category_id])){
            $discount_percentage = max($this->skuDiscountMap[$product->sku], $this->categoryDiscountMap[$product->category_id]);
        }elseif(isset($this->skuDiscountMap[$product->sku])){
            //product has discount entry for its sku only
            $discount_percentage = $this->skuDiscountMap[$product->sku];
        }elseif(isset($this->categoryDiscountMap[$product->category_id])){
            //product has discount entry for its category only
            $discount_percentage = $this->categoryDiscountMap[$product->category_id];
        }else{
            //product don't have any discount
            $discount_percentage = null;
        }

        if($discount_percentage && $discount_percentage > 0) {
            $final_price = self::calcDiscounted($original_price, $discount_percentage);
        }else {
            $final_price = $original_price;
        }

        return [
            "original"            => $product->price,
            "final"               => $final_price,
            "discount_percentage" => $discount_percentage? $discount_percentage.'%': null,
            "currency"            => "EUR",
        ];
    }

    /**
     * @param $arr array 2-d array
     * @param $attrib string key of the resulting associative array
     * @return array
     */
    private static function convertToHashMap(array $arr, string $attrib): array
    {
        $result = [];
        foreach ($arr as $item) {
            $result[$item[$attrib]] = $item['discount_percentage'];
        }

        return $result;
    }

    /**
     * @param $price int original price
     * @param $pct float percentage
     * @return int
     */
    public static function calcDiscounted(int $price, float $pct): int
    {
        $discount_amt =  $pct/100 * $price;
        return intval ( round($price - $discount_amt) );
    }
}
