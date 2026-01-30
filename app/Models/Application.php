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
        
    ];
}
