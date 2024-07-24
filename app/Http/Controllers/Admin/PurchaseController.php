<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Vendor;
use App\Model\Ingredient;
use App\Model\Purchase;
use App\Model\PurchasesIngredientItem;
use App\Model\ReturnPurchase;
use Brian2694\Toastr\Facades\Toastr;

class PurchaseController extends Controller
{
    public function index() {
        $purchases = Purchase::with('vendorDetails')->latest()->get();
        return view('admin-views.purchase.index', compact('purchases'));
    }

    public function add() {
        $vendors = Vendor::where('status', '1')->orderBy('name', 'asc')->get();
        $ingredients = Ingredient::where('status', '1')->orderBy('name', 'asc')->get();
        return view('admin-views.purchase.add', compact('vendors', 'ingredients'));
    }

    public function store(Request $request) {

        $request->validate([
            'vendor_id' => 'required',
            'invoice' => 'required',
            'purchase_date' => 'required',
            'payment_type' => 'required',
        ]);

        if(isset($request->items)) {
            $purchase_details = Purchase::where('vendor_id', '=', $request->vendor_id)->where('invoice', '=', $request->invoice)->get();
            if(count($purchase_details) == 0) {
                $purchase = new Purchase();
                $purchase->vendor_id = $request->vendor_id;
                $purchase->invoice = $request->invoice;
                $purchase->purchase_date = $request->purchase_date;
                $purchase->payment_type = $request->payment_type;
                $purchase->note = $request->note;
                $purchase->save();
                $purchase_id = $purchase->id;  
                
                for($i = 0; $i < count($request->items); $i++) {
                    $ingredient_id = $request->items[$i];
                    $quantity = $request->quantitys[$i];
                    $rate = $request->rates[$i];
        
                    $ingredient_details = Ingredient::find($ingredient_id);
        
                    $purchase_ingredient_item = new PurchasesIngredientItem();
                    $purchase_ingredient_item->purchase_id = $purchase_id;
                    $purchase_ingredient_item->ingredient_details = json_encode($ingredient_details);
                    $purchase_ingredient_item->quantity = $quantity;
                    $purchase_ingredient_item->rate = $rate;
                    $purchase_ingredient_item->save();
        
                    $ingredient_details->quantity = $ingredient_details->quantity + $quantity;
                    $ingredient_details->update();
                }
        
                Toastr::success('Purchase added successfully');
                return redirect('admin/purchase');

            } else {
                Toastr::error('Invoice Number for this Vendor already exists');
                return back();
            }
        } else {
            Toastr::error('Please select atleast one ingredient');
            return back();
        }
    }

    public function view($id) {
        $purchase = Purchase::with('vendorDetails')->where('id',$id)->get();
        $purchasesIngredientItem = PurchasesIngredientItem::where('purchase_id', $id)->get();
        return view('admin-views.purchase.view', compact('purchase', 'purchasesIngredientItem'));
    }

    public function edit($id) {
        $vendors = Vendor::all();
        $purchase = Purchase::with('purchaseIngredientList')->where('id', '=', $id)->get();
        $ingredients = Ingredient::where('status', '=', '1')->get();
        return view('admin-views.purchase.edit', compact('vendors', 'purchase', 'ingredients'));
    }

    public function update(Request $request, $purchase_id) {        
        $puchase_details = Purchase::find($purchase_id);
        $vendor_id = $request->vendor_id;
        $purchase_date = $request->purchase_date;
        $note = $request->note;
        $invoice = $request->invoice;
        $payment_type = $request->payment_type;
        if(!empty($puchase_details) > 0) {
            $returnPurchase = ReturnPurchase::where('purchase_id', '=', $purchase_id)->where('status', '=', 0)->get();
            if(count($returnPurchase) == 0) {
                if(isset($request->items)) {
                    $purchases = Purchase::where('vendor_id', '=', $vendor_id)->where('invoice', '=', $invoice)->where('id', '<>', $purchase_id)->get();
                    if(count($purchases) == 0) {
                        $puchase_details->vendor_id = $vendor_id;
                        $puchase_details->purchase_date = $purchase_date;
                        $puchase_details->note = $note;
                        $puchase_details->invoice = $invoice;
                        $puchase_details->payment_type = $payment_type;
                        $puchase_details->save();
    
                        $purchaseIngredientItems_db = PurchasesIngredientItem::where('purchase_id', '=', $purchase_id)->get();
                        foreach($purchaseIngredientItems_db as $ingredientItem_db) {
                            $purchases_ingredient_items_id = $ingredientItem_db->id;
                            $purchases_ingredient_items_ingredient_id = json_decode($ingredientItem_db->ingredient_details)->id;
                            $purchases_ingredient_items_quantity = $ingredientItem_db->quantity;
    
                            $ingredint_detail = Ingredient::find($purchases_ingredient_items_ingredient_id);
                            $ingredint_detail->quantity = $ingredint_detail->quantity - $purchases_ingredient_items_quantity;
                            $ingredint_detail->save();
    
                            PurchasesIngredientItem::where('id','=',$purchases_ingredient_items_id)->delete();
                        }
    
                        for($i = 0; $i < count($request->items); $i++) {
                            $ingredient_id = $request->items[$i];
                            $quantity = $request->quantitys[$i];
                            $rate = $request->rates[$i];
                
                            $ingredient_details = Ingredient::find($ingredient_id);
                
                            $purchase_ingredient_item = new PurchasesIngredientItem();
                            $purchase_ingredient_item->purchase_id = $purchase_id;
                            $purchase_ingredient_item->ingredient_details = json_encode($ingredient_details);
                            $purchase_ingredient_item->quantity = $quantity;
                            $purchase_ingredient_item->rate = $rate;
                            $purchase_ingredient_item->save();
                
                            $ingredient_details->quantity = $ingredient_details->quantity + $quantity;
                            $ingredient_details->update();
                        }
                        Toastr::success('Purchase update successfully');
                        return redirect('admin/purchase');
                    } else {
                        Toastr::error('Invoice Number for this Vendor already exists');
                        return back();
                    }
                } else {
                    Toastr::error('Please select atleast one ingredient');
                    return back();
                }
            } else {
                Toastr::error('You can not edit this purchase becuase you have already created return purchase for this purchase.');
                return back();
            }
        } else {
            Toastr::error('Invalid purchase');
            return back();
        }
    }
}
