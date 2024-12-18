<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    public $timestamps = true;
    protected $table = 'units';

    protected $fillable = [
        'title',
        'address',
        'latitude',
        'longitude',
        'radius',
    ];

    protected $appends = ['parentname'];

    protected $dates = ['deleted_at'];

    public function getParentNameAttribute()
    {
        $parentId = $this->attributes['parent_id'] ?? null;

        if ($parentId) {
            $parent = self::find($parentId);
            return $parent ? $parent->name : null;
        }

        return '-';
    }

    public function detail_department()
    {
        return $this->hasMany(DetailDepartment::class);
    }

    public function OutgoingRecipient()
    {
        return $this->hasMany(OutgoingRecipient::class, 'recipient_unit_id');
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
