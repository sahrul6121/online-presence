<?php

namespace App\Models\ModelBase;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttendanceBase
 * @package App\Models\ModelBase
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_in
 * @property string $date_out
 * @property string $note
 * @property string $status
 */
class AttendanceBase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

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

        'date_in',

        'date_out',

        'note',

        'status',

        'type',

    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    /**
     * @return string[]
     */
    public static function keys(): array
    {
        return [

            'id',

            'user_id',

            'date_in',

            'date_out',

            'note',

            'status',

            'type',

        ];
    }

    public function user(): HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
