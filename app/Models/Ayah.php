<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    use HasFactory;
    protected $fillable = ['body','ayah_number'];

    public function surah()
    {
        return $this->belongsTo(Surah::class);
    }

    public function tafseer()
    {
        return $this->hasOne(Tafseer::class);
    }
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

}
