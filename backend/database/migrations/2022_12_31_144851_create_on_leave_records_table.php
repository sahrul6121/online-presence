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
      Schema::create('on_leave_records', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('user_id');
         $table->string('title')->nullable();
         $table->date('start')->nullable();
         $table->date('end')->nullable();
         $table->boolean('all_day')->nullable();
         $table->string('calender')->nullable();
         $table->string('description')->nullable();
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
      Schema::dropIfExists('on_leave_records');
   }
};
