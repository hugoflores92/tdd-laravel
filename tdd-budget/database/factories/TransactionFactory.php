<?php

use App\Transaction;
use App\Category;

use Faker\Generator as Faker;
use App\User;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(2),
        'amount' => $faker->numberBetween(5, 10),
        'category_id' => function(){
            return factory(Category::class)->create()->id;
        },
        'user_id' => function(){
            return factory(User::class)->create()->id;
        }
    ];
});