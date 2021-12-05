<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
          $transactions = $buyer->transactions()->with('product')->get()->pluck('product');
          $msg = "data fetched";
          return $this->showall($msg,$transactions);
    }

  
}
