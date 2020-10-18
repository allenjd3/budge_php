<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
