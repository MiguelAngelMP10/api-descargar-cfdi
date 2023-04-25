<?php

namespace Database\Seeders;

use App\Models\Query;
use Illuminate\Database\Seeder;

class QuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Query::factory(20)->create();
    }
}
