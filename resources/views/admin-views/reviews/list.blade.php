@extends('layouts.admin.app')

@section('title', translate('Review List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/review.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('product_review')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-top px-card ">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h4>{{translate('review_list')}} 
                            <span id="total_count" class="badge badge-soft-dark rounded-50 fz-14">{{ count($reviews) }}</span></h4>


                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                               {{-- <form action="{{route('admin.reviews.search')}}" method="post" id="search-form" onsubmit="event.preventDefault()">
                                    @csrf
                                    <div class="input-group">
                                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('search_by_product_name')}}" aria-label="Search" value="" required="" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">{{translate('search')}}</button>
                                        </div>
                                    </div>
                                </form>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="set_table new-responsive">
                        <div class="table-responsive datatable_wrapper_row "  style="padding-right: 10px;">
                            <table id="datatable" class="mt-3 table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('product_name')}}</th>
                                    <th>{{translate('customer_info')}}</th>
                                    <th>{{translate('review')}}</th>
                                    <th>{{translate('rating')}}</th>
                                </tr>
                                </thead>
                                <tbody id="set-rows">
                                @foreach($reviews as $key=>$review)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <div class="product-category">
                                                @if($review->product)
                                                    <a class="text-dark media align-items-center gap-2 " href="{{route('admin.product.view',[$review['product_id']])}}">
                                                        <div class="avatar">
                                                            <img class="rounded img-fit" src="{{asset('storage/app/public/product')}}/{{$review->product['image']}}" alt=""
                                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                                        </div>
                                                        <span class="media-body max-w220 text-wrap text-justify name-width">{{$review->product['name']}}</span>
                                                    </a>
                                                @else
                                                    <span class="badge-pill badge-soft-dark text-muted small">
                                                        {{translate('Product unavailable')}}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($review->customer)
                                                <div class="d-flex flex-column gap-1">
                                                    <a class="text-dark" href="{{route('admin.customer.view',[$review->user_id])}}">
                                                        {{$review->customer->f_name." ".$review->customer->l_name}}
                                                    </a>
                                                    <a class="text-dark fz-12" href="tel:'{{$review->customer->phone}}'">{{$review->customer->phone}}</a>
                                                </div>
                                            @else
                                                <span class="badge-pill badge-soft-dark text-muted small">
                                                    {{translate('Customer unavailable')}}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="max-w300 line-limit-3">{{$review->comment}}</div>
                                        </td>
                                        <td>
                                            <label class="badge badge-soft-info">
                                                {{$review->rating}} <i class="tio-star"></i>
                                            </label>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4 px-3 pagination-style">
                            <div class="d-flex justify-content-lg-end justify-content-sm-end">
                                <!-- Pagination -->
                                {{-- {!! $reviews->links() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
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
                url: '{{route('admin.reviews.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#total_count').text(data.count);
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
@endpush
