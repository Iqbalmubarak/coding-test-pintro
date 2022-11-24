<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Http\Resources\inventoryList as inlist;
use Sentinel;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::pluck('name','id');
        $unit = Unit::pluck('name','id');
        try {
            return view('inventory.index', compact('product','unit'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::pluck('name','id');
        $unit = Unit::pluck('name','id');
        $supplier = Supplier::pluck('name','id');
        $supplier = $supplier->push('Lainnya');
        try {
            return view('inventory.create', compact('product','unit','supplier'));
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
            'unit' => 'required',
            'product' => 'required',
            'total' => 'required',
            'supplier' => 'required',
            'date' => 'required'
        ]);
        
        try {
            $inventory = Inventory::where('product_id',$request->product)->where('unit_id',$request->unit);
            if($inventory->get()->count() > 0){
                $inventory = $inventory->first();
            }else{
                $inventory = new inventory;
                $inventory->product_id = $request->product;
                $inventory->unit_id = $request->unit;
                $inventory->save();
            }

            $supplier = $request->supplier;
            $inventoryDetailOld = InventoryDetail::where('inventory_id',$inventory->id)->where('supplier_id',$supplier)->where('date',$request->date)->first();
            if($inventoryDetailOld){
                $inventoryDetailOld->total = $inventoryDetailOld->total + $request->total;
                $inventoryDetailOld->update();
            }else{
                if(Supplier::get()->Count() < $supplier){
                    $request->validate([
                        'supplier_lain' => ['required']
                    ]);

                    if($request->supplier_lain=="xxx"){
                        return redirect()->back()->with('error', 'Please input supplier correctly');
                    }
                    $supplier = supplier::create(['name'=>$request->supplier_lain]);
                    $supplier = $supplier->id;
                    // dd($supplier);
                }
                $inventoryDetail = new InventoryDetail;
                $inventoryDetail->inventory_id = $inventory->id;
                $inventoryDetail->supplier_id = $supplier;
                $inventoryDetail->user_id = Sentinel::getUser()->id;
                $inventoryDetail->date = $request->date;
                $inventoryDetail->total = $request->total;
                $inventoryDetail->save();
            }
            return redirect()->route('inventory.index')->with('success', 'Data has been saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::pluck('name','id');
            $unit = Unit::pluck('name','id');
            $supplier = Supplier::pluck('name','id')->union(['xxx'=>'Lainnya']);
            $inventory = Inventory::find($id);
            return view('inventory.show', compact('inventory','product','unit','supplier'));
        } catch (\Exception $e) {
            return redirect()->back();
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
            'product' => 'required',
            'unit' => 'required'
        ]);

        try {
            $inventory = inventory::where('product_id',$request->product)->where('unit_id',$request->unit)->where('id','<>',$id);
            if($inventory->get()->count() > 0){
                return redirect()->back()->with('warning','This inventory already exist. Please update with new inventory!');
            }
            $inventory = inventory::find($id);
            $inventory->product_id = $request->product;
            $inventory->unit_id = $request->unit;
            $inventory->update();

            return redirect()->back()->with('success', 'Data has been updated successfully!');;
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
            $inventory = inventory::find($id);

            if(!$inventory){
            return redirect()->back()->with('error', 'Data Not Found');
            }

            $inventory->delete();
            return redirect()->back()->with('success', 'Data has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function getData(Request $request)
    {
        try {
            $data = [];
            $data = Inventory::orderby('id', 'desc')->get();

            if($data)return response()->json(inlist::collection($data));
            return $data;
        } catch (\Exception $e) {
            return [];
        }

    }
}
