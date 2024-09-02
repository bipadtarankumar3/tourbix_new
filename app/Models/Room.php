<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomAvailableDate;
use App\Models\Documents;
use App\Models\RoomType;

class Room extends Model
{
    use HasFactory;

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type');
    }

    public function availableDates()
    {
        return $this->hasMany(RoomAvailableDate::class, 'rad_room_id');
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'item_id')
        ->where('table_name', 'rooms');
    }

}
