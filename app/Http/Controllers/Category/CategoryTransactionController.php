<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $category = $category->products()
        ->whereHas('transaction')
        ->with('transaction')->get()->pluck('transaction')->collapse();
        $msg = 'data received';
        return $this->showall($msg,$category);
    }

}
