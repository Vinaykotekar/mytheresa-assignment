<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse ;
use App\Models\Product;
use App\Models\CategoryDiscountRules;
use App\Models\SKUDiscountRules;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Mytheresa\DiscountHelper;

class ProductController
{
    public function index(Request $request): JsonResponse
    {

        $pageSet = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
                ->select('products.sku', 'products.name', 'categories.category_name as category', 'categories.category_id', 'products.price');

        //apply search filters
        $this->filterByCategoryId($request, $pageSet);
        $this->filterByCategoryName($request, $pageSet);
        $this->filterByMaxPrice($request, $pageSet);

        $pageSet = $pageSet->paginate(5); //Must return at most 5 elements per go.

        //retrieve core result from pagination result set
        $products = $pageSet->items();

        //convert items to laravel collection type to use helper method like map
        $products = collect($products);

        $helper = new DiscountHelper($products);
        foreach ($products as $product) {
            $product->price = $helper->getApplicableDiscount($product);
        }

        $pageSet->setCollection($products);
        return response()->json($pageSet);
    }


    /**
     * @param $request Request
     * @param $query Builder
     */
    private static function filterByCategoryId(Request $request, Builder $query) {
        if($request->has('category_id')) {
            $category_id = intval($request->category_id);
            if(!is_nan($category_id) && $category_id>0){
                $query->where('categories.category_id', $category_id);
            }
        }
    }

    /**
     * @param $request Request
     * @param $query Builder
     */
    private static function filterByCategoryName(Request $request, Builder $query) {
        if($request->has('category') && $request->category!= '') {
            $query->where('categories.category_name', 'like', '%' . $request->category . '%');
        }
    }

    /**
     * @param $request Request
     * @param $query Builder
     */
    private static function filterByMaxPrice(Request $request, Builder $query) {
        if($request->has('priceLessThan') && $request->priceLessThan!= '') {
            $price_max = intval($request->priceLessThan);
            if(!is_nan($price_max) && $price_max>0){
                $query->where('products.price', '<=', $price_max);
            }
        }
    }
}
