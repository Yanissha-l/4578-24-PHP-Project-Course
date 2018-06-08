<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model{

    protected $table = 'study';

    protected $fillable = [
        'id',
        'student_id',
        'course_id'
    ];
}