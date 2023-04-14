<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $genders = [
            ['name' => 'Male'],
            ['name' => 'Female'],
        ];

        foreach ($genders as $gender) {
            Gender::firstOrCreate($gender);
        }
    }
}
