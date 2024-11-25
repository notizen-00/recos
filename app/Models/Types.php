<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Types extends Model
{

    protected $table = 'types';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    public function subTypes()
    {
        return $this->hasMany(SubTypes::class, 'type_id');
    }

    
    public function getCreatedAtAttribute()
    {
        return date('d F Y, H:i', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i', strtotime($this->attributes['updated_at']));
    }

}