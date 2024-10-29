<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'prog_code',
        'prog_name',
        'fac_id',
        'prog_mode',

    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
