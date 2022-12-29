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
      Schema::create('attendances', function (Blueprint $table) {

         $table->increments('id');

         $table->integer('user_id');

         $table->dateTime('date_in')->nullable();

         $table->dateTime('date_out')->nullable();

         $table->string('note', 500)->nullable();

         $table->enum('status', ['ON_TIME', 'LATE'])->nullable();

         $table->enum('type', ['NORMAL ', 'OVERTIME'])->nullable();

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
      Schema::dropIfExists('attendances');
   }
};
