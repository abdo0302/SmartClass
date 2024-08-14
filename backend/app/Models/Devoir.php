<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'date_creation',
        'in_creature',
        'in_classe',
    ];
}//end class
