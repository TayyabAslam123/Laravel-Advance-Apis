<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        return view('test');
    } 
 
    public function upload(Request $request){
        $img = $request->mybase64;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file =  uniqid() . '.png';
        $success = file_put_contents($file, $data);

        return $success;
    } 

    public function cropImage(){
        return view('crop');
    }
}
