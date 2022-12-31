<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnLeaveRecord extends Model
{
   use HasFactory, SoftDeletes;

   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'on_leave_records';

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
   public $incrementing = true;

   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = true;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [

      'id',
      'user_id',
      'title',
      'start',
      'end',
      'all_day',
      'calender',
      'description',

   ];

   public static function keys(): array
   {
      return [

         'id',

         'user_id',

         'title',

         'start',

         'end',

         'all_day',

         'calender',

         'description',

      ];
   }

   public function user(): HasOne
   {
      return $this->hasOne(User::class, 'id', 'user_id');
   }
}
