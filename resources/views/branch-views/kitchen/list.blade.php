@extends('layouts.branch.app')

@section('title', translate('Chef List'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/cooking.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Chef_List')}}
            </span>
            <span class="badge badge-soft-dark rounded-50 fz-12">{{$chefs->total()}}</span>
                            
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-top px-card">
                    <div class="row justify-content-between align-items-center gy-2">
                        
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-start">
                                {{-- <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group">
                                        <input id="datatableSearch_" type="search" name="search"
                                            class="form-control"
                                            placeholder="{{translate('Search_By_Name')}}" aria-label="Search"
                                            value="{{$search}}" required autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary ">
                                                {{translate('Search')}}
                                            </button>
                                        </div>
                                    </div>
                                </form> --}}
                                <a href="{{route('branch.kitchen.add-new')}}" class="btn-attribute btn btn-primary text-nowrap">
                                    <i class="tio-add"></i>
                                    <span class="text"> {{translate('Add_New')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="set_table search-set" style="padding:0 10px;">
                    <div class="table-responsive datatable_wrapper_row branch-chef-style">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{translate('SL')}}</th>
                               
                                <th>{{translate('Name')}}</th>
                                <th>{{translate('Contact Info')}}</th>
                                <th>{{translate('Branch')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chefs as $k=>$chef)
                                <tr>
                                    <td scope="row">{{$chefs->firstItem()+$k}}</td>
                                    <td>
                                    <div class="media gap-3 align-items-center category-mid">
                                                <div class="avatar">
                                                    <img width="60" class="img-fit rounded-circle"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                        src="{{asset('storage/app/public/kitchen')}}/{{$chef['image']}}">
                                                    {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                                                </div>
                                                <div class="media-body text-capitalize name-width">
                                                    {{$chef['f_name'].' '.$chef['l_name']}}
                                                </div>
                                            </div>
                                    </td>
                                    <td>
                                        <div><a class="text-dark" href="mailto:{{$chef['email']}}"><strong>{{$chef['email']}}</strong></a></div>
                                        <div><a href="tel:{{$chef['phone']}}" class="text-dark"><?php echo $chef['country_code'] != '' ? "(".$chef['country_code'].")" : '(+91)'; ?>{{$chef['phone']}}</a></div>
                                    </td>
                                    <td>{{ \App\User::get_chef_branch_name($chef) }}</td>
                                    <td>
                                        <label class="switcher category-mid">
                                            <input type="checkbox" class="switcher_input"
                                                   onclick="location.href='{{route('branch.kitchen.status',[$chef['id'],$chef->is_active?0:1])}}'"
                                                   class="toggle-switch-input" {{$chef->is_active?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{route('branch.kitchen.edit',[$chef['id']])}}"
                                            class="btn btn-outline-info btn-sm square-btn"
                                            title="{{translate('Edit')}}">
                                            <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm square-btn" title="{{translate('Delete')}}" href="javascript:"
                                            onclick="form_alert('chef-{{$chef['id']}}','{{translate('Want to delete this chef ?')}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('branch.kitchen.delete',[$chef['id']])}}"
                                              method="post" id="chef-{{$chef['id']}}">
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
                            {{$chefs->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
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
                     info    : false,
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
