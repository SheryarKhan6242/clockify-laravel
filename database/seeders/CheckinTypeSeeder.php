<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CheckinType;

class CheckinTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types= [
            ['type' => 'office'],
            ['type' => 'wfh'],
            ['type' => 'client']
        ];

        foreach ($types as $type) {
            CheckinType::firstOrCreate($type);
        }
    }
}
