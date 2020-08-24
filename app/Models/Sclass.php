<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sclass extends Model
{
  protected $fillable = [
        'schools_id', 'class_name', 'class_num', 'head_teacher_id', 'second_teacher_id'
    ];
}
