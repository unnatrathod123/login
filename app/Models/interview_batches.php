<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class interview_batches extends Model
{
    //

    protected $fillable = [

        'title',
        'interview_date',
        'start_time',
        'end_time',
    ];
}
