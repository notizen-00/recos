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
        'no',
        'full_number',
        'subject',
        'content',
        'code',
        'mail_date',
        'user_id',
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function subTypes()
    {
        return $this->belongsTo(SubTypes::class);
    }

}
