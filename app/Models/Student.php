<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Semester;
use App\Models\Programme;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'matricNo',
        'phoneNo',
        'gender',
        'status',
        'address',
        'role',
        'bio',
        'semester_id',
        'programme_id', 
        'password',
        'opcode', 
        'semcount', 
        'titleOfResearch'


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function semester(){

        return $this->belongsTo(Semester::class);
    }

    public function programme(){

        return $this->belongsTo(Programme::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'student_staff')->withPivot('supervision_role');
    }
}
