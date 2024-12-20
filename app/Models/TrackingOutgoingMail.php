<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingOutgoingMail extends Model
{
    use HasFactory;

    protected $table = 'tracking_outgoing_mails';

    protected $fillable = [
        'outgoing_mail_id',
        'detail_department_id',
        'sender_id',
        'to',
        'status',
        'note',
        'read_at',
        'forward_date',
    ];

    protected static function booted()
    {
        static::addGlobalScope('defaultOrder', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc'); // Default order by `created_at` descending
        });
    }

    public function outgoing_mail()
    {
        return $this->belongsTo(OutgoingMail::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function detail_department()
    {
        return $this->belongsTo(DetailDepartment::class);
    }
}