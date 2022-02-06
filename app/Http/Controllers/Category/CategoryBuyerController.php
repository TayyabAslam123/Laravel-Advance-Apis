<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $category = $category->products()
        ->whereHas('transaction.buyer')
        ->with('transaction.buyer')
        ->get()
        ->pluck('transaction')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();
        $msg = 'data received';
        return $this->showall($msg,$category);
}

}
