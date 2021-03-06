<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //change Product $product in argument , and below code inside function
        //$categories = $product->categories;
        // I have done this to get product with categories
        $categories = Product::where('id',$id)->with('categories')->get();
        $msg = "product categories fetched";
        return response()->json(['message'=>'data received','data'=>$categories],200);
        return $this->showAll($msg,$categories);     
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,Category $category)
    {
        //attach , sync , syncwithoutdetaching
       // $product->categories()->detach($category->id);
        $product->categories()->syncwithoutdetaching([$category->id]);
        return response()->json(['message'=>'Category added','data'=>$product->categories],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if(!$product->categories()->find($category->id)){
            return response()->json(['error'=>'The category and the product is not linked','code'=>422],200);
        }
        $product->categories()->detach([$category->id]);
        return response()->json(['message'=>'Category Removed','data'=>$product->categories],200);
        
    }
}
