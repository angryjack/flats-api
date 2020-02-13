<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['city_id' => 1, 'title' => 'Район 1'],
            ['city_id' => 2, 'title' => 'Район 2'],
            ['city_id' => 2, 'title' => 'Район 3'],
            ['city_id' => 3, 'title' => 'Район 4'],
            ['city_id' => 3, 'title' => 'Район 5'],
        ];

        foreach ($data as $district) {
            \App\Models\District::create([
                'city_id' => $district['city_id'],
                'title' => $district['title']
            ]);
        }
    }
}
