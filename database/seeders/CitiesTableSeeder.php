<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'id' => 1,
                'state_id'=> 16,
                'city_name' => 'Amlabad'
                
            ],
             [
                'id' => 2,
                'state_id'=> 16,
                'city_name' => 'Bandh Dih'
                
            ],
            [
                'id' => 3,
                'state_id'=> 16,
                'city_name' => 'Bandhgora'
                
            ],
            [
                'id' => 4,
                'state_id'=> 16,
                'city_name' => 'Bhojudih'
                
            ],
            [
                'id' => 5,
                'state_id'=> 16,
                'city_name' => 'Bokaro Steel City'
                
            ],
            [
                'id' => 16,
                'state_id'=> 16,
                'city_name' => 'Chandrapura'
                
            ],
            [
                'id' => 7,
                'state_id'=> 16,
                'city_name' => 'Chas'
                
            ],
            [
                'id' => 8,
                'state_id'=> 16,
                'city_name' => 'Chira Chas'
                
            ],
             [
                'id' => 9,
                'state_id'=> 16,
                'city_name' => 'Dugda'
                
            ],
             [
                'id' => 10,
                'state_id'=> 16,
                'city_name' => 'Dungaditand'
                
            ],
             [
                'id' => 11,
                'state_id'=> 16,
                'city_name' => 'Gomia'
                
            ],
             [
                'id' => 12,
                'state_id'=> 16,
                'city_name' => 'Jaridih Bazar'
                
            ],
           
            [
                'id' => 13,
                'state_id'=> 16,
                'city_name' => 'Jena'
                
            ],
           
            [
                'id' => 14,
                'state_id'=> 16,
                'city_name' => 'Kurpania'
                
            ],
             [
                'id' => 15,
                'state_id'=> 16,
                'city_name' => 'Lalpania'
                
            ],
             [
                'id' => 101,
                'state_id'=> 16,
                'city_name' => 'Phusro'
                
            ],
             [
                'id' => 17,
                'state_id'=> 16,
                'city_name' => 'Sijhua'
                
            ],
             [
                'id' => 18,
                'state_id'=> 16,
                'city_name' => 'Tenu'
                
            ],
           [
                'id' => 19,
                'state_id'=> 1,
                'city_name' => 'bombuflat'
                
            ],
            [
                'id' => 20,
                'state_id'=> 1,
                'city_name' => 'Garacharma'
                
            ],
            [
                'id' => 21,
                'state_id'=> 1,
                'city_name' => 'Port Blair'
                
            ],
            [
                'id' => 22,
                'state_id'=> 1,
                'city_name' => 'Rangat'
                
            ],
             [
                'id' => 23,
                'state_id'=> 2,
                'city_name' => 'Addanki'
                
            ],
            [
                'id' => 24,
                'state_id'=> 2,
                'city_name' => 'Adivivaram'
                
            ],
            [
                'id' => 25,
                'state_id'=> 2,
                'city_name' => 'Adoni'
                
            ],
            [
                'id' => 26,
                'state_id'=> 2,
                'city_name' => 'Aganampudi'
                
            ],
             [
                'id' => 27,
                'state_id'=> 2,
                'city_name' => 'Ajjaram'
                
            ],
             [
                'id' => 28,
                'state_id'=> 2,
                'city_name' => 'Akividu'
                
            ],
             [
                'id' => 29,
                'state_id'=> 2,
                'city_name' => 'Akkarampalle'
                
            ],
             [
                'id' => 30,
                'state_id'=> 2,
                'city_name' => 'Akkayapalle'
                
            ],
             [
                'id' => 31,
                'state_id'=> 2,
                'city_name' => 'Akkireddipalem'
                
            ],
             [
                'id' =>32,
                'state_id'=> 2,
                'city_name' => 'Alampur'
                
            ],
             [
                'id' => 33,
                'state_id'=> 2,
                'city_name' => 'Amalapuram'
                
            ],    
        ];

        City::insert($cities);
    }
}