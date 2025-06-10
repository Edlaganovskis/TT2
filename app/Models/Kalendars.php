<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kalendars extends Model
{
    protected $fillable = [
        'publisks',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function garastavoklis()
    {
        return $this->hasMany(garastavoklis::class);
    }
}
