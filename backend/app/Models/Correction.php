<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'id_devoir',
        'file',
        'typ_file',
        'in_creature'
    ];
}
