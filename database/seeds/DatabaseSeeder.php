<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // This becomes the installation seeding
        // $this->call('Database\Seeds\KBLISMinimalSeed');

        // Below is developement seeding
        $this->call('Database\Seeds\CultureSensitivitySeeder');
        $this->call('Database\Seeds\KBLISSeeder');
        $this->call('Database\Seeds\SurveillanceSeeder');
        $this->call('Database\Seeds\TestDataSeeder');
    }
}