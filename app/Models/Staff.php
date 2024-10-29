<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "staff";

    protected $fillable = [
        'staffNo',
        'sname',
        'email',
        'sphoneNo',
        'password',
        'srole',
        'dep_id'
     
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_staff')->withPivot('supervision_role');
    }
    public function department(){

        return $this->belongsTo(Department::class);
    }
    
}
