<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\CategoryTransformer;
class Category extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    
    protected $fillable=[
        'name',
        'description'
    ];

    protected $hidden = [
        'pivot'
    ];
    public $transformer = CategoryTransformer::class;
    ##ACCESSOR
    public function getNameAttribute($name){
        $name='category-'.$name;
        return strtoupper($name);
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }



}
