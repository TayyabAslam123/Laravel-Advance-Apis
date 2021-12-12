<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];

    const AVAILABLE='available';
    const UNAVAILABLE='unavailable';

    protected $fillable=[
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'

    ];

     ##ACCESSOR
     public function getNameAttribute($name){
        $name='product-'.$name;
        return strtoupper($name);
    }

    //check if product is available
    public function isAvailable(){
        return $this->status==Product::AVAILABLE;
    }

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function seller(){
        return $this->belongsTo('App\Seller');
    }
    
    public function transaction(){
        return $this->hasMany('App\Transaction');
    }
}
