<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function setPlannedAttribute($value) {
        $this->attributes['planned'] = $value * 100;
    }
}
