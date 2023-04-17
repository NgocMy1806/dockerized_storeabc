<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [
                'id' => 1,
                'country_id'=> 2,
                'state_name' => 'Alabama'
                
            ],

            [
                'id' => 2,
                'country_id'=> 2,
                'state_name' => 'Alaska'
                
            ],

            [
                'id' => 3,
                'country_id'=>2,
                'state_name' => 'Arizona'
               
            ],
            [
                'id' => 4,
                 'country_id'=>2,
                'state_name' => 'Arkansas'
               
            ],
            [
                'id' => 5,
                  'country_id'=>2,
                'state_name' => 'California'
              
            ],
            [
                'id' => 6,
                'country_id'=>2,
                'state_name' => 'Colorado'
                
            ],
            [
                'id' => 7,
                 'country_id'=>2,
                'state_name' => 'Connecticut'
               
            ],
            [
                'id' => 8,
                 'country_id'=>2,
                'state_name' => 'Delaware'
                
            ],
            [
                'id' => 9,
                'country_id'=>2,
                'state_name' => 'District of Columbia'
                
            ],
            [
                'id' => 10,
                 'country_id'=>2,
                'state_name' => 'Florida'
               
            ],
            [
                'id' => 11,
                'country_id'=>2,
                'state_name' => 'Georgia'
                
            ],
            [
                'id' => 12,
                 'country_id'=>2,
                'state_name' => 'Hawaii'
               
            ],
            [
                'id' => 13,
                 'country_id'=>2,
                'state_name' => 'Idaho'
               
            ],
            [
                'id' => 14,
                'country_id'=>2,
                'state_name' => 'Illinois'
                
            ],
            [
                'id' => 15,
                  'country_id'=>2,
                'state_name' => 'Indiana'
              
            ],
            [
                'id' => 16,
                  'country_id'=>2,
                'state_name' => 'Iowa'
              
            ],
            [
                'id' => 17,
                'country_id'=>2,
                'state_name' => 'Kansas'
                
            ],
            [
                'id' => 18,
                'country_id'=>2,
                'state_name' => 'Kentucky'
                
            ],
            [
                'id' => 19,
                'country_id'=>2,
                'state_name' => 'Louisiana'
                
            ],
            [
                'id' => 20,
                 'country_id'=>2,
                'state_name' => 'Maine'
               
            ],
            [
                'id' => 21,
                'country_id'=>2,
                'state_name' => 'Maryland'
                
            ],
            [
                'id' => 22,
                'country_id'=>2,
                'state_name' => 'Massachusetts'
                
            ],
            [
                'id' => 23,
                'country_id'=>2,
                'state_name' => 'Michigan'
                
            ],
            [
                'id' => 24,
                 'country_id'=>2,
                'state_name' => 'Minnesota'
               
            ],
            [
                'id' => 25,
                 'country_id'=>2,
                'state_name' => 'Mississippi'
               
            ],
            [
                'id' => 26,
                'country_id'=>2,
                'state_name' => 'Missouri'
                
            ],
            [
                'id' => 27,
                 'country_id'=>2,
                'state_name' => 'Montana'
               
            ],
            [
                'id' => 28,
                'country_id'=>2,
                'state_name' => 'Nebraska'
                
            ],
            [
                'id' => 29,
                 'country_id'=>1,
                'state_name' => 'Andhra Pradesh'
               
            ],
            [
                'id' => 30,
                'country_id'=>1 ,
                'state_name' => 'Arunachal Pradesh '
                           ],
            [
                'id' => 31,
                'country_id'=>1,
                'state_name' => 'Assam'
                
            ],
            [
                'id' => 32,
                'country_id'=>1,
                'state_name' => 'Bihar'
                
            ],
            [
                'id' => 33,
                'country_id'=>1,
                'state_name' => 'Chhattisgarh'
                
            ],
            [
                'id' => 34,
                'country_id'=>1,
                'state_name' => 'Goa'
                
            ],
            [
                'id' => 35,
                'country_id'=>1,
                'state_name' => 'Gujarat'
                
            ],
            [
                'id' => 36,
                'country_id'=>1,
                'state_name' => 'Haryana'
                
            ],
            [
                'id' => 37,
                'country_id'=>1,
                'state_name' => 'Himachal Pradesh'
                
            ],
            [
                'id' => 38,
                'country_id'=>1,
                'state_name' => 'Jharkhand'
                
            ],
            [
                'id' => 39,
                'country_id'=>1,
                'state_name' => 'Karnataka'
                
            ],
            [
                'id' => 40,
                'country_id'=>1,
                'state_name' => 'Kerala '
                
            ],
            [
                'id' => 41,
                'country_id'=>1,
                'state_name' => 'Madhya Pradesh'
                
            ],
            [
                'id' => 42,
                'country_id'=>1,
                'state_name' => 'Maharashtra'
                
            ],
            [
                'id' => 43,
                'country_id'=>1,
                'state_name' => 'Manipur'
                
            ],
       
        ];

        State::insert($states);
    }
}