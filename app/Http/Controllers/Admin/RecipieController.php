<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Ingredient;
use App\Model\Recipie;
use App\Model\RecipieIngredient;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class RecipieController extends Controller
{
    public function index() {
        $recipies = Recipie::latest()->get();
        return view('admin-views.recipie.index', compact('recipies'));    
    }

    public function add() {
        $products = Product::orderBy('name', 'ASC')->get();
        $ingredients = Ingredient::orderBy('name', 'ASC')->get();
        return view('admin-views.recipie.add', compact('products', 'ingredients'));
    }

    public function productVarition($id) {
        $response = $data = [];
        $productDetails = Product::find($id);
        $variations = json_decode($productDetails->variations);
        if(count($variations) > 0) {
            for($i = 0; $i < count($variations[0]->values); $i++) {
                $label = $variations[0]->values[$i]->label;
                array_push($data, $label);
            }
            $response['status'] = 200;
            $response['data'] = $data;
        } else {
            $response['status'] = 401;
        }
        return $response;
    }

    public function store(Request $request) {
        if(isset($request->product)) {
            if(isset($request->items)) {
                if(count($request->items) > 0) {
                    $product_id = $request->product;
                    $product_details = Product::find($product_id);

                    $variation = isset($request->variation) ? $request->variation : '';
                    $recipeExist = Recipie::where('product_id', $product_id)->where('variation', $variation)->get();
                    if(count($recipeExist) == 0) {
                        $recipie = new Recipie();
                        $recipie->product_id = $product_id;
                        $recipie->product_details = json_encode($product_details);
                        $recipie->variation = $variation;
                        $recipie->save();
                        $recipie_id = $recipie->id;
            
                        for($i = 0; $i < count($request->items); $i++) {
                            $ingredient_id = $quantity = $quantity_type = '';
            
                            $ingredient_id = $request->items[$i];
                            $ingredient_details = Ingredient::find($ingredient_id);
                            $quantity = $request->quantitys[$i];
                            $quantity_type = $request->quantity_types[$i];
            
                            $recipieIngredient = new RecipieIngredient();
                            $recipieIngredient->recipie_id = $recipie_id;
                            $recipieIngredient->ingredient_id = $ingredient_id;
                            $recipieIngredient->ingredient_details = json_encode($ingredient_details);
                            $recipieIngredient->quantity = $quantity;
                            $recipieIngredient->quantity_type = $quantity_type;
                            $recipieIngredient->save();
                        }
                        Toastr::success('Recipe created successfully');
                        return redirect('admin/recipe');
                    } else {
                        Toastr::error('Recipe is already added');
                        return back();
                    }
                }
            } else {
                Toastr::error('Please add atleast a ingredient');
                return back();
            }
        } else {
            Toastr::error('Please select a product');
            return back();
        }
    }

    public function edit($id) {
        $products = Product::orderBy('name', 'ASC')->get();
        $ingredients = Ingredient::orderBy('name', 'ASC')->get();
        $recipie = Recipie::with('recipieIngredients')->where('id', $id)->get();
        return view('admin-views.recipie.edit', compact('products', 'ingredients', 'recipie'));
    }

    public function view($id) {
        $recipie = Recipie::with('recipieIngredients')->where('id', $id)->get();
        return view('admin-views.recipie.view', compact('recipie'));
    }

    public function update(Request $request, $recipie_id) {
        if(isset($request->items)) {
            $recipie_details = Recipie::find($recipie_id);
            if(!empty($recipie_details)) {
                $product_id = $request->product;
                $variation = isset($request->variation) ? $request->variation : '';
    
                $recipieExists = Recipie::where('product_id', '=', $product_id)->where('variation', '=', $variation)->where('id', '<>', $recipie_id)->get();
                if(count($recipieExists) == 0) {
                    RecipieIngredient::where('recipie_id', '=', $recipie_id)->delete();
    
                    $product_details = Product::find($product_id);

                    $recipie_details->product_id = $product_id;
                    $recipie_details->product_details = json_encode($product_details);
                    $recipie_details->variation = isset($request->variation) ? $request->variation : '';
                    $recipie_details->save();
        
                    for($i = 0; $i < count($request->items); $i++) {
                        $ingredient_id = $quantity = $quantity_type = '';
        
                        $ingredient_id = $request->items[$i];
                        $ingredient_details = Ingredient::find($ingredient_id);
                        $quantity = $request->quantitys[$i];
                        $quantity_type = $request->quantity_types[$i];
        
                        $recipieIngredient = new RecipieIngredient();
                        $recipieIngredient->recipie_id = $recipie_id;
                        $recipieIngredient->ingredient_id = $ingredient_id;
                        $recipieIngredient->ingredient_details = json_encode($ingredient_details);
                        $recipieIngredient->quantity = $quantity;
                        $recipieIngredient->quantity_type = $quantity_type;
                        $recipieIngredient->save();
                    }
                    Toastr::success('Recipe updated successfully');
                    return back();
                } else {
                    Toastr::error('This recipe is already exists');
                    return back();
                }
    
            } else {
                Toastr::error('Recipe not exists');
                return back();
            }
        } else {
            Toastr::error('Please add atleast a ingredient');
            return back();
        }
    }
}
