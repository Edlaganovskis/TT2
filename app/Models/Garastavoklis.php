<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garastavoklis extends Model
{
    protected $fillable = [
        'datums',
        'Gstavoklis',
        'sajutas',
        'iemesls',
        'piezimes',
        'user_id',
        'kalendars_id',
    ];
    public function user(){ // Attiecība
        return $this->belongsTo(User::class);
    }
    public function kalendars(){    // Attiecība
        return $this->belongsTo(kalendars::class);
    }
}
