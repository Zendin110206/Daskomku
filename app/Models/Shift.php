<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'waktu',
        'kuota',
    ];

    public function plottingans()
    {
        return $this->hasMany(Plottingan::class);
    }
}
