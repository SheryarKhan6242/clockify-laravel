<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AllowanceType;

class AllowanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 
        $types = [
            [
                'type' => 'Sunday',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'General',
                'created_at' => date('Y-m-d H:i:s')    
            ],
            [
                'type' => 'Medical',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($types as $key => $value) {
            AllowanceType::firstOrCreate($value);
        }
    }
}
