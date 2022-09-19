
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
###Need to have Mysql database installed first along with PHP 7.4 or higher

### 1. Installs the project dependencies using
>  composer install

### 2. Copy .env.example to .env
On Windows
> copy .env.example .env

On Linux/*NIX
> cp .env.example .env


### 3. Edit the .env file and add the DATABASE configurations 
| Syntax | Description |
| ----------- | ----------- |
| DB_DATABASE | test |
| DB_USERNAME | root |
| DB_PASSWORD | root |

### 4. Run migration command, 
> php artisan migrate
#### this will create the required tables in the database

### 5. Run database seeding command,
> php artisan db:seed --class=DatabaseSeeder
#### this will insert some sample data into the tables created above

### 6. Start php's inbuilt server for testing
> php artisan serve

---

## [TESTING]
> .\vendor\bin\phpunit

