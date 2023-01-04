<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tafseer extends Model
{
    use HasFactory;
    protected $fillable = ['all_myasar_text','ayah_id','jalalayn'];

    public function tafseer()
    {
        return $this->belongsTo(Ayah::class);
    }
}
