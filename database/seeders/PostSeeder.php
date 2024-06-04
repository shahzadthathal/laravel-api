<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //To avoid duplicate slug entry exception used try catch block
        try{
            \App\Models\Post::factory(20)->create();
        }catch(\Exception $e){
            throw $e;
        }
    }
}
