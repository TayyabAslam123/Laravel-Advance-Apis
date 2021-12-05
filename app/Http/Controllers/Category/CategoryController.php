<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Category;
use App\Traits\ApiResponser;

class CategoryController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        $count = count($categories);
        $msg= $count.' Categories data Fetched Successfully';
        $code=200;
        return $this->showall($msg,$categories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $rules=[
            'name'=>'required',
            'description'=>'required',
        ]; 
        $this->validate($request,$rules);
        $category=Category::create($request->all());
        $msg="single Category Data";
        return $this->showone($msg,$category,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // $Id is required
        //$category=Category::whereId($id)->with('products')->get();
        //return response()->json(['message'=>'data received','data'=>$category],200);
             
        $msg="single Category Data";
        return $this->showone($msg,$category);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Category $category)
    {
        
        $category->fill($request->only([
        'name','description'
        ]));
        

         if ($category->isClean()) {
            return $this->errorResponse('You need to specify different values in case of update',422);
         };

        $category->save();

        $msg="Category updated";
        return $this->showone($msg,$category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        $msg="Category deleted";
        return $this->showone($msg,$category,200);


    }
}
