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
            'name' => 'CENCAR',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'CERRITO',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'ROZO',
            'value' => 11500,
        ]);

        Values::create([
            'name' => 'BETANIA',
            'value' => 11500,
        ]);
    }
}
