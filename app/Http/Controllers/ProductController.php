<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::take(6)->get();
        return view('load-more')->with(["products" => $products]);
    }

    public function loadMore(Request $request){
        if($request->ajax()){
            $currentResultCount=$request->currentResultCount;
            $take=6;
            $products=Product::skip($currentResultCount)->take($take)->get();
            return response()->json($products);
        }else{
            return response()->json('Direct Access Not Allowed!!');
        }
    }
}
