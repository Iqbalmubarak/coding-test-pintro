<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutInventory;
use Sentinel;
use DB;

class OutInventoryController extends Controller
{
    public function store(Request $request, $inventory_id){
        $request->validate([
            'total' => 'required',
            'note' => 'required',
            'date' => 'required'
        ]);
        
        try {

            $in = DB::table('inventories')
            ->join('inventory_details','inventories.id','=','inventory_details.inventory_id')
            ->select('inventory_details.total')
            ->where('inventory_id',$inventory_id)
            ->get();

            $out = DB::table('inventories')
            ->join('out_inventories','inventories.id','=','out_inventories.inventory_id')
            ->select('out_inventories.total')
            ->where('inventory_id',$inventory_id)
            ->get();

            $sum = $in->sum('total') - $out->sum('total');

            if($request->total <= $sum){
                $outInventory = new OutInventory;
                $outInventory->inventory_id = $inventory_id;
                $outInventory->user_id = Sentinel::getUser()->id;
                $outInventory->date = $request->date;
                $outInventory->total = $request->total;
                $outInventory->note = $request->note;
                $outInventory->save();
                return redirect()->route('inventory.show', $inventory_id)->with('success', 'Data has been saved successfully!');
            }else{
                return redirect()->route('inventory.show', $inventory_id)->with('warning', 'Not enough stock');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function update(Request $request, $inventory_id, $id){
        $request->validate([
            'total' => 'required',
            'note' => 'required',
            'date' => 'required'
        ]);
        
        try {

            $in = DB::table('inventories')
            ->join('inventory_details','inventories.id','=','inventory_details.inventory_id')
            ->select('inventory_details.total')
            ->where('inventory_id',$inventory_id)
            ->get();

            $out = DB::table('inventories')
            ->join('out_inventories','inventories.id','=','out_inventories.inventory_id')
            ->select('out_inventories.total')
            ->where('inventory_id',$inventory_id)
            ->get();

            $sum = $in->sum('total') - $out->sum('total');

            if($request->total <= $sum){
                $outInventory = OutInventory::find($id);
                $outInventory->user_id = Sentinel::getUser()->id;
                $outInventory->date = $request->date;
                $outInventory->total = $request->total;
                $outInventory->note = $request->note;
                $outInventory->save();
                return redirect()->route('inventory.show', $inventory_id)->with('success', 'Data has been saved successfully!');
            }else{
                return redirect()->route('inventory.show', $inventory_id)->with('warning', 'Not enough stock');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }

    public function destroy($inventoris_id, $id)
    {
        try {
            $outInventory = OutInventory::find($id);

            if(!$outInventory){
            return redirect()->back()->with('error', 'Data Not Found');
            }

            $outInventory->delete();
            return redirect()->back()->with('success', 'Data has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong!');
        }
    }
}
