<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sinscrit extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_inscription',
        'in_eleve',
        'in_classe',
    ];
}//end class
