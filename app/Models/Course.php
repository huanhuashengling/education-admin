<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'schools_id', 'course_name', 'weight_value', 'basic_order'
    ];
}
