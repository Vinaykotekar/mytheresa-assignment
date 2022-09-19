
# Mytheresa assignment

### API Endpoint 
/api/products


### Discount rules
1. 1.Products in the boots category (category_id=1) have a 30% discount.
2. The product with sku = 000003 has a 15% discount
3. When multiple discounts collide, the biggest discount must be applied.


### Filter Rules
1. category_id : filters by category_id of a product
2. category : filters by category name of a product
3. priceLessThan : filters by price of a product, all products with or below this amount will be returned in result



## Running the project

> 1. composer install
### Installs the project dependencies

> 2. php artisan migrate
### Will create the needed tables in database

> 3. php artisan db:seed --class=DatabaseSeeder
### Will populate the tables with the sample data given

> 4. php artisan serve
### Starts php's inbuilt server for testing

> 5. .\vendor\bin\phpunit
### Test cases can be evaluated
