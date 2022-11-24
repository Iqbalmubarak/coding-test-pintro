<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryDetail;
use App\Models\Supplier;
use Sentinel;

class InventoryDetailController extends Controller
{
    public function store(Request $request, $inventory_id){
        $request->validate([
            'total' => 'required',
            'supplier' => 'required',
            'date' => 'required'
        ]);
        
        try {
            $supplier = $request->supplier;
            $inventoryDetailOld = InventoryDetail::where('inventory_id',$inventory_id)->where('supplier_id',$supplier)->where('date',$request->date)->first();
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
                $inventoryDetail->inventory_id = $inventory_id;
                $inventoryDetail->supplier_id = $supplier;
                $inventoryDetail->user_id = Sentinel::getUser()->id;
                $inventoryDetail->date = $request->date;
                $inventoryDetail->total = $request->total;
                $inventoryDetail->save();
            }
            return redirect()->route('inventory.show', $inventory_id)->with('success', 'Data has been saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function update(Request $request, $inventory_id, $id){
        $request->validate([
            'total' => 'required',
            'supplier' => 'required',
            'date' => 'required'
        ]);
        
        try {
            $supplier = $request->supplier;
            $inventoryDetailOld = InventoryDetail::where('inventory_id',$inventory_id)->where('supplier_id',$supplier)->where('date',$request->date)->first();
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
                $inventoryDetail = InventoryDetail::find($id);
                $inventoryDetail->supplier_id = $supplier;
                $inventoryDetail->user_id = Sentinel::getUser()->id;
                $inventoryDetail->date = $request->date;
                $inventoryDetail->total = $request->total;
                $inventoryDetail->save();
            }
            return redirect()->route('inventory.show', $inventory_id)->with('success', 'Data has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            $inventoryDetail = InventoryDetail::find($id);

            if(!$inventoryDetail){
            return redirect()->back()->with('error', 'Data Not Found');
            }

            $inventoryDetail->delete();
            return redirect()->back()->with('success', 'Data has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }
}
