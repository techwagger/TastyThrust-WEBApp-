@extends('layouts.admin.app')

@section('title',translate('customer_loyalty_Point').' '.translate('report'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/admin/img/point.png')}}" alt="public" class="width-24">
                <span>
                    {{translate('customer_Loyalty_Point')}} {{translate('report')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <div class="card-header text-capitalize">
                <h5 class="card-title">
                    <span class="card-header-icon">
                        <i class="tio-filter-outlined"></i>
                    </span>
                    <span>{{translate('filter')}} {{translate('options')}}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 pt-3">
                        <form action="{{route('admin.customer.loyalty-point.report')}}" method="get">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <input type="text" name="from" id="from_date" readonly value="{{request()->get('from')}}" class="form-control h--45px" placeholder="DD-MM-YYYY" autocomplete="off" title="{{translate('from')}} {{translate('date')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <input type="text" name="to" id="to_date" readonly value="{{request()->get('to')}}" class="form-control h--45px" placeholder="DD-MM-YYYY" autocomplete="off" title="{{ucfirst(translate('to'))}} {{translate('date')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        @php
                                            $transaction_status=request()->get('transaction_type');
                                        @endphp
                                        <select name="transaction_type" id="" class="form-control h--45px" title="{{translate('select')}} {{translate('transaction_type')}}">
                                            <option value="">{{translate('all')}}</option>
                                            <option value="loyalty_point_to_wallet" {{isset($transaction_status) && $transaction_status=='loyalty_point_to_wallet'?'selected':''}}>{{translate('loyalty_point_to_wallet')}}</option>
                                            <option value="order_place" {{isset($transaction_status) && $transaction_status=='order_place'?'selected':''}}>{{translate('order_place')}}</option>
                                    {{-- <option value="point_in" {{isset($transaction_status) && $transaction_status=='point_in'?'selected':''}}>{{translate('point_in')}}</option>--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <select id='customer' name="customer_id" data-placeholder="{{translate('Select_Customer')}}" class="js-data-example-ajax form-control h--45px" title="{{translate('select_customer')}}">
                                            @if (request()->get('customer_id') && $customer_info = \App\User::find(request()->get('customer_id')))
                                                <option value="{{$customer_info->id}}" selected>{{$customer_info->f_name.' '.$customer_info->l_name}}({{$customer_info->phone}})</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end">

                                <button type="reset" id="reset_btn" class="btn btn-secondary">{{translate('reset')}}</button>

                                <button type="submit" class="btn btn-primary"><i class="tio-filter-list mr-1"></i>{{translate('filter')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="row g-3">
            @php
                $credit = $data[0]->total_credit??0;
                $debit = $data[0]->total_debit??0;
                $balance = $credit - $debit;
            @endphp
                <!--Debit earned-->
            <div class="col-sm-4">
                <div class="resturant-card dashboard--card bg--2">
                    <h4 class="title">{{translate('debit')}}</h4>
                    <span class="subtitle">
                        {{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{ number_format($debit, 2) }}
                    </span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/ruppee.png')}}" alt="dashboard">
                </div>
            </div>
            <!--Debit earned End-->
            <!--credit earned-->
            <div class="col-sm-4">
                <div class="resturant-card dashboard--card bg--3">
                    <h4 class="title">{{translate('credit')}}</h4>
                    <span class="subtitle">
                        {{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{ number_format($credit, 2) }}
                    </span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/dashboard/4.png')}}" alt="dashboard">
                </div>
            </div>
            <!--credit earned end-->
            <!--balance earned-->
            <div class="col-sm-4">
                <div class="resturant-card dashboard--card bg--1">
                    <h4 class="title">{{translate('balance')}}</h4>
                    <span class="subtitle">
                        {{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{ number_format($balance, 2) }}
                    </span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/dashboard/1.png')}}" alt="dashboard">
                </div>
            </div>
            <!--balance earned end-->
        </div>
        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <!-- <div class="card-header text-capitalize border-0">
                <h4 class="card-title">
                    <span class="card-header-icon"><i class="tio-money"></i></span>
                    <span class="ml-2">{{translate('transactions')}}</span>
                </h4>
            </div> -->
            <div class="new-top px-card">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                            <h4 class="card-title">
                    <span class="card-header-icon"><i class="tio-money"></i></span>
                    <span class="ml-2">{{translate('transactions')}}</span>
                </h4>   
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="https://food.progocrm.com/admin/notification/add-new" method="GET">
                                    <div class="input-group">
                                        
                                        <div class="input-group-append">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="set_table new-responsive search-style">
                <div class="table-responsive datatable_wrapper_row ">
                    <table id="datatable"
                           class="table table-thead-bordered table-align-middle card-table table-nowrap">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ translate('sl') }}</th>
                            <th>{{translate('transaction')}} {{translate('id')}}</th>
                            <th>{{translate('Customer')}}</th>
                            <th>{{translate('credit')}}</th>
                            <th>{{translate('debit')}}</th>
                            <th>{{translate('balance')}}</th>
                            <th>{{translate('transaction_type')}}</th>
                            {{-- <th>{{translate('reference')}}</th>--}}
                            <th>{{translate('created_at')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $k=>$wt)
                            <tr scope="row">
                                <td >{{$k+1}}</td>
                                <td>{{$wt->transaction_id}}</td>
                                <td><a href="{{route('admin.customer.view',['user_id'=>$wt->user_id])}}">{{Str::limit($wt->customer?$wt->customer->f_name.' '.$wt->customer->l_name:translate('not_found'),20,'...')}}</a></td>
                                <td>{{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{number_format($wt->credit,2)}}</td>
                                <td>{{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{number_format($wt->debit,2)}}</td>
                                <td>{{ __(':currency', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}{{number_format($wt->amount,2)}}</td>
                                <td>
                                    <span class="badge badge-soft-{{$wt->type=='point_to_wallet'?'success':'dark'}}">
                                        {{translate($wt->type)}}
                                    </span>
                                </td>
                                {{--  <td>{{$wt->reference}}</td>--}}
                                <td>{{date('d-m-Y '.config('timeformat'), strtotime($wt->created_at))}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(!$transactions)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/img/empty.png')}}" alt="public">
                            <h5>
                                {{translate('no_data_found')}}
                            </h5>
                        </div>
                    @endif
                </div>
                <!-- Pagination -->
                <div class="page-area px-4 pb-3">
                    <div class="d-flex justify-content-lg-end justify-content-sm-end">
                        {{-- <div>
                            1-15 of 380
                        </div> --}}
                        <div>
                            {{-- {!! $transactions->links() !!} --}}
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
            </div>
            <!-- End Body -->

        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script')

@endpush

@push('script_2')

    <script>
        $(document).on('ready', function () {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{route('admin.customer.select-list')}}',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            all: true,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });
    </script>




      <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF NAV SCROLLER
            // =======================================================
            $('.js-nav-scroller').each(function () {
                new HsNavScroller($(this)).init()
            });
    
            // INITIALIZATION OF SELECT2
            // =======================================================
           
    
    
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
                info:false,
                paging  : false,
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
@endpush
