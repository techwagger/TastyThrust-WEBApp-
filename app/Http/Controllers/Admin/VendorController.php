<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\Model\ReturnPurchase;
use Illuminate\Http\Request;
use App\Model\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index() {
        $vendors = Vendor::orderBY('name')->get(); 
        return view('admin-views.vendor.index', compact('vendors'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required | min: 7 | max: 15 | unique:vendors,mobile',
            'email' => 'required | email | unique:vendors,email',
            'address' => 'required'
        ],[
            'mobile.unique' => translate('Mobile is already exists'),
            'email.unique' => translate('Email is already exists')
        ]);

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->mobile = $request->mobile;
        $vendor->email = $request->email;
        $vendor->gst = $request->gst;
        $vendor->address = $request->address;
        $vendor->save();

        Toastr::success('Vendor added successfully');
        return redirect('admin/vendor');
    }

    public function edit($id) {
        $vendor = Vendor::find($id);
        return view('admin-views.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'mobile' => [
                'required',
                'min: 7',
                'max: 15',
                Rule::unique('vendors', 'mobile')->ignore($id)
            ],
            'name' => 'required',
            'address' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('vendors', 'email')->ignore($id)
            ],
        ],[
            'mobile.unique' => translate('Vendor mobile is already taken'),
            'email.unique' => translate('Vendor email is already taken'),
        ]);

        $vendor = Vendor::find($id);
        $vendor->name = $request->name;
        $vendor->mobile = $request->mobile;
        $vendor->email = $request->email;
        $vendor->gst = $request->gst;
        $vendor->address = $request->address;
        $vendor->update();

        Toastr::success('Vendor updated successfully');
        return redirect('admin/vendor');
    }

    public function list($vendor_id) {
        $invoices = $response = [];
        $purchases = Purchase::where('vendor_id', '=', $vendor_id)->get();
        foreach($purchases as $purchase) {
            $returnPurchase = ReturnPurchase::where('purchase_id', '=', $purchase->id)->where('status', '=', 0)->get();
            if(count($returnPurchase) == 0) {
                array_push($invoices, $purchase->invoice);
            }
        }
        if(count($invoices) > 0) {
            $response['status'] = 200;
            $response['data'] = $invoices;
        } else {
            $response['status'] = 404;
            $response['message'] = 'No invoice found';
        }
        return json_encode($response);
    }
}
