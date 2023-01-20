<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satisfaction extends Model
{
    use HasFactory;

    public function guest() {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function booking() {
        return $this->belongsToMany(Booking::class, 'booking_id');
    }

    public function service() {
        return $this->belongsToMany(Service::class, 'service_id');
    }




}
