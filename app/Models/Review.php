<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'r_comment' ,
        'r_date',
        'staff_id' ,
        'stuact_id',
    ];
}
