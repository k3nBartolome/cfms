<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(SitesTableSeeder::class);
        $this->call(ProgramsTableSeeder::class);

        $this->call(DateRangesTableSeeder::class);
        $this->call(SiteSeederAdd::class);
        $this->call(CopyDataSeeder::class);
        //$this->call(ClassesSeeder::class);
    }
}

