<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingMail extends Model
{

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
        'sign_date',
        'sign_user_id',
        'user_id',
        'attachment',
        'attachment_file',
        'org_subject_id',
    ];
    protected $table = 'outgoing_mails';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function subTypes()
    {
        return $this->belongsTo(SubTypes::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    public function orgSubject()
    {
        return $this->belongsTo(OrgSubject::class);
    }

    public function trackingOutgoingMails()
    {
        return $this->hasMany(TrackingOutgoingMail::class);
    }

    public function outgoingRecipients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OutgoingRecipient::class);
    }

}
