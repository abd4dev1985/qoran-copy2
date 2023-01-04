<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juz extends Model
{
    use HasFactory;
    protected $fillable = ['id'];

    public function pages()
    {
         return $this->hasMany(Page::class);
    }
}
