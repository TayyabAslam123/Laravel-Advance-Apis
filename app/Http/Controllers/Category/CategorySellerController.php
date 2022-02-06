<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $category = $category->products()->with('seller')->get()->pluck('seller')->unique()->values();
        $msg = 'data received';
        return $this->showall($msg,$category);
      //  return response()->json(['message'=>$msg,'data'=>$category],200);
    }

}
