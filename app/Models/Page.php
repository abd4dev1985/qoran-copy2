<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['juz_id'];
    protected $guarded = [];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class);
    }
    public function surahs()
    {
        return $this->belongsToMany(Surah::class);
    }
    public function juz()
    {
        return $this->belongsTo(Juz::class);
    }
}
