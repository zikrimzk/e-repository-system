<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_name',
        'activity_id',
        'isShowDoc',
        'isRequired'
      
    ];
    public function activity(){

        return $this->belongsTo(Activity::class);
    }
}
