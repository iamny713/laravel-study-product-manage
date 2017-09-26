<?php

use NohYooHan\Domain\Product\Product;
use NohYooHan\Domain\User\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Product::truncate();
        User::forceCreate([
            'name' => 'foo',
            'email' => 'foo@foo.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class, 5)->create();
        factory(Product::class, 5)->create();
    }
}
