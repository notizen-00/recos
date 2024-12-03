<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionDepartment extends Model
{
    public $timestamps = true;
    protected $table = 'function_departments';
    protected $fillable = [
        'title'
    ];
}
