@extends('layouts.admin.app')

@section('title', translate('Deliveryman List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/deliveryman.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Delivery_partner')}}
                </span>
            </h2>
            <span class="badge badge-soft-dark rounded-circle fz-12">{{ count($delivery_men) }}</span>
        </div>
        <!-- End Page Header -->


        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-top px-card ">
                        <div class="d-flex flex-column flex-md-row flex-wrap  justify-content-start align-items-md-center">
                            <form action="{{url()->current()}}" method="GET">
                                
                            </form>

                            <div class="d-flex flex-wrap justify-content-start gap-3">
                                <div>
                                    <button type="button" class="btn btn-attribute btn-outline-primary text-nowrap" data-toggle="dropdown" aria-expanded="false">
                                        <i class="tio-download-to"></i>
                                        Export
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a type="submit" class="dropdown-item d-flex align-items-center gap-2" href="{{route('admin.delivery-man.excel-export')}}">
                                                <img width="14" src="{{asset('public/assets/admin/img/icons/excel.png')}}" alt="">
                                                {{ translate('Excel') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                 <a href="{{route('admin.delivery-man.add')}}" class="btn-attribute btn btn-primary">
                                    <i class="tio-add"></i>
                                    {{translate('add_Delivery_partner')}}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 set_table  new-responsive customer-style ">
                        <div class="table-responsive datatable_wrapper_row " id="set-rows" style="padding-right: 10px;">
                            <table id="datatable"  class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{translate('SL')}}</th>
                                        <th>{{translate('name')}}</th>
                                        <th>{{translate('Contact_Info ')}}</th>
                                        <th>{{translate('Total_Orders')}}</th>
                                        <th>{{translate('Status')}}</th>
                                        <th>{{translate('action')}}</th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                @foreach($delivery_men as $key=>$dm)
                                    <tr>
                                        {{-- <td>{{$delivery_men->firstitem()+$key}}</td> --}}
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <div class="media gap-3 align-items-center category-mid">
                                                <div class="avatar">
                                                    <img width="60" class="img-fit rounded-circle"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                        src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}">
                                                    {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                                                </div>
                                                <div class="media-body name-width">
                                                    {{$dm['f_name'].' '.$dm['l_name']}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <div>
                                                    <a class="text-dark" href="mailto:{{$dm['email']}}">
                                                        <strong>{{$dm['email']}}</strong>
                                                    </a>
                                                </div>
                                                <a class="text-dark" href="tel:{{$dm['phone']}}">{{$dm['phone']}}</a>
                                            </div>
                                        </td>
                                        <td><span class="badge fz-14 badge-soft-info px-5">{{ $dm['orders_count'] }}</span></td>
                                        <td>
                                            <label class="switcher category-mid">
                                                <input id="{{$dm['id']}}" type="checkbox" class="switcher_input" {{$dm['is_active'] == 1? 'checked' : ''}}
                                                       data-url="{{route('admin.delivery-man.ajax-is-active', ['id'=>$dm['id']])}}" onchange="status_change(this)"
                                                >
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex  gap-3">
                                                <a class="btn btn-outline-info btn-sm edit square-btn"
                                                href="{{route('admin.delivery-man.edit',[$dm['id']])}}"><i class="tio-edit"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                onclick="form_alert('delivery-man-{{$dm['id']}}','{{translate('Want to remove this information ?')}}')"><i class="tio-delete"></i></button>
                                            </div>
                                            <form action="{{route('admin.delivery-man.delete',[$dm['id']])}}"
                                                method="post" id="delivery-man-{{$dm['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="table-responsive px-3 mt-3 pagination-style">
                            <div class="d-flex justify-content-end justify-content-sm-end">
                                {{-- {!! $delivery_men->links() !!} --}}
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
                paging: true,
                info :false,
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
    
@endpush