<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {

        $buyers = $seller
        ->products()
        ->whereHas('transaction')
        ->with('transaction.buyer')
        ->get()
        ->pluck('transaction')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();
        $msg = "data fetched";
        return response()->json(['message'=>'data received','data'=>$buyers],200);
        //return $this->showAll($msg,$categories);

    }

}
