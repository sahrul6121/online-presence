<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
   use HasFactory, SoftDeletes;

   protected $table = 'settings';

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
      'code',
      'value'
   ];
}
