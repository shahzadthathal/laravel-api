<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //To avoid duplicate entry exception used try catch block
        try{
            \App\Models\Category::factory(5)->create();
        }catch(\Exception $e){
            throw $e;
        }
    }
}
