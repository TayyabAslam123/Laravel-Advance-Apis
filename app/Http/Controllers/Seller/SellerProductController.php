<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Seller;
use App\User;
use App\Product;
use Exception;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        $msg = "data fetched";
        return $this->showAll($msg,$products);
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
    public function store(Request $request,User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required'
        ];

        $this->validate($request,$rules);
        $data = $request->all();

        $data['status'] = Product::UNAVAILABLE;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        $msg = 'new product created';
        return $this->showone($msg,$product);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller ,Product $product)
    {
        $rules =[
            'quantity' => 'integer|min:1',
            'status' => 'in:'.Product::UNAVAILABLE .','.Product::AVAILABLE,
            //'image' => 'image'
        ];
        $this->validate($request,$rules);
        $this->checkSeller($seller,$product);


        $product['name'] = isset($request->name) ? $request->name : $product->name ;
        $product['description'] = isset($request->description) ? $request->name : $product->description ;
        $product['quantity'] = isset($request->quantity) ? $request->quantity : $product->quantity ;
        // $product->fill($request->intersect([
        //     'name',
        //     'description',
        //     'quantity'
        // ]));

        if($request->has('status')){
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories()->count() == 0){
                return response()->json(['error'=>'A active must have one category','code'=>409],200);
                // return $this->errorResponse('A active must have one category',409);
            }

        }

        if($request->hasfile('image')){
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

        if(!$product->isDirty()){
            return response()->json(['error'=>'You need to enter different values to update','code'=>422],200);
            // return $this->errorResponse('You need to enter different values to update',422);
        }

        $product->save();
        $msg = 'Product updated';
        return $this->showone($msg,$product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller,$product);
        $product->delete();
        Storage::delete($product->image);
        $msg = 'Product deleted';
        return $this->showone($msg,$product);
        
    }

    protected function checkSeller(Seller $seller,Product $product){
        if($seller->id != $product->seller_id){

            throw new HttpException(422,'The specific seller is not actual seller of thi product');
        }
    }
}
