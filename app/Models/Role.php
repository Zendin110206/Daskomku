<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'avatar_url',
        'photo_character_url',
        'photo_profile_url',
        'quota',
    ];

    public function caas()
    {
        return $this->hasMany(Caas::class);
    }
}
