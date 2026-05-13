<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'anonymous',
        'category',
        'areas',
        'other_area',
        'public_servant_name',
        'public_servant_position',
        'public_servant_physical_description',
        'incident_day',
        'incident_month',
        'incident_year',
        'incident_time',
        'incident_location',
        'message',
        'witnesses',
        'has_evidence',
        'status',
        'attachments',
        'response',
        'responded_at',
        'responded_by',
    ];

    protected function casts(): array
    {
        return [
            'areas' => 'array',
            'attachments' => 'array',
            'responded_at' => 'datetime',
        ];
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
