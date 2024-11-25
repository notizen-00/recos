<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingMail extends Model
{

    protected $table = 'incoming_mails';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
