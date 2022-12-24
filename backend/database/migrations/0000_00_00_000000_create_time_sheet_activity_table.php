<?php

use App\Enums\TimeSheetActivityStatus;
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
        Schema::create('time_sheet_activities', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id');

            $table->string('title', 200);

            $table->string('description', 500);

            $table->enum('status', [
                TimeSheetActivityStatus::ON_REVIEW,
                TimeSheetActivityStatus::APPROVED,
                TimeSheetActivityStatus::REJECTED,
            ])->default(TimeSheetActivityStatus::ON_REVIEW);

            $table->dateTime('start_time')->nullable();

            $table->dateTime('end_time')->nullable();

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
        Schema::dropIfExists('time_sheet_activities');
    }
};
