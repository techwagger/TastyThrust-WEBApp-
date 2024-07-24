@extends('layouts.admin.app')

@section('title', translate('Purchase Details'))

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img " src="{{asset('public/assets/admin/img/icons/attribute.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Purchase Details')}}
            </span> 
        </h2>
    </div>
    <!-- End Page Header -->
            <div class="card mb-3 mb-lg-5">
                    <div class="card-body bottom-new-line">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="vendor-data " >
                                    <span class="vendor-title">{{ translate('vendor_name') }} : </span>
                                    <span>{{ ucwords(translate($purchase[0]->vendorDetails->name)) }}</span>
                                </div>
                                <div class="vendor-data" >
                                    <span class="vendor-title">{{ translate('invoice') }} : </span>
                                    <span>{{ $purchase[0]->invoice }}</span>
                                </div>
                            </div>       
                            <div class="col-lg-6">
                                <div class="vendor-data" >
                                    <span class="vendor-title">{{ translate('payment_date') }} : </span>
                                    <span>{{ date('d-m-Y', strtotime($purchase[0]->purchase_date))}}</span>
                                </div>
                                <div class="vendor-data" >
                                    <span class="vendor-title">{{ translate('payment_type') }} : </span>
                                    <span>{{ translate($purchase[0]->payment_type) }}</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="vendor-data" >
                                    <span class="vendor-title">{{ translate('note') }} : </span>
                                    <span>{{ translate($purchase[0]->note)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
               
                    <div class="px-card">
                        <div class="py-4 table-responsive">
                        <table class="table-style table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('ingredient') }}</th>
                                <th>{{ translate('quantity') }}</th>
                                <th>{{ translate('rate') }}</th>
                                <th>{{ translate('total') }}</th>
                            </tr>
                            </thead>  
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($purchasesIngredientItem as $IngredientItem) 
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ translate(json_decode($IngredientItem->ingredient_details)->name) }}</td>
                                        <td>{{ $IngredientItem->quantity }} {{ json_decode($IngredientItem->ingredient_details)->quantity_type }}</td>
                                        <td>{{ \App\CentralLogics\Helpers::set_symbol($IngredientItem->rate) }}</td>
                                        <td>{{ \App\CentralLogics\Helpers::set_symbol($IngredientItem->quantity * $IngredientItem->rate) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
    
</div>
@endsection