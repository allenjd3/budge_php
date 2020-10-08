<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function setSpentAttribute($value) {
        $this->attributes['spent'] = $value * 100;
    }
}
