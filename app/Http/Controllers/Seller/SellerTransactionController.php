<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transaction = $seller
        ->products()
        ->whereHas('transaction')
        ->with('transaction')
        ->get()
        ->pluck('transaction')
        ->collapse();
         $msg = "data fetched";
        // return response()->json(['message'=>'data received','data'=>$transaction],200);
        return $this->showAll($msg,$transaction);
    }

}
