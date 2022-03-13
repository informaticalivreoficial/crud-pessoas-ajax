<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PessoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pessoa')->insert([
            [
                'id' => 1,
                'pais_id' => 1,
                'nome' => 'Roberto Júnior',
                'genero' => 'Masculino',
                'nascimento' => '1980-12-30',
            ],
            [
                'id' => 2,
                'pais_id' => 1,
                'nome' => 'Horácio Júnior',
                'genero' => 'Masculino',
                'nascimento' => '1980-12-30',
            ],
            [
                'id' => 3,
                'pais_id' => 1,
                'nome' => 'Manuela Moura',
                'genero' => 'Feminino',
                'nascimento' => '1980-12-30',
            ],
        ]);
    }
}
