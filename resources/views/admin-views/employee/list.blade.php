@extends('layouts.admin.app')

@section('title', translate('Employee List'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/employee.png')}}" alt="">
            <span class="page-header-title">
                {{translate('employee_List')}}
            </span>
            <span class="badge badge-soft-dark rounded-50 fz-12">{{count($em)}}</span>
                        
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-top px-card ">
                    <div class="d-flex flex-column flex-md-row flex-wrap gap-3 justify-content-md-between align-items-md-center">
                     

                        <div class="d-flex flex-wrap justify-content-start">
                            <form action="{{url()->current()}}" method="GET">
                                <div class="input-group">
                                    {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by name, email or phone')}}" aria-label="Search" value="" required="" autocomplete="off"> --}}
                                    <div class="input-group-append">
                                        {{-- <button type="submit" class="btn btn-primary">{{translate('Search')}}</button> --}}
                                    </div>
                                </div>
                            </form>
                            <div>
                                <button type="button" class="btn btn-attribute btn-outline-primary text-nowrap" data-toggle="dropdown" aria-expanded="false">
                                    <i class="tio-download-to"></i>
                                    Export
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a type="submit" class="dropdown-item d-flex align-items-center gap-2" href="{{route('admin.employee.excel-export')}}">
                                            <img width="14" src="{{asset('public/assets/admin/img/icons/excel.png')}}" alt="">
                                            {{ translate('Excel') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="set_table new-responsive attibute-list emp-style">
                    <div class="table-responsive datatable_wrapper_row customer-style"  style="padding-right:10px">
                        <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Contact_Info')}}</th>
                                    <th>{{translate('Role')}}</th>
                                    <th>{{translate('Status')}}</th>
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($em as $k=>$e)
                            @if($e->role)
                                <tr>
                                    {{-- <td>{{$em->firstitem()+$k}}</td> --}}
                                    <td>{{$k+1}}</td>
                                    <td class="text-capitalize">
                                        <div class="media align-items-center gap-3 category-mid">
                                            <div class="avatar">
                                                <img class="img-fit rounded-circle" src="{{asset('storage/app/public/admin')}}/{{$e['image']}}" alt=""
                                                     onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                >
                                            </div>
                                            <div class="media-body name-width">{{$e['f_name'] . ' ' . $e['l_name']}}</div>
                                        </div>
                                    </td>
                                    <td >
                                      <div><a class="text-dark" href="mailto:{{$e['email']}}"><strong>{{$e['email']}}</strong></a></div>
                                      <div><a href="tel:{{$e['phone']}}" class="text-dark">{{$e['phone']}}</a></div>
                                    </td>
                                    <td><span class="badge badge-soft-info py-1 px-2">{{$e->role['name']}}</span></td>
                                    <td>
                                        <label class="switcher category-mid" >
                                            <input type="checkbox" class="switcher_input"
                                                   onclick="location.href='{{route('admin.employee.status',[$e['id'],$e->status?0:1])}}'"
                                                   class="toggle-switch-input" {{$e->status?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 category-mid">
                                            <a href="{{route('admin.employee.update',[$e['id']])}}"
                                            class="btn btn-outline-info btn-sm square-btn"
                                            title="{{translate('Edit')}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a onclick="form_alert('employee-{{$e->id}}', '{{translate('want_to_delete_this_employee?')}}')"
                                               class="btn btn-outline-danger btn-sm delete square-btn"
                                               title="{{translate('delete')}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('admin.employee.delete')}}" method="post" id="employee-{{$e->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{$e->id}}">
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive mt-4 px-3 pagination-style">
                        <div class="d-flex justify-content-lg-end justify-content-sm-end">
                            <!-- Pagination -->
                            {{-- {{$em->links()}} --}}
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
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
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

