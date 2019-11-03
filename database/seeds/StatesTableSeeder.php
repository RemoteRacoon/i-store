<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $states = [
        'available',
        'pending',
        'confirmed'
    ];

    public function run()
    {
        DB::table('states')->insert([
            'state' => $this->states[0]
        ]);
        DB::table('states')->insert([
            'state' => $this->states[1]
        ]);
        DB::table('states')->insert([
            'state' => $this->states[2]
        ]);
    }
}
