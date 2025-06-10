<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];
    public function user(){
        return $this->hasMany(User::class);
    }
}
