<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'month_id', 'planned', 'remaining', 'is_fund'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
