<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Vendor;
use Illuminate\Http\Request;
use App\Model\Purchase;
use App\Model\Ingredient;
use App\Model\ReturnPurchase;
use App\Model\ReturnPurchaseIngredientItem;
use Brian2694\Toastr\Facades\Toastr;

class ReturnPurchaseController extends Controller
{
    public function index() {
        $returnPurchases = ReturnPurchase::select('return_purchase.*', 'purchases.invoice', 'vendors.name', 'vendors.mobile')
                                            ->leftJoin('purchases', 'return_purchase.purchase_id', '=', 'purchases.id')
                                            ->leftJoin('vendors', 'purchases.vendor_id', '=', 'vendors.id')
                                            ->latest()
                                            ->get();
        return view('admin-views.return-purchase.index', compact('returnPurchases'));
    }

    public function add() {
        $vendors = Vendor::where('status', '1')->orderBy('name', 'asc')->get();
        $ingredients = Ingredient::where('status', '1')->orderBy('name', 'asc')->get();
        return view('admin-views.return-purchase.add', compact('vendors'));
    }

    public function edit(Request $request) {
        $request->validate([
            'vendor_id' => 'required',
            'invoice' => 'required'
        ]);

        $vendor_id = $request->vendor_id;
        $invoice = $request->invoice;
        $purchaseIngredients = Purchase::select('purchases.*', 'purchases_ingredient_items.id as purchases_ingredient_items_id', 'purchases_ingredient_items.ingredient_details', 'purchases_ingredient_items.quantity', 'purchases_ingredient_items.rate')
                                        ->leftJoin('purchases_ingredient_items', 'purchases.id', '=', 'purchases_ingredient_items.purchase_id')
                                        ->where('purchases.vendor_id', '=', $request->vendor_id)
                                        ->where('purchases.invoice', '=', $request->invoice)
                                        ->get();

        $vendors = Vendor::where('status', '1')->orderBy('name', 'asc')->get();
        $ingredients = Ingredient::where('status', '1')->orderBy('name', 'asc')->get();
        return view('admin-views.return-purchase.add', compact('vendors', 'purchaseIngredients', 'ingredients', 'vendor_id', 'invoice'));
    }

    public function store(Request $request) {        
        if(isset($request->return_ingredients)) {
            if(count($request->return_ingredients) > 0) {
                $purchase_id = $request->purchase_id;

                $return_purchase = new ReturnPurchase();
                $return_purchase->purchase_id = $purchase_id;
                $return_purchase->note = isset($request->note) ? $request->note : '';
                $return_purchase->save();
                $return_purchase_id = $return_purchase->id;

                for($i = 0; $i < count($request->return_ingredients); $i++) {
                   $index = array_keys($request->return_ingredients)[$i];
                   $return_ingredients_id = $items = $quantitys = '';

                   $return_ingredients_id = $request->return_ingredients[$index];
                   $items = $request->items[$index];
                   $quantitys = $request->quantitys[$index];

                   $return_purchase_ingredient_item = new ReturnPurchaseIngredientItem();
                   $return_purchase_ingredient_item->return_purchase_id = $return_purchase_id;
                   $return_purchase_ingredient_item->purchase_ingredient_id = $return_ingredients_id;
                   $return_purchase_ingredient_item->return_quantity = $quantitys;
                   $return_purchase_ingredient_item->save();

                   $ingredient = Ingredient::find($items);
                   $ingredient->quantity = $ingredient->quantity - $quantitys;
                   $ingredient->update();
                }
            } 
            Toastr::success('Return Purchase added successfully');
            return redirect('admin/return-purchase');
        } else {
            Toastr::error('Please select atleast one ingredient');
            return redirect('admin/return-purchase/add');
        }
    }

    public function view($id) {
        $returnPurchaseIngredientItems = ReturnPurchaseIngredientItem::select('return_purchase_ingredient_items.*', 'purchases_ingredient_items.ingredient_details', 'purchases_ingredient_items.rate')
            ->leftJoin('purchases_ingredient_items', 'purchases_ingredient_items.id', '=', 'return_purchase_ingredient_items.purchase_ingredient_id')
            ->where('return_purchase_ingredient_items.return_purchase_id', $id)
            ->get(); 

        $returnPurchase = ReturnPurchase::select('purchases.invoice', 'vendors.name', 'return_purchase.created_at', 'return_purchase.note')
                                    ->leftJoin('purchases', 'purchases.id', '=', 'return_purchase.purchase_id')
                                    ->leftJoin('vendors', 'vendors.id', '=', 'purchases.vendor_id')
                                    ->where('return_purchase.id', $id)
                                    ->get();

        return view('admin-views.return-purchase.view', compact('returnPurchaseIngredientItems', 'returnPurchase'));
    }

    
    public function returnEdit($id) {
        $returnPurchase_id = ReturnPurchase::find($id);
        $editpurchasedetail = Purchase::find($returnPurchase_id->purchase_id);
         
        $returnPurchaseIngredientItems = ReturnPurchaseIngredientItem::select('return_purchase_ingredient_items.*', 'purchases_ingredient_items.ingredient_details'
        ,'purchases_ingredient_items.rate','purchases_ingredient_items.quantity')
        ->leftJoin('purchases_ingredient_items', 'purchases_ingredient_items.id', '=', 'return_purchase_ingredient_items.purchase_ingredient_id')
        ->where('return_purchase_ingredient_items.return_purchase_id', $id)
        ->get(); 

        $returnPurchase = ReturnPurchase::select('purchases.invoice','vendors.name','return_purchase.created_at','return_purchase.note','purchases_ingredient_items.rate')
        ->leftJoin('purchases', 'purchases.id', '=', 'return_purchase.purchase_id')
        ->leftJoin('vendors', 'vendors.id', '=', 'purchases.vendor_id')
        ->leftJoin('purchases_ingredient_items', 'purchases_ingredient_items.purchase_id', '=', 'return_purchase.purchase_id')
        ->where('return_purchase.id', $id)
        ->get();
        //return $returnPurchase;
       // $vendors = Vendor::where('status', '1')->orderBy('name', 'asc')->get();
        $ingredients = Ingredient::where('status', '1')->orderBy('name', 'asc')->get();

        return view('admin-views.return-purchase.return-edit', compact('editpurchasedetail','ingredients','returnPurchaseIngredientItems', 'returnPurchase'));
    }

