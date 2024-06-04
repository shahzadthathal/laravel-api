<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        try{
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }catch(\Exception $e){}

        // Call CategorySeeder
        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
