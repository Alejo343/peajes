<?php

namespace Database\Seeders;

use App\Models\Values;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Values::create([
            'name' => 'Cencar',
            'value' => 11000,
        ]);

        Values::create([
            'name' => 'Cerrito',
            'value' => 11000,
        ]);

        Values::create([
            'name' => 'Rozo',
            'value' => 11000,
        ]);
    }
}
