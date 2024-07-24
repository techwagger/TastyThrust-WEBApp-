@extends('layouts.admin.app')

@section('title', translate('Edit Recipe'))
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    display: inline-block !important;
    min-width: 1.5em !important;
    padding: .5em 1em !important;
    margin-left: 2px !important;
    text-align: center !important;
    text-decoration: none !important;
    cursor: pointer !important;
    color: #8c98a4 !important;
    border: 1px solid transparent !important;
    border-radius: .3125rem !important;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff!important;
    background-color: #ff611d;
    border-color: #ff611d;
}
    .datatable_wrapper_row .dt-buttons {
    display: inline-flex;
    gap: 8px;
    margin-top: 0 !important;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #111;
}
</style>
@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/inventory/recipe.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Edit Recipe')}} 
            </span>
        </h2>
    </div>
    <!-- End Page Header -->
    <div class="row g-2">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <form action="{{ route('admin.recipe.update', [$recipie[0]->id]) }}" method="post">
                @csrf
                <div class="card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{ translate('product') }}<span class="text-danger">*</span></label>
                                        <select name="product" id="food" class="js-select2-custom-x form-ellipsis custom-select">
                                            <option selected disabled>{{ translate('Select_Product') }}</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ $product->id == json_decode($recipie[0]->product_details)->id ? 'selected' : '' }}>{{ translate($product->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" id="variationDiv" style="display: none;">
                                        <label class="input-label">{{translate('Variation')}}<span class="text-danger">*</span></label>
                                        <select name="variation" id="variation" class="custom-select">
                                        </select>
                                    </div>
                                    <!-- variation only for show -->
                                    <input type="hidden" id="variation_data" value="{{ $recipie[0]->variation }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="set_table banner-tbl mt-4">
                        <div class="table-responsive datatable_wrapper_row">
                            <table id="datatable"   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 40%;">{{translate('item')}}</th>
                                        <th style="width: 25%;">{{translate('quantity')}}</th>
                                        <th style="width: 25%;">{{translate('quantity_type')}}</th>
                                        <th style="width: 10%;">
                                            <button type="button" onclick="addRecipeTbl();" class="btn btn-primary btn-sm delete square-btn">
                                                <i class="tio-add"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recipie[0]->recipieIngredients as $recipeingredients)
                                        <tr id="addRecipe_row">
                                            <td>
                                                <select name="items[]" class="custom-select items">
                                                    <option selected disabled>{{translate('select_item')}}</option>
                                                    @foreach ($ingredients as $ingredient)
                                                        <option value="{{ $ingredient->id }}" {{ $ingredient->id == $recipeingredients->ingredient_id ? "selected" : "" }}>{{ $ingredient->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="quantitys[]" class="form-control" value="{{ $recipeingredients->quantity }}" required />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control quantity_type" name="quantity_types[]" value="{{ $recipeingredients->quantity_type }}" readonly>
                                            </td>
                                            <td >
                                                <div class="d-flex  gap-2">
                                                    <a href="#">
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                        onclick="$('#addRecipe_row').remove();"><i class="tio-delete"></i></button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3 m-4">
                        <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        var addRecipe_row= 0;
        function addRecipeTbl() {
            html = '<tr  id="faqs-row' + addRecipe_row+ '">';
            html += '<td>' +
                        '<select name="items[]" class="custom-select items">' +
                            '<option selected disabled>Select item</option>' +
                            '@foreach ($ingredients as $ingredient)' +
                                '<option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>' +
                            '@endforeach' +
                        '</select>' +
                    '</td>';
            html += '<td><input type="text" name="quantitys[]" class="form-control quantity" required></td>';
            html += '<td><input type="text" class="form-control quantity_type" name="quantity_types[]" readonly></td>';
            html += '<td>' +
                        '<button type="button" class="btn btn-outline-danger btn-sm delete square-btn" onclick="$(\'#faqs-row' + addRecipe_row+ '\').remove();"><i class="tio-delete"></i></button>' +
                    '</td>';
            html += '</tr>';
            $('#datatable tbody').append(html);
            addRecipe_row++;
        }

        $(document).ready(function() {
            var variation = $('#variation_data').val();
            var id = $('#food').val();
            var url = '{{ route("admin.recipe.product-variation", ":id") }}';
            url = url.replace(':id', id);

            $("#variation").empty();

            $.ajax({
                url: url,
                method: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.status == 200) {
                        $('#variationDiv').show();
                        $("#variation").append('<option selected disabled>Select Variation</option>');
                        response.data.forEach(function(value) {
                            var selected = (value == variation) ? 'selected' : '';
                            $("#variation").append('<option value="'+ value +'" '+ selected +'>'+ value +'</option>');
                        })
                    } else {
                        $('#variationDiv').css('display', 'none');
                    }
                }
            });
        });

        $('#food').on('change', function() {
            var id = $(this).val();
            var url = '{{ route("admin.recipe.product-variation", ":id") }}';
            url = url.replace(':id', id);

            $("#variation").empty();

            $.ajax({
                url: url,
                method: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.status == 200) {
                        $('#variationDiv').show();
                        $("#variation").append('<option selected disabled>Select Variation</option>');
                        response.data.forEach(function(value) {
                            $("#variation").append('<option>'+ value + '</option>');
                        })
                    } else {
                        $('#variationDiv').css('display', 'none');
                    }
                }
            });
        });

        $(document).on('ready', function () {
            $('.js-select2-custom-x').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $(document).on('change', '.items', function() {
            var $row = $(this).closest('tr');
            var item_id = $(this).val();
            var url = '{{ route("admin.ingredient.quantity_type", ":id") }}';
            url = url.replace(':id', item_id);

            $.ajax({
                url: url,
                method: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.status == 'success') {
                        $row.find('.quantity_type').val(response.data);
                    }
                }
            });
        });
    </script>
@endpush