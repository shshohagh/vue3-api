<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'details',
        'price',
        'stock',
        'discount'
    ];

    public function reviews(){
        return $this->hasMany(Review::class);
    }


}
