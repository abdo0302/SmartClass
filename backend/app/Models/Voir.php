<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voir extends Model
{
    use HasFactory;
    protected $fillable = [
        'in_user',
        'in_contenu',
    ];
}//end class
