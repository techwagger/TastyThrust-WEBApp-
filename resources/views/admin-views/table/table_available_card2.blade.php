{{--@dd($tables)--}}
@if($tables != null)
@foreach($tables as $table)
    <div class="dropright">
        <div class="card table_hover-btn py-4 {{ $table['order'] != null ? 'bg-card' : 'bg-gray'}} stopPropagation"
{{--             data-toggle="modal" data-target="#tableInfoModal"--}}
        >
            <div class=" mx-3 position-relative text-center card-design">
{{--                next release--}}
{{--                <i class="tio-alarm-alert position-absolute right-0 top-0 fz-18 text-primary"></i>--}}
                <!-- <h3 class="card-title mb-2">{{ translate('table') }}</h3> -->
                <h5 class="card-title mb-1 card-number"><span>{{ $table['number'] }}</span></h5>
                <h5 class="card-title mb-1" >{{ translate('capacity') }}: {{ $table['capacity'] }}</h5>
                <button type="button" class="btn btn-primary btn-card" data-toggle="modal" data-target="#myModal{{ translate('table').$table['number'] }}">
                    View Details
                </button>
            </div>
        </div>
        {{-- <div class="table_hover-menu px-3">
            
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="text-center position-relative px-4 py-5">
                        <h3 class="mb-3">{{ translate('Table - ') }}{{ $table['number'] }}</h3>
                        @if(($table['order'] != null))
                            @foreach($table['order'] as $order)
                            <table class="order-table">
                                <tr>
                                    <th>{{ translate('Order ID') }}</th>
                                    <td>
                                        <span class="order-id-container">
                                            <strong>{{ $order['id'] }}</strong>
                                        </span>
                                    </td>
                                </tr>
                                <!-- Add more rows if needed for additional information -->
                            </table>
                            @endforeach
                        @else
                            <div class="fz-14 mb-1">{{ translate('current status') }} - <strong>{{ translate('empty') }}</strong></div>
                            <div class="fz-14 mb-1">{{ translate('any reservation') }} - <strong>{{ translate('N/A') }}</strong></div>
                        @endif
            {{-- next release--}}
            {{--            <div class="d-flex flex-wrap gap-2 mt-3">--}}
            {{--                <a href="#" data-dismiss="modal" class="btn btn-outline-primary text-nowrap stopPropagation" data-toggle="modal" data-target="#reservationModal"><i class="tio-alarm-alert"></i> {{ translate('Create_Reservation') }}</a>--}}
            {{--                <a href="#" class="btn btn-primary text-nowrap">{{ translate('Place_Order') }}</a>--}}
            {{--            </div>--}}
            
                        {{-- <div class="d-flex mt-5 mx-lg-5">
                            <a href="#" class="btn btn-outline-primary w-100 text-nowrap" data-dismiss="modal" data-toggle="modal" data-target="#reservationModal"><i class="tio-alarm-alert"></i> {{ translate('Create_Reservation') }}</a>
                        </div> --}}
                    {{-- </div>
                </div>
              </div>
        </div>  --}}
        
        <!-- The Modal -->
        <div class="modal fade" id="myModal{{ translate('table').$table['number'] }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ translate('Table - ') }}{{ $table['number'] }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        @if(($table['order'] != null))
                            <div style="width: 100%; height: auto; max-height: 500px; overflow: auto">
                                <table class="table  table-bordered">
                                    <thead>
                                        <tr>
                                            <th><span class="snnumber">S.No.</span></th>
                                            <th><span class="orderidsd">{{ translate('Order ID') }}</th>
                                            <th><span class="orderamountsd">{{ translate('Order Amount') }}</th>
                                            <th><span class="orderdeatesd">{{ translate('Order Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($table['order'] as $order)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $order['id'] }}</td>
                                                <td>{{\App\CentralLogics\Helpers::currency_symbol()}} {{ number_format((float)$order['order_amount'], 2, '.', '') }}</td>
                                                <td>{{ date('d-m-Y',strtotime($order['created_at'])) .' '. date(config('time_format'), strtotime($order['created_at'])) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                            
                            </div>
                        @else
                            <div class="fz-14 mb-1">{{ translate('current status') }} - <strong>{{ translate('empty') }}</strong></div>
                            <div class="fz-14 mb-1">{{ translate('any reservation') }} - <strong>{{ translate('N/A') }}</strong></div>
                        @endif
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
@endforeach
@else
    <div class="col-md-12 text-center">
        <h4 class="">{{translate('This branch has no table')}}</h4>
    </div>
@endif

{{--next release--}}
<!-- tAble Info Modal -->
<div class="modal fade" id="tableInfoModal" tabindex="-1" role="dialog" aria-labelledby="tableInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="text-center position-relative px-4 py-5">
            <button type="button" class="close text-primary position-absolute right-2 top-2 fz-24" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <h3 class="mb-3">{{ translate('Table# - D2 ') }}</h3>
            <div class="fz-14 mb-1">{{ translate('current status') }} - <strong>{{ translate('Available') }}</strong></div>
            <div class="fz-14 mb-1">{{ translate('any reservation') }} - <strong>{{ translate('5 Reservation') }}</strong></div>

            <div class="d-flex flex-wrap justify-content-center text-nowrap gap-2 mt-4">
                <div class="bg-gray rounded d-flex flex-column gap-2 p-3">
                    <h6 class="mb-0">Today</h6>
                    <p class="mb-0">12:00 - 23:00</p>
                </div>
                <div class="bg-gray rounded d-flex flex-column gap-2 p-3">
                    <h6 class="mb-0">Tomorrow</h6>
                    <p class="mb-0">12:00 - 23:00</p>
                    <p class="mb-0">12:00 - 23:00</p>
                </div>
                <div class="bg-gray rounded d-flex flex-column gap-2 p-3">
                    <h6 class="mb-0">Today</h6>
                    <p class="mb-0">12:00 - 23:00</p>
                </div>
            </div>

            <div class="d-flex mt-5 mx-lg-5">
                <a href="#" class="btn btn-outline-primary w-100 text-nowrap" data-dismiss="modal" data-toggle="modal" data-target="#reservationModal"><i class="tio-alarm-alert"></i> {{ translate('Create_Reservation') }}</a>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Reservatrion Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="table_hover-menu px-3">
            <h3 class="mb-3">{{ translate('Table - ') }}{{ $table['number'] }}</h3>
            @if(($table['order'] != null))
                @foreach($table['order'] as $order)
                    <div class="fz-14 mb-1">{{ translate('order id') }}: <strong>{{ $order['id'] }}</strong></div>
                @endforeach
            @else
                <div class="fz-14 mb-1">{{ translate('current status') }} - <strong>{{ translate('empty') }}</strong></div>
                <div class="fz-14 mb-1">{{ translate('any reservation') }} - <strong>{{ translate('N/A') }}</strong></div>
            @endif
{{-- next release--}}
{{--            <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                <a href="#" data-dismiss="modal" class="btn btn-outline-primary text-nowrap stopPropagation" data-toggle="modal" data-target="#reservationModal"><i class="tio-alarm-alert"></i> {{ translate('Create_Reservation') }}</a>--}}
{{--                <a href="#" class="btn btn-primary text-nowrap">{{ translate('Place_Order') }}</a>--}}
{{--            </div>--}}
        </div>
    </div>
  </div>
</div>

<style>
    /* Add these styles to your CSS or style section */
    .order-table {
        width: 100%; /* Set the width of the table */
        border-collapse: collapse; /* Collapse borders for a cleaner look */
        margin-top: 10px; /* Adjust margin as needed */
    }

    .order-table th, .order-table td {
        padding: 10px; /* Set padding for cells */
        border: 1px solid #ddd; /* Add a border to cells for separation */
        text-align: left; /* Align text to the left within cells */
    }

    .order-id-container {
        background-color: #3498db; /* Set your desired background color */
        color: #ffffff; /* Set your desired text color */
        padding: 8px; /* Adjust padding as needed */
        border-radius: 4px; /* Add border-radius for rounded corners */
        display: inline-block; /* Make it inline-block to fit content */
    }

    .order-id-container strong {
        font-weight: bold; /* Make the strong element bold */
        color: #e74c3c; /* Set a different color for the strong element */
    }
</style>