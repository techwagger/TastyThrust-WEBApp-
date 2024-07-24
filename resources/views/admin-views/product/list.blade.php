@extends('layouts.admin.app')

@section('title', translate('Product List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .dataTables_paginate {
            margin-top: 20px; /* Adjust the top margin as needed */
        }
        <style>
    .dataTables_paginate.paging_simple_numbers {
    margin: 10px;
}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    display: inline-block !important;
    min-width: 20px !important;
    padding: 5px 10px !important;
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
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/product.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Product_List')}}
                </span>
            </h2>
            <span class="badge badge-soft-dark rounded-50 fz-14">{{ count($products) }}</span>
        </div>
        <!-- End Page Header -->


        <div class="row g-2">
            <div class="col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-top px-card ">
                        <div class="row justify-content-between align-items-center gy-2">
                        <div class="col-lg-12">
                                <div class="d-flex gap-3 justify-content-start text-nowrap flex-wrap">
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-attribute" data-toggle="dropdown" aria-expanded="false">
                                            <i class="tio-download-to"></i>
                                            Export
                                            <i class="tio-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a type="submit" class="dropdown-item d-flex align-items-center gap-2" href="{{route('admin.product.excel-import', ['search' => $search])}}">
                                                    <img width="14" src="{{asset('public/assets/admin/img/icons/excel.png')}}" alt="">
                                                    {{translate('Excel')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{route('admin.product.add-new')}}" class="btn-attribute btn btn-primary">
                                        <i class="tio-add"></i> {{translate('add_New_Product')}}
                                    </a>
                                </div>
                            </div>
                           
                            
                        </div>
                    </div>
                    <!-- End Header -->

                    <div class="set_table customer-style">
                        <div class="table-responsive datatable_wrapper_row "  style="padding-right: 10px;">
                            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('product_name')}}</th>
                                    <th>{{translate('selling_price')}}</th>
                                    <th>{{translate('total_sale')}}</th>
                                    <th>{{translate('stock')}}</th>
                                    <th>{{translate('status')}}</th>
                                    <th>{{translate('action')}}</th>
                                </tr>
                                </thead>

                                <tbody id="set-rows">
                                    @php
                                        $i=1
                                    @endphp
                                @foreach($products as $key=>$product)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="category-mid media align-items-center gap-3">
                                                <div class="avatar">
                                                    <img src="{{asset('storage/app/public/product')}}/{{$product['image']}}" class="rounded img-fit"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                                </div>

                                                <div class=" name-width">
                                                    <a class="text-dark" href="{{route('admin.product.view',[$product['id']])}}">
                                                        {{ Str::limit($product['name'], 30) }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \App\CentralLogics\Helpers::set_symbol($product['price']) }}</td>
                                        <td >{{\App\Model\OrderDetail::whereHas('order', function ($q){
                                                    $q->where('order_status', 'delivered');
                                                })->where('product_id', $product->id)->sum('quantity')}}
                                        </td>
                                        <td>
                                            <div><span class="">{{ translate('Stock Type') }} : {{ ucfirst($product->main_branch_product?->stock_type) }}</span></div>
                                            @if(isset($product->main_branch_product) && $product->main_branch_product->stock_type != 'unlimited')
                                                @php
                                                    $remainstock = $product->main_branch_product->stock - \App\Model\OrderDetail::whereHas('order', function ($q) use ($product) {$q->where('order_status', 'delivered');})->where('product_id', $product->id)->sum('quantity');
                                            
                                                @endphp
                                                <div><span class="">{{ translate('Stock') }} : {{$remainstock }}</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="">
                                                <label class="switcher">
                                                    <input id="{{$product['id']}}" class="switcher_input" type="checkbox" {{$product['status']==1? 'checked' : ''}} data-url="{{route('admin.product.status',[$product['id'],0])}}" onchange="status_change(this)">
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex  gap-2">
                                                <a class="btn btn-outline-info btn-sm edit square-btn"
                                                href="{{route('admin.product.edit',[$product['id']])}}"><i class="tio-edit"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                onclick="form_alert('product-{{$product['id']}}','{{translate('Want to delete this item ?')}}')"><i class="tio-delete"></i></button>
                                            </div>
                                            <form action="{{route('admin.product.delete',[$product['id']])}}"
                                                method="post" id="product-{{$product['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4 px-3 pagination-style">
                            <div class="d-flex justify-content-lg-end justify-content-sm-end">
                                <!-- Pagination -->
                                {{-- {!! $products->links() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.product.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
        @push('script_2')
        <script>
            $(document).on('ready', function () {
                // INITIALIZATION OF NAV SCROLLER
                // =======================================================
                $('.js-nav-scroller').each(function () {
                    new HsNavScroller($(this)).init()
                });
        
                // INITIALIZATION OF SELECT2
                // =======================================================
                $('.js-select2-custom').each(function () {
                    var select2 = $.HSCore.components.HSSelect2.init($(this));
                });
        
        
                // INITIALIZATION OF DATATABLES
                // =======================================================
                var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'd-none'
                        },
                        {
                            extend: 'excel',
                            className: 'd-none'
                        },
                        {
                            extend: 'csv',
                            className: 'd-none'
                        },
                        {
                            extend: 'pdf',
                            className: 'd-none'
                        },
                        {
                            extend: 'print',
                            className: 'd-none'
                        },
                        
                    ],
                    info: false,
                    paging: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        classMap: {
                            checkAll: '#datatableCheckAll',
                            counter: '#datatableCounter',
                            counterInfo: '#datatableCounterInfo'
                        }
                    },
                    language: {
                        zeroRecords: '<div class="text-center p-4">' +
                            '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                            '<p class="mb-0">{{translate('No data to show')}}</p>' +
                            '</div>'
                    }
                });
        
                // INITIALIZATION OF TAGIFY
                // =======================================================
                $('.js-tagify').each(function () {
                    var tagify = $.HSCore.components.HSTagify.init($(this));
                });
            });
        
            function filter_branch_orders(id) {
                location.href = '{{url('/')}}/admin/orders/branch-filter/' + id;
            }
           
        </script>
        <script>
            $(document).on('ready', function () {
                // ... Your existing initialization code
    
                // Get the DataTable instance
                var dataTable = $('#datatable').DataTable();
    
                // Hide pagination on initial load
                checkAndTogglePagination(dataTable);
    
                // Event listener for DataTable search
                dataTable.on('search.dt', function () {
                    checkAndTogglePagination(dataTable);
                });
            });
    
            function checkAndTogglePagination(dataTable) {
                var paginationSection = $('.pagination-style');
    
                if (dataTable.search() && dataTable.search() !== '') {
                    // If search is active, hide pagination
                    paginationSection.hide();
                } else {
                    // If no search or search is cleared, show pagination
                    paginationSection.show();
                }
            }
            </script>
@endpush
