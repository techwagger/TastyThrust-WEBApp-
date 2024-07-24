@extends('layouts.branch.app')

@section('title', translate('Order List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex align-items-center gap-1">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/all_orders.png')}}" alt="">
                <span class="page-header-title">
                    @if ($status == 'canceled')
                        Cancelled
                    @elseif ($status == 'Done')
                        {{translate('Ready_For_Serve')}}
                    @else
                        {{translate($status)}}
                    @endif
                     {{translate('Orders')}}
                </span>
            </h2>
            <span class="badge badge-soft-dark rounded-50 fz-14">{{ $orders->total() }}</span>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">

            <!-- Filter Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{url()->current()}}" id="form-data" method="GET">
                        <div class="row gy-3 gx-2 align-items-end">
                            <div class="col-12 pb-0">
                                <h4 class="mb-0">{{translate('Select Date Range')}}</h4>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mb-0">
                                    <label class="text-dark">{{ translate('Start Date') }}</label>
                                    <input type="text" name="from" value="{{$from}}" id="from_date" readonly placeholder="DD-MM-YYYY" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mb-0">
                                    <label class="text-dark">{{ translate('End Date') }}</label>
                                    <input type="text" value="{{$to}}" name="to" id="to_date" readonly placeholder="DD-MM-YYYY" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 d-flex gap-2">
                                <button type="reset" class="btn btn-secondary flex-grow-1">{{ translate('Clear') }}</button>
                                <button type="submit" class="btn btn-primary flex-grow-1 text-nowrap">{{ translate('Show_Data') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Filter Card -->


            {{-- @if($status == 'all') --}}
            <div class="px-4 mt-4">
                <div class="row g-2">
                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'pending'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/pending.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('pending')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['pending']}}
                            </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'confirmed'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/confirmed.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('confirmed')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['confirmed']}}
                            </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'processing'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/packaging.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('processing')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['processing']}}
                            </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'out_for_delivery'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/out_for_delivery.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('out_for_delivery')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['out_for_delivery']}}
                            </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'delivered'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/delivered.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('delivered')}}</span>
                                </h6>
                                <span class="card-title ">
                                {{$order_count['delivered']}}
                            </span>
                            </div>
                        </a>
                    </div>

                    <!-- Static Cancel -->
                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'canceled'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/canceled.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('cancelled')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['canceled']}}
                            </span>
                            </div>
                        </a>
                    </div>
                    <!-- Static Cancel -->

                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'returned'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/returned.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('returned')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['returned']}}
                            </span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order--card h-100" href="{{route('branch.orders.list', ['status' => 'returned'])}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                    <img src="{{asset('public/assets/admin/img/icons/failed_to_deliver.png')}}" alt="dashboard" class="oder--card-icon">
                                    <span>{{translate('failed_to_deliver')}}</span>
                                </h6>
                                <span class="card-title ">
                                    {{$order_count['failed']}}
                            </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- @endif --}}


            <!-- Header -->
            <div class="card-top px-card ">
                <div class="row justify-content-between align-items-center gy-2">
                <div class="col-sm-4 col-md-6 col-lg-8 d-flex justify-content-start">
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-attribute" data-toggle="dropdown" aria-expanded="false">
                                <i class="tio-download-to"></i>
                                {{translate('Export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a type="submit" class="dropdown-item d-flex align-items-center gap-2" href="{{route('branch.orders.export-excel')}}">
                                        <img width="14" src="{{asset('public/assets/admin/img/icons/excel.png')}}" alt="">
                                        {{translate('Excel')}}
                                    </a>
                                </li>
{{--                                <li>--}}
{{--                                    <a href="{{route('admin.orders.export')}}" class="dropdown-item d-flex align-items-center gap-2">--}}
{{--                                        <i class="tio-pages"></i>--}}
{{--                                        {{translate('Bulk_Export')}}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        {{-- <form action="{{url()->current()}}" method="GET"> --}}
                            <div class="input-group input-group-merge input-group-flush border rounded">
                                <div class="input-group-prepend pl-2">
                                    <div class="input-group-text">
                                        <!-- <i class="tio-search"></i> -->
                                        <img width="13" src="{{asset('public/assets/admin/img/icons/search.png')}}" alt="">
                                    </div>
                                </div>
                                <input type="text" id="order_details" onkeyup="searchOrder()" class="form-control" placeholder="{{translate('Order ID, Order Status, Order Amount or Name')}}" aria-label="Search">
                                {{-- <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        {{translate('Search')}}
                                    </button>
                                </div> --}}
                            </div>
                        {{-- </form> --}}
                    </div>
                    
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <div class="set_table responsive-ui new-ui" style="margin-top: 50px">
                <!-- Table -->
                <div class="table-responsive datatable_wrapper_row " style="padding:0 10px;">
                    <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('order_ID')}}</th>
                                <th>{{translate('Delivery_Date')}}</th>
{{--                                <th>{{translate('Time_Slot')}}</th>--}}
                                <th>{{translate('Customer_Info')}}</th>
                                <th>{{translate('Branch')}}</th>
                                <th>{{translate('total_Amount')}}</th>
                                <th>{{translate('order_Status')}}</th>
                                <th>{{translate('order_Type')}}</th>
                                <th class="text-center">{{translate('actions')}}</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">
                        @foreach($orders as $key=>$order)

                            <tr class="status-{{$order['order_status']}} class-all">
                                <td class="">
                                    {{ $orders->firstitem()+$key }}
                                </td>
                                <td>
                                    <a class="text-dark" href="{{route('branch.orders.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
                                </td>
                                <td>
                                    <div>
                                        {{date('d-m-Y',strtotime($order['created_at']))}}
                                    </div>
                                    <div>{{date('h:i A',strtotime($order['created_at']))}}</div>
                                </td>
{{--                                <td>12:30:00 - 15:30:00</td>--}}
                                <td>
                                    @if($order->customer)
                                        <a class="text-dark text-capitalize"
                                        href="{{route('branch.orders.details',['id'=>$order['id']])}}">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</a>
                                    @else
                                        <span class="text-capitalize text-muted">
                                            {{translate('Customer_Unavailable')}}
                                        </span>
                                    @endif
                                </td>
                                <td><span class="badge-soft-info px-2 py-1 rounded">{{$order->branch->name}}</span></td>
                                <td>
                                    <div>{{ \App\CentralLogics\Helpers::set_symbol(round($order['order_amount']))  }}</div>

                                    @if($order->payment_status=='paid')
                                        <span class="badge badge-soft-success">{{translate('paid')}}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger">{{translate('unpaid')}}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    @if($order['order_status']=='pending')
                                        <span class="badge-soft-info px-2 py-1 rounded">{{translate('pending')}}</span>
                                    @elseif($order['order_status']=='confirmed')
                                        <span class="badge-soft-info px-2 py-1 rounded">{{translate('confirmed')}}</span>
                                    @elseif($order['order_status']=='processing')
                                        <span class="badge-soft-warning px-2 py-1 rounded">{{translate('processing')}}</span>
                                    @elseif($order['order_status']=='out_for_delivery')
                                        <span class="badge-soft-warning px-2 py-1 rounded">{{translate('out_for_delivery')}}</span>
                                    @elseif($order['order_status']=='delivered')
                                        <span class="badge-soft-success px-2 py-1 rounded">{{translate('delivered')}}</span>
                                    @elseif($order['order_status']=='canceled')
                                        <span class="badge-soft-danger px-2 py-1 rounded">{{translate('cancelled')}}</span>
                                    @else
                                        <span class="badge-soft-danger px-2 py-1 rounded">{{str_replace('_',' ',$order['order_status'])}}</span>
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    @if($order['order_type']=='take_away')
                                        <span class="badge-soft-success px-2 rounded">{{translate('take_away')}}
                                        </span>
                                    @else
                                        <span class="badge-soft-success px-2 rounded">{{translate('delivery')}}
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-sm btn-outline-primary square-btn"
                                        href="{{route('branch.orders.details',['id'=>$order['id']])}}"><i
                                                class="tio-visible"></i></a>
                                        <button class="btn btn-sm btn-outline-success square-btn" target="_blank" type="button"
                                                onclick="print_invoice('{{$order->id}}')"><i
                                                class="tio-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->

                <div class="table-responsive mt-4 px-3 pagination-style">
                    <div class="d-flex justify-content-lg-end justify-content-sm-end" id="pagination">
                        <!-- Pagination -->
                        {!! $orders->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>

    <div class="modal fade" id="print-invoice" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('print')}} {{translate('invoice')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row" style="font-family: emoji;">
                    <div class="col-md-12">
                        <center>
                            <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                                   value="{{translate('Proceed, If thermal printer is ready.')}}"/>
                        <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{translate('Back')}}</a>
                        </center>
                        <hr class="non-printable">
                    </div>
                    <div class="row" id="printableArea" style="margin: auto;">

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        function searchOrder() {
            let text = $('#order_details').val();
            if(text.length > 0) {
                $('#pagination').html('');
                $.ajax({
                    url: '{{ url('/')}}/branch/orders/order-list-search',
                    type: "POST",
                    data: {
                        search: text,
                        _token:'{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(data){
                        // console.log(data.orders);

                        let item = ''
                        let length = data.orders.length;

                        $('#set-rows').html('');
                        let k = 1;
                        for(let i = 0; i < length; i++) {

                            // Parse delivery date and time strings into Moment objects
                            let deliveryDate = moment(data.orders[i].delivery_date);
                            let deliveryTime = moment(data.orders[i].delivery_time, 'HH:mm:ss');

                            // Format date and time strings as desired
                            let formattedDate = deliveryDate.format('DD-MM-YYYY'); // Format date as dd mm yyyy
                            let formattedTime = deliveryTime.format('hh:mm A'); // Format time as HH:MM AM/PM

                            let order_amount = Math.round(data.orders[i].order_amount) + ".00";

                            let payment_status = data.orders[i].payment_status;
                            if (payment_status == 'unpaid') {
                                payment_status = '<span class="text-danger">Unpaid</span>';
                            } else {
                                payment_status = '<span class="text-success">Paid</span>';
                            }

                            let order_status = data.orders[i].order_status;
                            if (order_status == 'pending') {
                                order_status = '<span class="badge-soft-info px-2 py-1 rounded">{{translate("pending")}}</span>';
                            } else if (order_status == 'confirmed') {
                                order_status = '<span class="badge-soft-info px-2 py-1 rounded">{{translate("confirmed")}}</span>';
                            } else if (order_status == 'processing') {
                                order_status = '<span class="badge-soft-warning px-2 py-1 rounded">{{translate("processing")}}</span>';
                            } else if (order_status == 'out_for_delivery') {
                                order_status = '<span class="badge-soft-warning px-2 py-1 rounded">{{translate("out_for_delivery")}}</span>';
                            } else if (order_status == 'delivered') {
                                order_status = '<span class="badge-soft-success px-2 py-1 rounded">{{translate("delivered")}}</span>';
                            } else if (order_status == 'failed') {
                                order_status = '<span class="badge-soft-danger px-2 py-1 rounded">{{translate("failed")}}</span>';
                            } else if (order_status == 'returned') {
                                order_status = '<span class="badge-soft-danger px-2 py-1 rounded">{{translate("returned")}}</span>';
                            } else if (order_status == 'canceled') {
                                order_status = '<span class="badge-soft-danger px-2 py-1 rounded">{{translate("cancelled")}}</span>';
                            } else if (order_status == 'returned') {
                                order_status = '<span class="badge-soft-danger px-2 py-1 rounded">{{translate("returned")}}</span>';
                            } else {
                                order_status = '<span class="badge-soft-danger px-2 py-1 rounded">{{translate("done")}}</span>';
                            }

                            let order_type = data.orders[i].order_type;
                            order_type = order_type.replace("_", " ");
                            order_type = order_type.toLowerCase().charAt(0).toUpperCase() + order_type.toLowerCase().slice(1);
                            order_type = '<span class="badge-soft-success px-2 py-1 rounded">' + order_type + '</span>';

                            let contact_person_name = '';
                            let contact_person_name_url = '';
                            let is_guest = data.orders[i].is_guest;
                            let delivery_address = data.orders[i].delivery_address;

                            if(is_guest == 0) {
                                if (delivery_address != null) {
                                    contact_person_name = data.orders[i].delivery_address.contact_person_name;
                                    contact_person_name_url = '{{ url('/') }}/branch/customer/view/' + data.orders[i].user_id;
                                    contact_person_name = '<a class="text-dark text-capitalize" href="' + contact_person_name_url + '">'+contact_person_name+'</a>';
                                }
                            } else {
                                contact_person_name = '<span class="text-capitalize text-info">Guest Customer</span>';
                            }                          

                            let order_id = data.orders[i].id;
                            let order_url = '{{ url('/') }}/branch/orders/details/' + order_id;
                            let print_url = '{{ url('/') }}/branch/orders/generate-invoice/' + order_id;

                            let branch_name = data.branch_name[0].name;
                            
                            item += '<tr>' +
                                        '<td>' + k + '</td>' +
                                        '<td><a class="text-dark" href="' + order_url + '">' + order_id + '</a></td>' +
                                        '<td><div>' + formattedDate + '</div> <div>' + formattedTime + '</div></td>' +
                                        '<td>' + contact_person_name + '</td>' +
                                        '<td><span class="badge-soft-info px-2 py-1 rounded">' + branch_name + '</span></td>' +
                                        '<td><div>₹' + order_amount + '</div>' + payment_status + '</td>' +
                                        '<td>' + order_status + '</td>' +
                                        '<td>' + order_type + '</td>' +
                                        '<td>' + 
                                            '<div class="d-flex gap-2">' +
                                                '<a class="btn btn-sm btn-outline-primary square-btn" href="' + order_url + '">' +
                                                    '<i class="tio-invisible"></i>' +
                                                '</a>' +
                                                '<button type="button" class="btn btn-sm btn-outline-success square-btn" onclick="print_invoice('+order_id+')">' +
                                                    '<i class="tio-print"></i>' +
                                                '</button>' +
                                            '</div>' +
                                        '</td>' +
                                    '</tr>';
                            k++;
                        }
                        $('#set-rows').html(item);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                location.reload();
            }
        }
    </script>
    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('branch.order.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.card-footer').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>

    <script>
        function print_invoice(order_id) {
            $.get({
                url: '{{url('/')}}/branch/pos/invoice/'+order_id,
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    console.log("success...")
                    $('#print-invoice').modal('show');
                    $('#printableArea').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function printDiv(divName) {

            if($('html').attr('dir') === 'rtl') {
                $('html').attr('dir', 'ltr')
                var printContents = document.getElementById(divName).innerHTML;
                document.body.innerHTML = printContents;
                $('#printableAreaContent').attr('dir', 'rtl')
                window.print();
                $('html').attr('dir', 'rtl')
                location.reload();
            }else{
                var printContents = document.getElementById(divName).innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                location.reload();
            }

        }

    </script>

    <script>

    </script>
    @php($date_format=\App\Model\BusinessSetting::where('key','date_format')->first()->value)
    <script>
             
       $(function () {
           // Initialize the datepicker for the "from_date" input field
           $("#from_date").datepicker({
               dateFormat: "<?php echo $date_format ?>", // Customize the date format
               changeMonth:true,
               changeYear:true, //
           });
    
           // Initialize the datepicker for the "to_date" input field
           $("#to_date").datepicker({
               dateFormat: "<?php echo $date_format ?>", // Customize the date format
               changeMonth:true,
               changeYear:true,
           });
       });
       
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include jQuery UI library -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!-- Include jQuery UI CSS for styling -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
    // Function to validate the date input
    function validateDates() {
       var fromDate = new Date(document.getElementById("from_date").value);
       var toDate = new Date(document.getElementById("to_date").value);
    
       if (fromDate > toDate) {
           alert("End date cannot be less than the start date");
           return false; // Prevent form submission
       }
       return true; // Allow form submission
    }
    
    // Attach the validation function to the form submission
    document.querySelector("form").addEventListener("submit", validateDates);
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
         $('#datatable').dataTable({
     destroy: true,
     ...
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
                paging: false,
                searching: false,
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
