<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityProgramme extends Model
{
    use HasFactory;

    protected $fillable = [
        'activities_id',
        'programmes_id',
        'act_seq',
        'timeline_sem',
        'timeline_week',
        'init_status',
        'is_haveEva',
        'meterial',


    ];
}
