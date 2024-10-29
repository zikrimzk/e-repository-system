<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_name',
        'form_doc',
        'form_appearance',
        'form_isShow',
        'activity_id',



    ];

}
