<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'startdate',
        'enddate',
        'status'
     
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    

}
