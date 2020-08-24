<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
  protected $fillable = [
        'schools_id', 'teacher_name', 'gender', 'birth_date', 'cross_head_lesson_num', 'default_courses_id'
    ];
}
