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
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'Cerrito',
            'value' => 12600,
        ]);

        Values::create([
            'name' => 'Rozo',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'CIAT',
            'value' => 12500,
        ]);

        Values::create([
            'name' => 'Estambul',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'Betania',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'Uribe',
            'value' => 12800,
        ]);
    }
}
