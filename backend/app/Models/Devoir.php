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
        'file',
        'typ_file',
        'in_classe',
        'in_creature'
    ];
}//end class
