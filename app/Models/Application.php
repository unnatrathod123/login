<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
        //use HasFactory;
        protected $fillable = [
        'name',
        'email',
        'phone',
        'college',
        'degree',
        'domain',
        'skills',
        'resume_path',
        'status',
        
    ];

    public const STATUS_APPLIED   = 'applied';
    public const STATUS_INTERVIEW = 'interview';
    public const STATUS_SELECTED  = 'selected';

    public static function statuses(): array
    {
        return [
            self::STATUS_APPLIED   => 'Applied',
            self::STATUS_INTERVIEW => 'Interview',
            self::STATUS_SELECTED  => 'Selected',
        ];
    }
}
