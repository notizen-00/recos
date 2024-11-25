<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingMail extends Model
{

    protected $table = 'outgoing_mails';
    public $timestamps = true;

    public $fillable = [
        'sub_type_id',
        'priority_id',
        'classification_id',
        'no',
        'full_number',
        'subject',
        'content',
        'code',
        'mail_date',
        'mail_place',
        'sign_user',
        'user_id',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function subTypes()
    {
        return $this->belongsTo(SubTypes::class);
    }

    public function trackingOutgoingMails()
    {
        return $this->hasMany(TrackingOutgoingMail::class);
    }

}
