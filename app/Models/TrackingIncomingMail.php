<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingIncomingMail extends Model
{

    protected $table = 'tracking_incoming_mails';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
