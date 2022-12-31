<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
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
       Role::query()->insert([
           'name' => 'Human Resource Division',
           'code' => 'HRD',
       ]);

       Role::query()->insert([
           'name' => 'Employee',
           'code' => 'EMP',
       ]);

       //      WorkSchedule::query()->insert([
       //         'clock_in' => '08:00:00',
       //         'clock_out' => '17:00:00'
       //      ]);

       // \App\Models\User::factory(10)->create();

       // \App\Models\User::factory()->create([
       //     'name' => 'Test User',
       //     'email' => 'test@example.com',
       // ]);
   }
}
