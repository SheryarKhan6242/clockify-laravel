<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class CountriesCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = resource_path() . '/countries_cities.json';

        if ( !file_exists($file) )
        {
            throw new Exception('Countries/cities seeder json file not found!');
        }

        $data = file_get_contents($file);
        $json = json_decode($data);

        foreach ( $json as $countryName => $cities)
        {
            $country = Country::firstOrCreate( ['name' => $countryName] );

            foreach ( $cities as $city )
            {
                $city = City::firstOrCreate( ['name' => $city, 'country_id' => $country->id] );
            }
        }
    }
}
