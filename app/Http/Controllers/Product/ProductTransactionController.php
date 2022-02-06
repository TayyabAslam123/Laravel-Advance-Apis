<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //JUST FOR TEST I FETCHED BUYER ALSO , HAHA

        // $transactions = $product->transaction()->with('buyer')->get();
        // $msg = "product transactions fetched";
        // return response()->json(['message'=>'data received','data'=>$transactions],200);
        // return $this->showAll($msg,$transactions);      

        $transactions = $product->transaction;
        $msg = "product transactions fetched";
        return response()->json(['message'=>'data received','data'=>$transactions],200);
        return $this->showAll($msg,$transactions);
    }

 
}
