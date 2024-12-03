<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingRecipient extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'outgoing_recipients';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'outgoing_mail_id',
        'recipient_unit_id',
        'sender_id',
        'recipient_id',
        'recipient_type',
        'status',
        'status_read',
        'read_at'
    ];

    public function outgoingMail()
    {
        return $this->belongsTo(OutgoingMail::class, 'outgoing_mail_id', 'id');
    }
}
