<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  protected $fillable = [
        'schools_id', 'teachers_id', 'position_lesson_num', 'position_name'
    ];
}
