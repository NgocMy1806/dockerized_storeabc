<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'id' => 1,
                'sort' => 'HT',
                'country_name' => 'Haiti',
                'phoneCode' => 214
            ],
            [
                'id' => 2,
                'sort' => 'AE',
                'country_name' => 'United Arab Emirates',
                'phoneCode' => 213
            ],

            [
                'id' => 3,
                'sort' => 'DZ',
                'country_name' => 'Algeria',
                'phoneCode' => 213
            ],
            [
                'id' => 4,
                'sort' => 'AS',
                'country_name' => 'American Samoa',
                'phoneCode' => 1684
            ],
            [
                'id' => 5,
                'sort' => 'AD',
                'country_name' => 'Andorra',
                'phoneCode' => 376
            ],
            [
                'id' => 6,
                'sort' => 'AO',
                'country_name' => 'Angola',
                'phoneCode' => 244
            ],
            [
                'id' => 7,
                'sort' => 'AI',
                'country_name' => 'Anguilla',
                'phoneCode' => 1264
            ],
            [
                'id' => 8,
                'sort' => 'AQ',
                'country_name' => 'Antarctica',
                'phoneCode' => 0
            ],
            [
                'id' => 9,
                'sort' => 'AG',
                'country_name' => 'Antigua And Barbuda',
                'phoneCode' => 1268
            ],
            [
                'id' => 10,
                'sort' => 'AR',
                'country_name' => 'Argentina',
                'phoneCode' => 54
            ],
            [
                'id' => 11,
                'sort' => 'AM',
                'country_name' => 'Armenia',
                'phoneCode' => 374
            ],
            [
                'id' => 12,
                'sort' => 'AW',
                'country_name' => 'Aruba',
                'phoneCode' => 297
            ],
            [
                'id' => 13,
                'sort' => 'AU',
                'country_name' => 'Australia',
                'phoneCode' => 61
            ],
            [
                'id' => 14,
                'sort' => 'AT',
                'country_name' => 'Austria',
                'phoneCode' => 43
            ],
            [
                'id' => 15,
                'sort' => 'AZ',
                'country_name' => 'Azerbaijan',
                'phoneCode' => 994
            ],
            [
                'id' => 16,
                'sort' => 'BS',
                'country_name' => 'Bahamas The',
                'phoneCode' => 1242
            ],
            [
                'id' => 17,
                'sort' => 'BH',
                'country_name' => 'Bahrain',
                'phoneCode' => 973
            ],
            [
                'id' => 18,
                'sort' => 'BD',
                'country_name' => 'Bangladesh',
                'phoneCode' => 880
            ],
            [
                'id' => 19,
                'sort' => 'BB',
                'country_name' => 'Barbados',
                'phoneCode' => 1246
            ],
            [
                'id' => 20,
                'sort' => 'BY',
                'country_name' => 'Belarus',
                'phoneCode' => 375
            ],
            [
                'id' => 21,
                'sort' => 'BE',
                'country_name' => 'Belgium',
                'phoneCode' => 32
            ],
            [
                'id' => 22,
                'sort' => 'BZ',
                'country_name' => 'Belize',
                'phoneCode' => 501
            ],
            [
                'id' => 23,
                'sort' => 'BJ',
                'country_name' => 'Benin',
                'phoneCode' => 229
            ],
            [
                'id' => 24,
                'sort' => 'BM',
                'country_name' => 'Bermuda',
                'phoneCode' => 1441
            ],
            [
                'id' => 25,
                'sort' => 'BT',
                'country_name' => 'Bhutan',
                'phoneCode' => 975
            ],
            [
                'id' => 26,
                'sort' => 'BO',
                'country_name' => 'Bolivia',
                'phoneCode' => 591
            ],
            [
                'id' => 27,
                'sort' => 'BA',
                'country_name' => 'Bosnia and Herzegovina',
                'phoneCode' => 387
            ],
            [
                'id' => 28,
                'sort' => 'BW',
                'country_name' => 'Botswana',
                'phoneCode' => 267
            ],
            [
                'id' => 29,
                'sort' => 'BV',
                'country_name' => 'Bouvet Island',
                'phoneCode' => 0
            ],
            [
                'id' => 30,
                'sort' => 'BR',
                'country_name' => 'Brazil',
                'phoneCode' => 55
            ],
        ];
        Country::insert($countries);
    }
}
