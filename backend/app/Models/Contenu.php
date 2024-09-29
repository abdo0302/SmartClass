<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'file',
        'date_creation',
        'in_classe',
        'typ_file',
        'in_creature',
    ];
}//end class
