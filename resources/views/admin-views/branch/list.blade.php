@extends('layouts.admin.app')

@section('title', translate('Branch List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/branch.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('branch_list')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <!-- Header -->
            <div class="card-top px-card ">
                <div class="row justify-content-between align-items-center gy-2">
                    <div class="col-sm-4 col-md-6 col-lg-8">
                        <h5 class="d-flex align-items-center gap-2 mb-0">
                            {{translate('Branch_List')}}
                            <span class="badge badge-soft-dark rounded-50 fz-12">{{ count($branches) }}</span>
                        </h5>
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="#" method="GET">
                            {{-- <div class="input-group">
                                <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('search by ID or branch name')}}" aria-label="Search" value="{{$search??''}}" required="" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        {{translate('Search')}}
                                    </button>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Header -->

            <div class="set_table">
                <div class="table-responsive datatable_wrapper_row mt-2"  style="padding-right: 10px;">
                    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="padding-top:0">
                        <thead class="thead-light">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('Branch_Name')}}</th>
                            <th>{{translate('Branch_Type')}}</th>
                            <th>{{translate('Contact_Info')}}</th>
                            <th>{{translate('Promotion_campaign')}}</th>
                            <th>{{translate('status')}}</th>
                            <th>{{translate('action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($branches as $key=>$branch)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <div class="media gap-3 align-items-center ">
                                        <div class="avatar">
                                            <img width="50"  class="rounded"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                            src="{{asset('storage/app/public/branch')}}/{{$branch['image']}}"  style="height:40px" />
                                        </div>
                                        <div class="media-body">
                                            <span> {{$branch['name']}}</span>
                                            @if($branch['id']==1)
                                                <span class="badge badge-soft-danger">{{translate('main')}}</span>
                                            @else
                                                <span class="badge badge-soft-info">{{translate('sub')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{$branch->id == 1 ? translate('main_branch') : translate('sub_branch')}}</td>
                                <td>
                                    <div>
                                        <strong><a href="mailto:{{$branch['email']}}" class="mb-0 text-dark bold fz-12">{{$branch['email']}}</a></strong><br>
                                        <a href="tel:{{$branch['phone']}}" class="text-dark fz-12">{{$branch['phone']}}</a>
                                    </div>
                                </td>
                                <td>
                                    <label class="switcher category-mid">
                                        <input class="switcher_input" type="checkbox" onclick="location.href='{{route('admin.promotion.status',[$branch['id'],$branch->branch_promotion_status?0:1])}}'" {{$branch->branch_promotion_status?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switcher category-mid">
                                        <input class="switcher_input" type="checkbox" onclick="location.href='{{route('admin.branch.status',[$branch['id'],$branch->status?0:1])}}'" {{$branch->status?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </td>
                                <td>
                                    @if(env('APP_MODE')!='demo' || $branch['id']!=1)
                                        <div class="d-flex gap-3 ">
                                            <a class="btn btn-outline-info btn-sm edit square-btn"
                                                href="{{route('admin.branch.edit',[$branch['id']])}}"><i class="tio-edit"></i></a>
                                            @if($branch['id']!=1)
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                        onclick="form_alert('branch-{{$branch['id']}}','{{translate('Want to delete this branch ?')}}')"><i class="tio-delete"></i></button>
                                            @endif
                                        </div>
                                        <form action="{{route('admin.branch.delete',[$branch['id']])}}"
                                                method="post" id="branch-{{$branch['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    @else
                                        <label class="badge badge-soft-danger">{{translate('Not Permitted')}}</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mt-4 px-3 pagination-style">
                    <div class="d-flex justify-content-lg-end justify-content-sm-end">
                        <!-- Pagination -->
                        {{-- {!! $branches->links() !!} --}}
                    </div>
                </div>
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
