<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'start',
        'end',
        'in_creature',
        'id__session',
        'backgroundColor'
    ];
}
