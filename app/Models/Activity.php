<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'act_name'
    ];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
