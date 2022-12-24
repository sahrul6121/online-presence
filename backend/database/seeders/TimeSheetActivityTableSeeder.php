<?php

namespace Database\Seeders;

use App\Models\TimeSheetActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSheetActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeSheetActivity::factory(1)->create();
    }
}
