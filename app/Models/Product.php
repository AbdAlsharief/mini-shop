<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'user_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        $this->belongsTo(Category::class);
    }
}
