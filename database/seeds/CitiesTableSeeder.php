<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Москва', 'Казань', 'Краснодар'];

        foreach ($data as $title) {
            \App\Models\City::create($title);
        }
    }
}
