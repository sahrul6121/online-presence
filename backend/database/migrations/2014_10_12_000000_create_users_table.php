<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('users', function (Blueprint $table) {
         $table->id();
          $table->foreignId('role_id');
          $table->string('name');
          $table->string('code')->nullable();
          $table->string('address', 500)->nullable();
          $table->enum('gender', ['MALE', 'FEMALE']);
          $table->dateTime('join_date')->nullable();
          $table->bigInteger('base_salary')->nullable();
          $table->string('email')->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->string('bank');
          $table->string('bank_account');
          $table->rememberToken();
          $table->timestamps();
          $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('users');
   }
};
