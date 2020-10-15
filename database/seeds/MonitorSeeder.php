<?php

use Illuminate\Database\Seeder;
use App\Monitor;

class MonitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Monitor::class, 3)->create();
    }
}