    public function update(Request $request, $id) {
        
        $return_purchase = ReturnPurchase::where('purchase_id', $id)->firstOrFail();
       
        if(isset($request->return_ingredients)) {
            if(count($request->return_ingredients) > 0) {
                $purchase_id = $request->purchase_id;
                $return_purchase = ReturnPurchase::where('purchase_id', $id)->firstOrFail();
                $return_purchase_id = $return_purchase->id;
                $return_purchase->note = isset($request->note) ? $request->note : '';
                $return_purchase->update();

                for($i = 0; $i < count($request->return_ingredients); $i++) {
                    $index = array_keys($request->return_ingredients)[$i];
                    $return_ingredients_id = $items = $quantitys = '';
                    
                    $return_ingredients_id = $request->return_ingredients[$index];
                    $items = $request->items[$index];
                    $quantitys = $request->quantitys[$index];

                    $return_purchase_ingredient_item = ReturnPurchaseIngredientItem::where('return_purchase_id', $return_purchase_id)
                    ->where('purchase_ingredient_id', $return_ingredients_id)
                    ->first();

                    if (!$return_purchase_ingredient_item) {
                        $return_purchase_ingredient_item = new ReturnPurchaseIngredientItem();
                        $return_purchase_ingredient_item->return_purchase_id = $return_purchase_id;
                        $return_purchase_ingredient_item->purchase_ingredient_id = $return_ingredients_id;
                    }
                    
                    // Update return_quantity
                    $return_purchase_ingredient_item->return_quantity = $quantitys;
                    
                    $Check_quantity_return_purchase_ingredient_item = ReturnPurchaseIngredientItem::where('return_purchase_id', $return_purchase_id)
                    ->where('purchase_ingredient_id', $return_ingredients_id)
                    ->first();
                    $ingredient = Ingredient::find($items);
                    
                    $check_quantity = $Check_quantity_return_purchase_ingredient_item->return_quantity;

                    if ($quantitys < $check_quantity) {
                        $final_qty = $check_quantity - $quantitys;
                        $ingredient->quantity = $ingredient->quantity + $final_qty;
                         $ingredient->update();
                        //return $ingredient->quantity;
                    } elseif ($quantitys == $check_quantity) {
                        $ingredient->quantity = $ingredient->quantity;
                         $ingredient->update();
                        //return $ingredient->quantity;
                    } else {
                        $final_qty = $quantitys - $check_quantity;
                        $ingredient->quantity = $ingredient->quantity - $final_qty;
                         $ingredient->update();
                       // return $ingredient->quantity;
                    }

                   $return_purchase_ingredient_item->save();
                    
                 }
            } 
            Toastr::success('Return Purchase Update successfully');
            return redirect('admin/return-purchase');
        } else {
            Toastr::error('Please select atleast one ingredient');
            return back();
        }
    }

    public function CancelReturnPurchase($id)
    {
        $returnPurchase = ReturnPurchase::findOrFail($id);
        $returnPurchase->status = 1;
        $returnPurchase->update();

       $returnPurchaseIngredientItems = ReturnPurchaseIngredientItem::select('return_purchase_ingredient_items.*', 'purchases_ingredient_items.ingredient_details')
            ->leftJoin('purchases_ingredient_items', 'purchases_ingredient_items.id', '=', 'return_purchase_ingredient_items.purchase_ingredient_id')
            ->where('return_purchase_ingredient_items.return_purchase_id', $id)
            ->get(); 

        foreach ($returnPurchaseIngredientItems as $item) {
           
           $ingredientDetails = $item->ingredient_details;
           $decodedIngredient = json_decode($ingredientDetails, true);
           $ingredientId = $decodedIngredient['id'];
            $returnedQuantity = $item->return_quantity; 
            $ingredient = Ingredient::find($ingredientId);
           
            if ($ingredient) {
                $sub_total_qty= $ingredient->quantity;
                $ingredient->quantity = $sub_total_qty + $returnedQuantity;
              //  return $ingredient->quantity;
                $ingredient->update();
            }
        }

        Toastr::success('Return purchase cancelled successfully');
        return redirect('admin/return-purchase');

    }

}
