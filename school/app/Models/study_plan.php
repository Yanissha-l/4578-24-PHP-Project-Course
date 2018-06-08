<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study_Plan extends Model{

    protected $table = 'study_plan';

    protected $fillable = [
        'id',
        'student_id',
        'student_name',
        'course_id',
        'course_name'
    ];
}