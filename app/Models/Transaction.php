<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    
    }
}
