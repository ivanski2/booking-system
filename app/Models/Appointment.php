<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'appointment_datetime',
        'client_name',
        'client_egn',
        'description',
        'notification_type',
    ];


    public function getFormattedDatetimeAttribute(): string
    {
        return Carbon::parse($this->appointment_datetime)->format('d.m.Y H:i');
    }

}
