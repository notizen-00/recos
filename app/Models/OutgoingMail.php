<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingMail extends Model
{

    protected $table = 'outgoing_mails';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
