<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create parent bag category
        Category::create([
            'name' => 'Bags',
            'slug'=>'bags',
            'status' => 1
        ]);

        // Create parent watch category
        Category::create([
            'name' => 'Watches',
            'slug'=>'watches',
            'status' => 1
        ]);

        $this->command->info('Categories created successfully.');
    }
}
