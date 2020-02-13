<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CitiesTableSeeder');
        $this->call('DistrictsTableSeeder');
        $this->call('FlatsTableSeeder');
        $this->call('ResidentialBlocksTableSeeder');
        $this->call('BuildingTableSeeder');
    }
}
