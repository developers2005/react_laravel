<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all()->sortByDesc("id");
        $results = [];
        if($data)
        {
            foreach ($data as $key => $value) {
              $value->file_path =  env('APP_URL').'/'.$value->file_path;
              array_push($results, $value);
            }
            // return json_decode($data);
            return response()->json(['message' => 'Data found','data'=>$results], 201);
        }else{
            return response()->json(['message' => 'Data not found'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $input = $request->except('file_path');
        $input['file_path'] =  $request->file('file_path')->store('products');
        
        $store = Product::create($input);
        if($store)
        {
            return response()->json(['message' => 'Data inserted','data'=>$store], 201);
        }else{
            return response()->json(['message' => 'Data not stored'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = $product;
        if($data)
        {
            return response()->json(['message' => 'Data found','data'=>$data], 201);
        }else{
            return response()->json(['message' => 'Data not found'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->except('file_path');
        if($request->file('file_path') && $request->file('file_path') != '')
        {
            $input['file_path'] =  $request->file('file_path')->store('products');
        }
       $update=  $product->update($input);
        if($update)
        {
            return response()->json(['message' => 'Data updated'], 201);
        }else{
            return response()->json(['message' => 'Data not updated'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $check = $product->delete();
        if($check)
        {
            return response()->json(['message' => 'Data deleted'], 201);
        }else{
            return response()->json(['message' => 'Data not deleted'], 401);
        }
    }

    public function search($data)
    {
        $data = Product::where('name','LIKE',"%$data%")->get();
        // print_r($data);exit();
        $results = [];
        if($data)
        {
            foreach ($data as $key => $value) {
              $value->file_path =  env('APP_URL').'/'.$value->file_path;
              array_push($results, $value);
            }
            return response()->json(['message' => 'Data found','data'=>$results], 201);
        }else{
            return response()->json(['message' => 'Data not found'], 401);
        }
    }
}
