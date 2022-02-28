<?php

namespace App\Providers;
use App\Product;
use App\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        ## Set product unavailable if quantity zero
        Product::updated(function($product){
            if($product->quantity == 0 && $product->isAvailable()){
                $product->status = $product::UNAVAILABLE;
                $product->save();
            }
        });

        ## Send mail on new user
        User::created(function($user){
            Mail::to($user->email)->send(new UserCreated($user));
        }); 

        ## Send mail on new user
        User::updated(function($user){
            if(!$user->isDirty('email')){
                Mail::to($user->email)->send(new UserMailChanged($user));
            }
        }); 

    }
}
