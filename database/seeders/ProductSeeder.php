<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //To avoid duplicate slug entry exception used try catch block
        try{
            \App\Models\Product::factory(10)->create();
        }catch(\Exception $e){
            throw $e;
        }
    }
}
