<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartCustom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'product_id'
    ];

    public function products(){
        return $this->belongsTo(Products::class,'product_id','id');
        // return $this->hasMany('Products', 'product_id', 'id');
    }



    public function user(){
        // return $this->hasOne(User::class);
        return $this->belongsTo(User::class, 'user_id','id');
        
    }
}
