<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = ['id'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'detail_department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'created_at' => 'datetime: d F Y',
        ];
    }

    public function getCreatedAtAttribute()
    {
        return date('d F Y, H:i', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i', strtotime($this->attributes['updated_at']));
    }

    public function getEmailVerifiedAtAttribute()
    {
        return $this->attributes['email_verified_at'] == null ? null : date('d-m-Y H:i', strtotime($this->attributes['email_verified_at']));
    }

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function ($pr) {
            return [$pr['name'] => true];
        });
    }

    public function detail_department()
    {
        return $this->belongsTo(DetailDepartment::class, 'detail_department_id');
    }

    public function scopeWhereBodIn($query, array $bodArray)
    {
        return $query->whereHas('detail_department', function ($query) use ($bodArray) {
            $query->whereIn('bod_id', $bodArray);
        });
    }

    public function outgoing_recipient()
    {
        return $this->hasMany(OutgoingRecipient::class, 'recipient_id');
    }

}
