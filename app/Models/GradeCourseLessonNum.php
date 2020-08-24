<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeCourseLessonNum extends Model
{
  protected $fillable = [
        'grade_num', 'courses_id', 'lesson_num'
    ];
}
