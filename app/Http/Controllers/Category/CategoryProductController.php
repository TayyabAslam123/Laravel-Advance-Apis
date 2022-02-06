<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
       
        $category = $category->products;
      //  $category = Category::where('id',$id)->with('products')->get();
        
        $msg = "Date received";
        return response()->json(['message'=>$msg,'data'=>$category],200);
    }


}
