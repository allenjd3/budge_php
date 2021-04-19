<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsvImport extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'delete_by'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
