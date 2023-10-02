<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'image', 'price', 'quantity'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}