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
      Schema::create('payrolls', function (Blueprint $table) {
          $table->id();
          $table->integer('user_id');
          $table->date('date');
          $table->bigInteger('sub_total');
          $table->bigInteger('tax');
          $table->bigInteger('total');
          $table->string('company');
          $table->string('company_address');
          $table->string('company_phone');
          $table->string('bank');
          $table->string('bank_account');
          $table->string('country');
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
      Schema::dropIfExists('payrolls');
   }
};
