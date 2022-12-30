<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
   use HasFactory;

   protected $table = 'payrolls';

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
      'user_id',
      'salary'
   ];

   public static function keys(): array
   {
      return [
         'id',
         'user_id',
         'salary'
      ];
   }

   public function user()
   {
      return $this->hasOne(User::class, 'id', 'user_id');
   }
}
