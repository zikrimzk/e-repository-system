<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelNomination extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_status',
        'nom_document',
        'nom_date',
        'student_id',
        'activity_id'
    ];
}
