<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
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
                'type' => 'Annual',
                'status' => 0
            ],
            [
                'type' => 'Sick',
                'status' => 0
            ],
            [
                'type' => 'Casual',
                'status' => 0
            ],
            [
                'type' => 'Half Day',
                'status' => 0
            ],
        ];

        foreach ($types as $key => $value) {
            LeaveType::firstOrCreate($value);
        }
    }
}
