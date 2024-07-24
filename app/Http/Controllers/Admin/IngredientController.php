<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Ingredient;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Validation\Rule;

class IngredientController extends Controller
{
    public function index() {
        $ingredients = Ingredient::orderBY('name')->get();
        return view('admin-views.ingredient.index', compact('ingredients'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required | unique:ingredients,name',
            'quantity_type' => 'required',
        ],[
            'name.unique' => translate('Ingredient name is already taken'),
        ]);

        $ingredient = new Ingredient;
        $ingredient->name = $request->name;
        $ingredient->quantity_type = $request->quantity_type;
        $ingredient->save();

        Toastr::success('Ingredient added successfully');
        return redirect('admin/ingredient');
    }

    public function edit($id) {
        $ingredient = Ingredient::find($id);
        return view('admin-views.ingredient.edit', compact('ingredient'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('ingredients', 'name')->ignore($id)
            ],
            'quantity_type' => 'required',
        ],[
            'name.unique' => translate('Ingredient name is already taken')
        ]);

        $ingredient = Ingredient::find($id);
        $ingredient->name = $request->name;
        $ingredient->quantity_type = $request->quantity_type;
        $ingredient->update();

        Toastr::success('Ingredient updated successfully');
        return redirect('admin/ingredient');
    }

    public function quantity_type($id) {
        $ingredient = Ingredient::find($id);
        $response = [];
        if(!empty($ingredient)) {
            $response['status'] = 'success';
            $response['data'] = $ingredient->quantity_type;
        } else {
            $response['status'] = 'error';
        }
        return $response;
    }
}
