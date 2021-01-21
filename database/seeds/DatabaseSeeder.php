<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $this->call([
            // Administration
            RolesAndPermissionsSeeder::class,
            SuperAdminSeeder::class,
            // Application, need one user to be seed (created_by column with user's uuid)
            CountriesSeeder::class,
        ]);
    }
}
