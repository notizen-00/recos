<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bod extends Model
{
    public $timestamps = true;
    protected $table = 'bod';
    protected $fillable = [
        'title'
    ];
}
