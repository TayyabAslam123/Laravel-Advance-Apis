<?php

namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

private function successResponse($data,$code){
    return response()->json($data,$code);
}

private function errorResponse($message,$code){
    return response()->json(["error"=>$message,"code"=>$code],$code);
}

protected function showAll($msg,Collection $collection,$code=200){
    ##transformer
    if ($collection->isEmpty()) {
        return $this->successResponse(['data' => $collection], $code);
    }

    dd($collection);
    $transformer = $collection->first()->transformer;
    $collection = $this->transformData($collection, $transformer);
    return $this->successResponse($collection, $code);
    #end
    // return $this->successResponse(['message'=>$msg,'data'=>$collection],$code);
}

protected function showone($msg,Model $model,$code=200){
 
    $transformer = $model->transformer;
    $model = $this->transformData($model, $transformer);

    return $this->successResponse($model, $code);

    // return $this->successResponse(['message'=>$msg,'data'=>$model],$code);
}


protected function showMessage($msg,$code=200){
    return $this->successResponse(['data'=>$msg],$code);
}

protected function transformData($data, $transformer){

    $transformation = fractal($data, new $transformer);
    return $transformation->toArray();
}

}//







?>