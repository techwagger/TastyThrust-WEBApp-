@extends('layouts.admin.app')

@section('title', translate('Subscribed List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/subscribers.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Subscribed_Customers')}}&nbsp;
                    <span class="badge badge-soft-dark rounded-50 fz-14"> {{ count($newsletters) }}</span>
                </span>
            </h2>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <div class="card-top px-card pt-4">
                <div class="row justify-content-between align-items-center gy-2">
                    <div class="col-sm-4 col-md-6 col-lg-8">
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{url()->current()}}" method="GET">
                            <div class="input-group">
                                {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Email')}}" aria-label="Search" value="" required="" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="set_table new-responsive sale-report search-fit">
                <div class="table-responsive datatable_wrapper_row"  style="padding-right: 10px;">
                    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="">
                                    {{translate('SL')}}
                                </th>
                                <th>{{translate('email')}}</th>
                                <th>{{translate('Subscribed At')}}</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">
                        @foreach($newsletters as $key=>$newsletter)
                            <tr class="">
                                <td class="">
                                    {{$key+1}}
                                </td>
                                <td>
                                    <a class="text-dark" href="mailto:{{$newsletter['email']}}?subject={{translate('Mail from '). \App\Model\BusinessSetting::where(['key' => 'restaurant_name'])->first()->value}}">{{$newsletter['email']}}</a>
                                </td>
                                <td>{{date('Y/m/d '.config('timeformat'), strtotime($newsletter->created_at))}}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="table-responsive px-3 pagination-style">
                    <div class="d-flex justify-content-lg-end justify-content-sm-end">
                        <!-- Pagination -->
                        {{-- {!! $newsletters->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->

        <div class="modal fade" id="add-point-modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="modal-content"></div>
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
@endpush
