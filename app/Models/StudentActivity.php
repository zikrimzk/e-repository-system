<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'activity_id',
        'ac_status',
        'ac_form',
        'ac_dateStudent',
        'ac_dateSv',
        'ac_dateAdmin',

    ];
}
