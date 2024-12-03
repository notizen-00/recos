<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgSubject extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'org_subjects';
    protected $fillable = [
        'id',
        'name',
        'code'
    ];
    protected $dates = ['deleted_at'];

    public function outgoingMail()
    {
        return $this->hasMany(OutgoingMail::class, 'org_subject_id', 'id');
    }
}
