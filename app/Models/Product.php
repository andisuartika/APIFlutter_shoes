<?php

namespace App\Models;

use App\Models\categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo(categories::class,'index');
    }
}
