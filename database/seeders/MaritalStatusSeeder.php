<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaritalStatus;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['status' => 'Married'],
            ['status' => 'Single'],
            ['status' => 'Divorced'],
        ];

        foreach ($status as $key => $value) {
            MaritalStatus::firstOrCreate($value);
        }
    }
}
