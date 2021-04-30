<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Buyer;
use App\Seller;
use App\Product;
use App\Transaction;
use App\Category;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //disable F_K
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();
        //
        factory(User::class,50)->create();
        factory(Category::class,10)->create();
        //
        factory(Product::class,200)->create()->each(
            function($product){
                $categories = Category::all()->random(mt_rand(1, 2))->pluck('id');

                $product->categories()->attach($categories);
            }
        );
        //
        factory(Transaction::class,200)->create();
        
    }
}
