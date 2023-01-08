<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Prevent to send email during create
        // new user when seeding
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();


        \App\Models\User::factory(1000)->create();

        \App\Models\Category::factory(30)->create();

        \App\Models\Product::factory(1000)->create()->each(function($product){

            $categories = Category::all()->random((mt_rand(1,5)))->pluck('id');
            $product->categories()->attach($categories);
            
        });

        \App\Models\Transaction::factory(1000)->create();
    }
}
