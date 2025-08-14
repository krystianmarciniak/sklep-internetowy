<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->insert([
            ['name' => 'Testowy klient 1'],
            ['name' => 'Testowy klient 2'],
        ]);
    }
}
