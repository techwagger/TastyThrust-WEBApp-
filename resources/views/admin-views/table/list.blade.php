@extends('layouts.admin.app')

@section('title', translate('Add new table'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/table.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Add_New_Table')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.table.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="number">{{translate('Table_Number')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="number" min="0" class="form-control" id="number"
                                            placeholder="{{translate('Ex')}} : {{translate('1')}}" value="{{old('number')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{translate('Table Capacity')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="capacity" class="form-control" id="capacity"
                                            placeholder="{{translate('Ex')}} : {{translate('4')}}" min="1" max="99" value="{{old('capacity')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlSelect1">{{translate('Select_Branch')}} <span class="text-danger">*</span></label>
                                        <select name="branch_id" class="custom-select" required>
                                            <option value="" selected>{{ translate('--select--') }}</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-top px-card ">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h5 class="d-flex gap-2">
                                    {{translate('Number_of_Table :')}}
                                    <span class="badge badge-soft-dark rounded-50 fz-12">{{count($tables)}}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group">
                                        {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Table Number')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off"> --}}
                                        <div class="input-group-append">
                                            {{-- <button type="submit" class="btn btn-primary">{{translate('Search')}}</button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="set_table new-responsive">
                        <div class="table-responsive datatable_wrapper_row"  style="padding-right: 10px;">
                            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('Table Number')}}</th>
                                    <th>{{translate('Table Capacity')}}</th>
                                    <th>{{translate('Branch')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th >{{translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tables as $k=>$table)
                                    <tr>
                                        {{-- <td scope="row">{{$tables->firstitem()+$k}}</td> --}}
                                        <td scope="row">{{$k+1}}</td>
                                        <td>{{$table['number']}}</td>
                                        <td>{{$table['capacity']}}</td>
                                        <td>{{$table->branch->name ?? null}}</td>
                                        <td>
                                            <label class="switcher category-mid">
                                                <input type="checkbox" class="switcher_input"
                                                        onclick="location.href='{{route('admin.table.status',[$table['id'],$table->is_active?0:1])}}'"
                                                        class="toggle-switch-input" {{$table->is_active?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex  gap-3 ">
                                                <a href="{{route('admin.table.update',[$table['id']])}}"
                                                    class="btn btn-outline-info btn-sm square-btn"
                                                    title="{{translate('Edit')}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm square-btn" title="{{translate('Delete')}}"
                                                    onclick="form_alert('table-{{$table['id']}}','{{translate('Want to delete this table ?')}}')">
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </div>
                                            <form action="{{route('admin.table.delete',[$table['id']])}}"
                                                    method="post" id="table-{{$table['id']}}">
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
                                {{-- {{$tables->links()}} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

<script>
    // Function to disallow special characters
    function disallowSpecialCharacters(input) {
        // Remove special characters using a regular expression
        input.value = input.value.replace(/[^\d]/g, '');
    }

    // Get the input element
    var number = document.getElementById('number');
    number.addEventListener('input', function () {
        disallowSpecialCharacters(this);
    });

    var capacity = document.getElementById('capacity');
    capacity.addEventListener('input', function () {
        disallowSpecialCharacters(this);
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
    $('#datatable').dataTable({
destroy: true,
...
});
</script>

@endpush

