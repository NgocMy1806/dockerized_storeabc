<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin account
        Admin::create([
            'name' => 'mymy',
            // 'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->command->info('Admin account created successfully.');
    }
}
