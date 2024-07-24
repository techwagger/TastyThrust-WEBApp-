@extends('layouts.admin.app')

@section('title', translate('Add_Return_Purchase'))

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/inventory/return.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Add_Return_Purchase')}} 
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row g-2">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <form action="{{ route('admin.return-purchase.edit') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('vendor')}}<span class="text-danger">*</span></label>
                                        <select name="vendor_id" id="vendor_id" class="custom-select" >
                                            <option selected disabled>{{ translate('select_vendor') }}</option>
                                            @foreach ($vendors as $vendor)
                                                @if (isset($vendor_id))
                                                    @if ($vendor_id == $vendor->id)
                                                        <option value="{{ $vendor->id }}" selected>{{ $vendor->name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('Invoice')}}<span class="text-danger">*</span></label>
                                        <select class="form-control" name="invoice" id="invoice">
                                            @if (isset($invoice))
                                                <option value="{{$invoice}}" selected>{{$invoice}}</option>
                                            @endif
                                        </select>
                                        {{-- <input type="number" name="invoice" class="form-control" placeholder="{{ translate('Ex: ABC123') }}" value="{{ isset($invoice) ? $invoice : '' }}" required> --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    @if (isset($vendor_id) && isset($invoice))
                                        
                                    @else
                                        <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        
                    
                </form>
                <!-- Table -->
                <form action="{{ route('admin.return-purchase.store') }}" method="post"  id="myForm" onsubmit="return validateForm()">
                    <!-- for note -->
                    @if (isset($vendor_id) && isset($invoice))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="input-label">{{translate('Note')}}</label>
                                    <textarea name="note" class="form-control" placeholder="{{translate('Ex: ABC')}}" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
               
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
                                @if (isset($purchaseIngredients))
                                        <tbody>
                                            @csrf
                                            <input type="hidden" name="purchase_id" value="{{ $purchaseIngredients[0]->id }}" />
                                            @foreach ($purchaseIngredients as $key => $purchaseIngredient)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="return_ingredients[{{$key}}]" class="form-control required-checkbox" value="{{ $purchaseIngredient->purchases_ingredient_items_id }}">
                                                    </td>
                                                    <td>
                                                        <select name="items[{{$key}}]" onchange="updateQtyType(this)" class="custom-select items">
                                                            <option selected disabled>{{translate('select_item')}}</option>
                                                            @foreach ($ingredients as $ingredient)
                                                                @if ($ingredient->id == json_decode($purchaseIngredient->ingredient_details)->id)
                                                                    <option value="{{ $ingredient->id }}" selected>{{ $ingredient->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantitys[{{$key}}]" step="0.1" min="0.1" max="{{ $purchaseIngredient->quantity }}"  value="{{ $purchaseIngredient->quantity }}" onchange="calculateMax(this)" onkeyup="calculateTotal(this)"  class="form-control quantity qty" required>
                                                        <input type="hidden" class="main_quantity" value="{{ $purchaseIngredient->quantity }}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control quantity_type qty-type" value="{{ json_decode($purchaseIngredient->ingredient_details)->quantity_type }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number"  class="form-control rate" step="0.1" min="0.1" onkeyup="calculateTotal(this)"  value="{{ $purchaseIngredient->rate }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control total" value="{{ $purchaseIngredient->rate * $purchaseIngredient->quantity }}" readonly>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end gap-3 m-4">
                                        <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                        <button type="submit" class="btn btn-primary">{{translate('return')}}</button>
                                    </div>
                                @else
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="text" class="form-control">
                                            </td>
                                            <td>
                                                <select name="items[]" class="custom-select items">
                                                    <option selected disabled>{{translate('select_item')}}</option>
                                                    {{-- @foreach ($ingredients as $ingredient)
                                                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number"  step="0.1" min="0.1" name="quantitys[]" class="form-control quantity" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control quantity_type" readonly>
                                            </td>
                                            <td>
                                                <input type="number" step="0.1" min="0.1" name="rates[]" class="form-control rate" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control total" required readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                </form>
                <!-- End Table -->
                
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        function validateForm() {
            var checkboxes = $('.required-checkbox');
            var isChecked = false;
            checkboxes.each(function() {
                if ($(this).prop('checked')) {
                    isChecked = true;
                    return false;
                }
            });
            if (!isChecked) {
                alert('Please select at least one Ingredient.');
                return false;
            }
            return true;
        }

    </script>
    <script>
        $('#vendor_id').on('change', function() {
            let vendor_id = $(this).val();
            var url = '{{ route("admin.vendor.list", ":id") }}';
            url = url.replace(':id', vendor_id);

            $("#invoice").empty();

            $.ajax({
                url: url,
                method: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response);
                    if(response.status == 200) {
                        $('#invoice').append('<option selected disabled>Select invoice</option>');
                        response.data.forEach(function(value) {
                            $('#invoice').append('<option value="'+ value +'">'+ value +'</option>');
                        });
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    </script>

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