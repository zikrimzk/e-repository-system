<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_doc',
        'submission_date',
        'submission_duedate',
        'submission_status',
        'submission_final_form',
        'student_id',
        'document_id',
    ];
}
