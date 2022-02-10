<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description','price'];

    protected $casts = [
        'price' => 'float',
    ];


     public function cartCustom(){
         return $this->hasOne(CartCustom::class);
     }
}
