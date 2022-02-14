<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use DB;

class ProductBuyerTransactionController extends Controller
{
  
    public function store(Request $request,Product $product,User $buyer)
    {
       
    
        $rules = [
            'quantity' =>'required|integer|min:1'
        ];
        $this->validate($request,$rules);

        if($buyer->id == $product->seller_id){
            return response()->json(['error'=>'The buyer must be different then seller','code'=>409],200);
        }
        
        //if(!$buyer->isVerified()){
        if($buyer->verified != '1'){
            return response()->json(['error'=>'The buyer is not verified','code'=>409],200);
        }

        //if(!$product->seller_id->isVerified()){
        // if($product->seller_id->verified != '1'){
        //     return response()->json(['error'=>'The seller is not verified','code'=>409],200);
        // }

        if(!$product->isAvailable()){
            return response()->json(['error'=>'The poduct is not available','code'=>409],200);
        }

        if($product->quantity < $request->quantity){
            return response()->json(['error'=>'Not enough quantity','code'=>409],200);
        }
        
         return DB::Transaction(function() use ($request,$product,$buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return response()->json(['message'=>'Transaction added','data'=>$transaction],200);

        });

    }


}
