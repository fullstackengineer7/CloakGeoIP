<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameOne extends Model
{
    use HasFactory;

    protected $fillable = [
        'digit',
        'date',
        'bid',
        'user_id',
        'created_at'
    ];
}
