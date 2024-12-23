<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalMailDisposition extends Model
{

    public $timestamps = true;
    public $fillable = [
        'external_mail_id',
        'recipient_user',
        'recipient_user_id',
        'recipient_user_detail_departments_id',
        'follow_up_type_id',
        'follow_up_message',
    ];

    protected $table = 'external_mails_disposition';
}
