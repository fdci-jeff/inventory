<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'category_code',
        'category_name'
    ];

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
