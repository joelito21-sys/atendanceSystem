<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreEnrollment extends Model
{
    protected $fillable = [
        'student_id_number',
        'student_name',
        'student_email',
        'parent_email',
        'subject_code',
        'section',
        'school_year',
        'semester',
    ];
}
