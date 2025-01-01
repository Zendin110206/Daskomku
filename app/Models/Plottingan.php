<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plottingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'user_id',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
