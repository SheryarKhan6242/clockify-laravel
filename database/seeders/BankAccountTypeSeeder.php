<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankAccountType;

class BankAccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['type' => 'Primary'],
            ['type' => 'Secondary']
        ];

        foreach ($types as $key => $value) {
            BankAccountType::firstOrCreate($value);
        }
    }
}
