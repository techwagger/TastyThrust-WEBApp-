@extends('layouts.admin.app')

@section('title', translate('table order'))

@push('css_or_js')
    <style>
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin-top: 20px;
            margin-bottom: 30px;
            margin-right: 50px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-5">

        <!-- Page Header -->
        <div class="">
            <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                    <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/all_orders.png')}}" alt="">
                    <span class="page-header-title">
                    {{translate('running')}} {{translate('table')}} {{translate('orders')}}
                </span>
                </h2>
                {{-- <span class="badge badge-soft-dark rounded-50 fz-14">{{$orders->total()}}</span> --}}
                <span class="badge badge-soft-dark rounded-50 fz-14">{{count($orders)}}</span>
            </div>
        </div>
        <div id="all_running_order">
            <div class="card">
                <div class="pt-3 px-card ">
                    <div class="row justify-content-between align-items-center gy-2">
                       
                        <div class="col-sm-8 col-md-8 col-lg-12">
                            <div class="row">
                                <div class="col-2 col-md-2 col-lg-4 d-none">
                                    <div id="invoice_btn" class="{{ is_null($table_id) ?  : '' }}">
                                        <a class="form-control btn btn-sm btn-white float-right" href="{{ route('admin.table.order.running.invoice', ['table_id' => $table_id]) }}"><i class="tio-print"></i> {{translate('invoice')}}</a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-4">
                                    <select class="form-control text-capitalize" name="branch" onchange="filter_branch_orders(this.value)">
                                        <option disabled>--- {{translate('select')}} {{translate('branch')}} ---</option>
                                        @foreach(\App\Model\Branch::all() as $branch)
                                            <option
                                                value="{{$branch['id']}}" {{session('branch_filter')==$branch['id']?'selected':''}}>{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-6 col-lg-4">
                                    <!-- Select -->
                                    <select class="form-control text-capitalize" name="table" id="select_table" onchange="filter_by_table(this.value)">
                                        <option disabled selected>--- {{translate('select')}} {{translate('table')}} ---</option>
                                        @foreach($tables as $table)
                                            <option value="{{$table['id']}}" {{$table_id==$table['id'] ? 'selected' : ''}}>{{translate('Table')}} - {{$table['number']}}</option>
                                        @endforeach
                                    </select>
                                    <!-- End Select -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                
                    <div class="set_table search-arrange one-search">
                    <div class="table-responsive datatable_wrapper_row" style="padding:0 10px;">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th class="">
                                    {{translate('SL')}}
                                </th>
                                <th class="table-column-pl-0">{{translate('order')}}</th>
                                <th>{{translate('date')}}</th>
                                <th>{{translate('branch')}}</th>
                                <th>{{translate('table')}}</th>
                                <th>{{translate('payment')}} {{translate('status')}}</th>
                                <th>{{translate('total')}}</th>
                                <th>{{translate('order')}} {{translate('status')}}</th>
                                <th>{{translate('number of people')}}</th>
                                <th>{{translate('actions')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                                <?php $i = 1; ?>
                            @foreach($orders as $key=>$order)

                                <tr class="status-{{$order['order_status']}} class-all">
                                    {{-- <td class="">
                                        {{$orders->firstitem()+$key}}
                                    </td> --}}
                                    <td>{{ $i++ }}</td>
                                    <td class="table-column-pl-0">
                                        <a href="{{route('admin.orders.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
                                    </td>
                                    <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                                    <td>
                                        <label class="badge badge-soft-primary">{{$order->branch?$order->branch->name:'Branch deleted!'}}</label>
                                    </td>
                                    <td>
                                        @if($order->table)
                                            <label class="badge badge-soft-info">{{translate('table')}} - {{$order->table->number}}</label>
                                        @else
                                            <label class="badge badge-soft-info">{{translate('table deleted')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status=='paid')
                                            <span class="badge badge-soft-success">
                                        <span class="legend-indicator bg-success"></span>{{translate('paid')}}</span>
                                        @else
                                            <span class="badge badge-soft-danger">
                                        <span class="legend-indicator bg-danger"></span>{{translate('unpaid')}}</span>
                                        @endif
                                    </td>
                                    <td>{{ \App\CentralLogics\Helpers::set_symbol($order['order_amount']) }}</td>
                                    <td class="text-capitalize">
                                        @if($order['order_status']=='pending')
                                            <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-info"></span>{{translate('pending')}}</span>
                                        @elseif($order['order_status']=='confirmed')
                                            <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-info"></span>{{translate('confirmed')}}</span>
                                        @elseif($order['order_status']=='cooking')
                                            <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-info"></span>{{translate('cooking')}}</span>
                                        @elseif($order['order_status']=='done')
                                            <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-info"></span>{{translate('done')}}</span>
                                        @elseif($order['order_status']=='completed')
                                            <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-info"></span>{{translate('completed')}}</span>
                                        @elseif($order['order_status']=='processing')
                                            <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-warning"></span>{{translate('processing')}}</span>
                                        @elseif($order['order_status']=='out_for_delivery')
                                            <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-warning"></span>{{translate('out_for_delivery')}}</span>
                                        @elseif($order['order_status']=='delivered')
                                            <span class="badge badge-soft-success ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-success"></span>{{translate('delivered')}}</span>
                                        @else
                                            <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                        <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}</span>
                                        @endif
                                    </td>
                                    <td>{{$order['number_of_people']}}</td>
                                    <td>
                                        <div class="dropdown category-mid">
                                            <a class="btn btn-sm btn-outline-primary square-btn" href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
               
                {{-- <div class="card-footer"> --}}
                    <!-- Pagination -->
                    {{-- <div class="table-responsive pagination-style">
                        <div class="d-flex justify-content-sm-end  justify-content-lg-end">
                                {!! $orders->links() !!}
                        </div>                        
                    </div> --}}
                    <!-- End Pagination -->
                {{-- </div> --}}
            </div>
        </div>

    </div>

@endsection

@push('script_2')
    <script>
        function filter_branch_orders(id) {
            location.href = '{{url('/')}}/admin/orders/branch-filter/' + id;
        }
    </script>
    <script>
        function filter_by_table(tableId) {
            location.href = '{{route("admin.table.order.running")}}' + '?table_id=' + tableId;
        }
        // $(document).ready(function (){
        //     $('#select_table').on('change', function (){
        //         var tableId = $(this).val();
        //         alert(tableId);
        //         if (tableId) {
        //             location.href = '{{route("admin.table.order.running")}}' + '?table_id=' + tableId;
        //         }

        //     });
        // });
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
               select: {
                   style: 'multi',
                   selector: 'td:first-child input[type="checkbox"]',
                   classMap: {
                       checkAll: '#datatableCheckAll',
                       counter: '#datatableCounter',
                       counterInfo: '#datatableCounterInfo'
                   }
               },
               info: false,
               paging: true,
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
       $('#from_date,#to_date').change(function () {
           let fr = $('#from_date').val();
           let to = $('#to_date').val();
           if (fr != '' && to != '') {
               if (fr > to) {
                   $('#from_date').val('');
                   $('#to_date').val('');
                   toastr.error('{{translate('Invalid date range!')}}', Error, {
                       CloseButton: true,
                       ProgressBar: true
                   });
               }
           }
       });
   </script>
@endpush
