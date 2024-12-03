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
}