<?php

use Illuminate\Database\Seeder;

class CarrosTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('carros')->insert([
            'modelo' => 'Clio',
            'cor' => 'Branco',
            'ano' => '2015',
            'preco' => '24500.00',
            'combustivel' => 'F',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
            ]);
        
        DB::table('carros')->insert([
            'modelo' => 'Pálio',
            'cor' => 'Vermelho',
            'ano' => '2010',
            'preco' => '12800.00',
            'combustivel' => 'G',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
            ]);

        DB::table('carros')->insert([
            'modelo' => 'Gol',
            'cor' => 'Cinza Metálico',
            'ano' => '2014',
            'preco' => '19200.00',
            'combustivel' => 'F',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
            ]);        
    }

}
