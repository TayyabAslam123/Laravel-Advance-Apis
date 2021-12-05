<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions=Transaction::all();
        $count=count($transactions);
        $msg=$count." Transactions Fetched Successfully";
        return $this->showall($msg,$transactions);
    }




    public function show($id)
    {
        $transaction = Transaction::findorFail($id);
        $msg="Single Transaction Fetched Successfully";
        return $this->showone($msg,$transaction);

    }


}
