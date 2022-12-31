<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollItem extends Model
{
    use HasFactory, SoftDeletes;

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
    protected $table = 'payroll_items';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'payroll_id',
        'subject',
        'description',
        'rate',
        'hours',
        'day',
        'total',
    ];

    public static function keys(): array
    {
        return [
            'id',
            'payroll_id',
            'subject',
            'description',
            'rate',
            'day',
            'hours',
            'total',
        ];
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
