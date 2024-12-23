<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDepartment extends Model
{
    public $timestamps = true;
    protected $table = 'detail_departments';
    protected $fillable = [
        'title',
        'functiondep_id',
        'unit_id',
        'bod_id',
        'parent_id',
        'kode_organisasi',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function bod()
    {
        return $this->belongsTo(Bod::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function functiondep()
    {
        return $this->belongsTo(FunctionDepartment::class);
    }

    public function parentdep()
    {
        return $this->belongsTo(DetailDepartment::class, 'parent_id', 'id');
    }
}