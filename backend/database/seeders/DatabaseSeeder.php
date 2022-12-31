<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\WorkSchedule;
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

      // \App\Models\User::factory(10)->create();

      // \App\Models\User::factory()->create([
      //     'name' => 'Test User',
      //     'email' => 'test@example.com',
      // ]);
   }
}
