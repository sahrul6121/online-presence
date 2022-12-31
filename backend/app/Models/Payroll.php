<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
   use HasFactory, SoftDeletes;

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
       'date',
       'sub_total',
       'tax',
       'total',
       'company',
       'company_address',
       'company_phone',
       'bank',
       'bank_account',
       'country',
   ];

   public static function keys(): array
   {
      return [
          'id',
          'user_id',
          'date',
          'sub_total',
          'tax',
          'total',
          'company',
          'company_address',
          'company_phone',
          'bank',
          'bank_account',
          'country',
      ];
   }

   public function user()
   {
      return $this->hasOne(User::class, 'id', 'user_id');
   }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }
}
