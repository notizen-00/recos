<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTypes extends Model
{

    public $timestamps = true;
    protected $table = 'sub_types';
    protected $fillable = [
        'type_id',
        'name',
        'letter_format',
        'form_type',
        'ttd_type',
        'bod'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function types()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function outgoing_mail()
    {
        return $this->hasMany(OutgoingMail::class);
    }

}