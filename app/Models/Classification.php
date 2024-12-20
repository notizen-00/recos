<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classification extends Model
{

    protected $table = 'classifications';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function outgoing_mail()
    {
        return $this->hasMany(OutgoingMail::class);
    }
}
