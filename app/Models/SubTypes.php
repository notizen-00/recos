<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTypes extends Model
{

    protected $table = 'sub_types';

    protected $fillable =
        [
        'type_id',
        'name',
        'letter_format',
    ];

    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function types()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

}
