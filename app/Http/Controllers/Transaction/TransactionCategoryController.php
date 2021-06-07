<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $categories=$transaction->product->categories;
        $msg="Transaction Categories data Fetched Successfully";
        return $this->showall($msg,$categories);

    }

}
