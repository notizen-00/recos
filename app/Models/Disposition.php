<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposition extends Model
{

    protected $table = 'dispositions';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
