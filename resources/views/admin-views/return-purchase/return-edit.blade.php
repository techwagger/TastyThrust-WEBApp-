@extends('layouts.admin.app')

@section('title', translate('Edit_Return_Purchase'))


@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/inventory/return.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Edit_Return_Purchase')}} 
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row g-2">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                @if (isset($returnPurchaseIngredientItems))
                    <form action="{{ route('admin.return-purchase.update', [$editpurchasedetail->id]) }}" method="post">
                        @csrf
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('vendor')}}<span class="text-danger">*</span></label>
                                            <input type="text" readonly name="vendor_id" value="{{  $returnPurchase[0]->name }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Invoice')}}<span class="text-danger">*</span></label>
                                            <input type="number" readonly name="invoice" value="{{ $returnPurchase[0]->invoice }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Note')}}</label>
                                            <textarea name="note" class="form-control">{{ $returnPurchase[0]->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="set_table banner-tbl mt-4" >
                            <div class="table-responsive datatable_wrapper_row">
                                <table id="datatable"  class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th style="width: 35%;">{{translate('Item')}}</th>
                                            <th style="width: 15%;">{{translate('quantity')}}</th>
                                            <th style="width: 15%;">{{translate('quantity_type')}}</th>
                                            <th style="width: 15%;">{{translate('rate')}}</th>
                                            <th style="width: 15%;">{{translate('total')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="purchase_id" value="{{ $returnPurchaseIngredientItems[0]->return_purchase_id }}" />
                                        @foreach ($returnPurchaseIngredientItems as $key => $purchaseIngredient)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="return_ingredients[{{$key}}]" class="form-control" value="{{ $purchaseIngredient->purchase_ingredient_id }}">
                                                </td>
                                                
                                                <td>
                                                    <select name="items[{{$key}}]" onchange="updateQtyType(this)" class="custom-select">
                                                        <option selected disabled>{{translate('select_item')}}</option>
                                                        @foreach ($ingredients as $ingredient)
                                                            <option value="{{ $ingredient->id }}"
                                                                data-qtytyp="{{ $ingredient->quantity_type }}"
                                                                {{ $ingredient->id == json_decode($purchaseIngredient->ingredient_details)->id ? 'selected' : '' }}>
                                                                {{ $ingredient->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="quantitys[{{$key}}]" step="0.1" min="0.1" max="{{ $purchaseIngredient->quantity }}" onchange="calculateMax(this)" onkeyup="calculateTotal(this)" class="form-control quantity qty" value="{{ $purchaseIngredient->return_quantity }}" required>
                                                    {{-- <input type="hidden" class="main_quantity qty" onkeyup="calculateTotal(this)" value="{{ $purchaseIngredient->return_quantity }}" /> --}}
                                                    {{-- <span class="max-error" style="color: red; font-size:12px; display: none;">Please valid quantity</span> --}}
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control quantity_type qty-type" value="{{ json_decode($purchaseIngredient->ingredient_details)->quantity_type }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control rate" onkeyup="calculateTotal(this)" value="{{ $purchaseIngredient->rate }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total" value="{{ $purchaseIngredient->rate * $purchaseIngredient->return_quantity }}" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end gap-3 m-4">
                                    <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif


            <form id="return_purchase-{{$returnPurchaseIngredientItems[0]->return_purchase_id}}" action="{{ route('admin.return-purchase.returncancel', [$returnPurchaseIngredientItems[0]->return_purchase_id]) }}" method="post">
                @csrf 
            </form> 
            <div class="card-body">
                <div class="note-area">
                    <h5>Notes :-</h5>
                    <ol class="note-list" >
                        <li>Quantity cannot be more than the original quantity and cannot be 0.</li>
                        <li>If the user wants to change the item in Edit Return Purchase, the user needs to cancel the Cancel Return Purchase and create a new Return Purchase.</li>
                        <li>User cannot edit the Purchase, for which user already created Return Purchase.</li>
                        <li>The quantity of the item which are cancelled will be added to Ingredients.</li>
                    </ol>

                </div>
                <div>
                    <button type="button" class="btn btn-outline-danger"
                    onclick="form_alert('return_purchase-{{$returnPurchaseIngredientItems[0]->return_purchase_id}}','{{translate('Are you sure you want to cancel this return purchase')}}')">{{translate('Cancel Return Purchase')}}</button>        
                </div>
           </div>
            <!-- End Table -->
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>
@endsection

@push('script_2') 
    <script>
         function calculateMax(input) {
            var enteredValue = parseFloat(input.value); 
            var maxValue = parseFloat(input.getAttribute('max'));

            if (isNaN(enteredValue) || !Number.isFinite(enteredValue)) { 
                input.value = '';
                document.querySelector('.max-error').style.display = 'none';
            } else if (enteredValue === 0) {
                alert("Quantity must be a positive number and cannot be 0. Please enter a valid quantity.");
                input.value = ''; 
                document.querySelector('.max-error').style.display = 'none';
            } else if (enteredValue > maxValue) {
                input.value = Math.floor(maxValue);
                document.querySelector('.max-error').style.display = 'inline';
            } else {
                document.querySelector('.max-error').style.display = 'none';
            }
        }

        function updateQtyType(select) {
            var selectedOption = select.options[select.selectedIndex];
            var qtyTypInput = $(select).closest('tr').find('.qty-type'); 
            var qtyTyp = $(selectedOption).data('qtytyp');
            qtyTypInput.val(qtyTyp);
        }

        function calculateTotal(input) {
            var row = $(input).closest('tr'); 
            var qty = parseFloat(row.find('.qty').val()) || 0; 
            var rate = parseFloat(row.find('.rate').val()) || 0; 
            var total = qty * rate;
            if (isNaN(total) || !isFinite(total)) {
                total = 0;
            }
            row.find('.total').val(total.toFixed(0));
        }

       // function showAlertOnZero(input) {
        //     let quantity = parseFloat(input.value.trim());
        //     if (isNaN(quantity) || quantity <= 0) {
        //         alert("Quantity must be a positive number and cannot be 0. Please enter a valid quantity.");
        //         input.value = '';
        //     }
        // }
    
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.qty');
            inputs.forEach(function(input) {
                input.addEventListener('onchange', function() {
                    calculateMax(input);
                });
            });
        });
    </script>
@endpush
