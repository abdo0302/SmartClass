<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class realise extends Model
{
    use HasFactory;
    protected $fillable=[
        'in_user','in_Devoir'
    ];
}//end class
