<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalMail extends Model
{

    public $timestamps = true;
    public $fillable = [
        'classification_id',
        'priority_id',
        'external_type_id',
        'agenda_number',
        'agenda_date',
        'letter_number',
        'letter_date',
        'subject',
        'from_user',
        'from_user_id',
        'from_user_departments_id',
        'from_ext',
        'forwarded_to',
        'forwarded_to_id',
        'forwarded_to_departments_id',
        'forwarded_date',
        'description',
        'file_pdf',
        'status',
        'user_id',
    ];

    protected $table = 'external_mails';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function externalDisposition(): HasMany
    {
        return $this->hasMany(ExternalMailDisposition::class);
    }
}
