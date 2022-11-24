<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('product.index');
        } catch (\Exception $e) {
            return redirect()->back();
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
        $request->validate([
        'name' => ['required']
        ]);

        try {
            if(!Product::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->first()){
              $product = new Product;
              $product->name = $request->name;
              $product->save();
              return redirect()->route('product.index')->with('success', 'Data has been saved successfully!');
            }else{
              return redirect()->back()->with('error', $request->name.' already exist.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'name' => ['required']
        ]);

        try {
            if(!Product::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->first()){
              $product = Product::find($id);
              $product->name = $request->name;
              $product->save();
              return redirect()->route('product.index')->with('success', 'Data has been updated successfully!');
            }else{
              return redirect()->back()->with('error', $request->name.' already exist.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Data has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function getData(Request $request)
    {
        $data = [];
        //?data=all
        $data = Product::orderby('id','desc')->get();
        

        return response()->json($data);
    }
}
