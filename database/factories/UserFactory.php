<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Buyer;
use App\Seller;
use App\Product;
use App\Transaction;
use App\Category;


use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

##USER
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verified'=>$faker->randomElement([User::VERIFIED,User::UNVERIFIED]),
        'verification_token'=>User::VERIFIED ? null : User::generateVerificationCode(),
        'admin'=>$faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
    ];
});


##CATEGORY
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

##PRODUCT
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity'=>$faker->numberBetween(1,15),
        'status'=>$faker->randomElement([Product::AVAILABLE,Product::UNAVAILABLE]),
        'image'=>$faker->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg']),
        'seller_id'=>User::all()->random()->id
    ];
});


##TRANSACTIONS
$factory->define(Transaction::class, function (Faker $faker) {
    $seller=Seller::has('products')->get()->random();
    $buyer=User::all()->except($seller->id)->random();

    return [
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id'=>$buyer->id,
        'product_id'=>$seller->products->random()->id
       
    ];
});