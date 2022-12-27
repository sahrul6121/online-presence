<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
   use HasFactory;

   protected $table = 'work_schedules';

   /**
    * The primary key for the model.
    *
    * @var string
    */
   protected $primaryKey = 'id';

   /**
    * Indicates if the IDs are auto-incrementing.
    *
    * @var bool
    */
   public $incrementing = false;

   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = true;

   protected $fillable = [
      'id',
      'clock_in',
      'clock_out'
   ];
}
