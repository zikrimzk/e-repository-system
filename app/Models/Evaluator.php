<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluator extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'staff_id',
        'activity_id',
        'eva_role',
        'eva_status',
        'eva_doc',
    ];
}
