<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{

    protected $table = 'units';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'level',
        'parent_id',
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

    public function getCreatedAtAttribute()
    {
        return date('d F Y, H:i', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i', strtotime($this->attributes['updated_at']));
    }
    public function user()
    {
        return $this->hasMany(User::class, 'unit_id');
    }
}
