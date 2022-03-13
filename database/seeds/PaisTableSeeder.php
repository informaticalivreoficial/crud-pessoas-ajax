<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pais')->insert([
            [
                'id' => 1, 
                'nome' => 'Brasil'
            ],
            [
                'id' => 2, 
                'nome' => 'United States of America'
            ]
        ]);
    }
}
