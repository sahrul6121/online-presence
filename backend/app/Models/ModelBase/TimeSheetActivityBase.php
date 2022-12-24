<?php

namespace App\Models\ModelBase;

use App\Models\TimeSheetActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TimeSheetActivityBase
 * @package App\Models\ModelBase
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $start_time
 * @property string $end_time
 */
class TimeSheetActivityBase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'time_sheet_activities';

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

        'description',

        'status',

        'start_time',

        'end_time',

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

            'title',

            'description',

            'status',

            'start_time',

            'end_time',

        ];
    }


}
