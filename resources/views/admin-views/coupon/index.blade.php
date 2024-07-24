@extends('layouts.admin.app')

@section('title', translate('Add new coupon'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">


@endpush

@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/coupon.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Add_New_Coupon')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.coupon.store')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('')}} {{translate('type')}}</label>
                                        <select name="coupon_type" class="custom-select" onchange="coupon_type_change(this.value)">
                                            <option value="default">{{translate('default')}}</option>
                                            <option value="first_order">{{translate('first order')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('Title')}}<span style="color: red">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="{{ translate('New coupon') }}" required maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label class="input-label">{{translate('Code')}}<span style="color: red">*</span></label>
                                            <a href="javascript:void(0)" class="float-right c1 fz-12" onclick="generateCode()">{{translate('generate_code')}}</a>
                                        </div>
                                        <input type="text" name="code" id="coupon-code" class="form-control" maxlength="15"
                                            placeholder="{{\Illuminate\Support\Str::random(8)}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6" id="limit-for-user">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('limit')}} {{translate('for')}} {{translate('same')}} {{translate('user')}}<span style="color: red">*</span></label>
                                        <input type="text" name="limit" id="user-limit" class="form-control" placeholder="{{ translate('EX: 10') }}" required min="1">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('discount_Type')}}<span style="color: red">*</span></label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            <option value="percent">{{translate('percent')}}</option>
                                            <option value="amount">{{translate('amount')}} {{ __('(in :currency)', ['currency' => \App\CentralLogics\Helpers::currency_symbol()]) }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label text-capitalize" id="discount_label">{{translate('discount')}}<span style="color: red">*</span></label>
                                        <input type="text" step="any" min="1" max="10000" placeholder="{{translate('Ex: 50%')}}" id="discount_input" name="discount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('minimum')}} {{translate('purchase')}}</label>
                                        <input type="text" step="any" id="min_purchase" name="min_purchase" value="0" min="0" max="100000" class="form-control"
                                            placeholder="{{ translate('100') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6" id="max_discount_div">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('maximum')}} {{translate('discount')}}</label>
                                        <input type="number" step="any" min="0" value="0" max="1000000" id="max_discount" name="max_discount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('start')}} {{translate('date')}}<span style="color: red">*</span></label>
                                        <input type="text" id="from_date" name="start_date" class="form-control" autocomplete="off"  placeholder="DD-MM-YYYY">
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('expire')}} {{translate('date')}}<span style="color: red">*</span></label>
                                        <input type="text" id="to_date"  name="expire_date" class="form-control allow-future-dates" autocomplete="off" placeholder="DD-MM-YYYY" >
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
                    <div class="new-top px-card ">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h5 class="d-flex align-items-center gap-2 mb-0">
                                    {{translate('Coupon_Table')}}
                                    <span class="badge badge-soft-dark rounded-50 fz-12">{{ count($coupons)}}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{url()->current()}}" class="mb-0" method="GET">
                                    <div class="input-group">
                                        {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Title')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off"> --}}
                                        <div class="input-group-append">
                                            {{-- <button type="submit" class="btn btn-primary">
                                                {{translate('Search')}}
                                            </button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="set_table">
                        <div class="table-responsive datatable_wrapper_row"  style="padding-right: 10px;">
                            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{translate('SL')}}</th>
                                        <th>{{translate('Coupon')}}</th>
                                        {{-- <th>{{translate('min_Purchase')}}</th>
                                        <th>{{translate('max_Discount')}}</th> --}}
                                        <th>{{translate('Amount')}}</th>
                                        {{-- <th>{{translate('discount')}}</th> --}}
                                        <th>{{translate('Coupon_Type')}}</th>
                                        {{-- <th>{{translate('discount_Type')}}</th> --}}
                                        <th>{{translate('duration')}}</th>
                                        <th>{{translate('status')}}</th>
                                        <th>{{translate('action')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($coupons as $key=>$coupon)
                                    <tr>
                                        {{-- <td>{{$coupons->firstItem()+$key}}</td> --}}
                                        <td class="text-center">{{($key+1)}}</td>
                                        <td>
                                            <div>
                                                <div class="fz-14"><strong>{{translate('code')}}: {{$coupon['code']}}</strong></div>
                                                <div class="max-w300 text-wrap fz-12 mt-1">{{$coupon['title']}}</div>
                                            </div>
                                        </td>
                                        @if($coupon->discount_type == 'amount')
                                            <td>{{\App\CentralLogics\Helpers::set_symbol($coupon->discount)}}</td>
                                        @else
                                            <td>{{$coupon->discount}}%</td>
                                        @endif
                                        {{-- <td>{{$coupon['discount']}}</td> --}}
                                        <td>{{translate($coupon->discount_type)}}</td>
                                        {{-- <td>{{$coupon['discount_type']}}</td> --}}
                                        <td><div class="text-muted">{{date('d-m-Y', strtotime($coupon['start_date']))}} - {{date('d-m-Y', strtotime($coupon['expire_date']))}}</div></td>
                                        <td>
                                            <label class="switcher category-mid">
                                                <input id="{{$coupon['id']}}" class="switcher_input" type="checkbox" onchange="status_change(this)" {{$coupon['status']==1? 'checked': '' }}
                                                    data-url="{{route('admin.coupon.status',[$coupon['id'],1])}}"
                                                >
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex  gap-2">
                                                <a class="btn btn-outline-primary btn-sm edit square-btn openBtn" id="{{$coupon['id']}}" onclick="modalShow(this)">
                                                    <i class="tio-invisible"></i>
                                                </a>

                                                <a class="btn btn-outline-info btn-sm edit square-btn"
                                                href="{{route('admin.coupon.update',[$coupon['id']])}}"><i class="tio-edit"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                onclick="form_alert('coupon-{{$coupon['id']}}','{{translate('Want to delete this coupon ?')}}')"><i class="tio-delete"></i></button>
                                            </div>
                                            <form action="{{route('admin.coupon.delete',[$coupon['id']])}}"
                                                method="post" id="coupon-{{$coupon['id']}}">
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
                                {{-- {!! $coupons->links() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="couponDetails" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered coupon-details" role="document">
            <div class="modal-content overflow-hidden">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tio-clear"></i>
                </button>
                <div class="coupon__details">

                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $("#discount_type").change(function(){
            if(this.value === 'amount') {
                $("#max_discount_div").hide();
                $("#discount_label").text("{{translate('discount_amount')}}");
                $("#discount_input").attr("placeholder", "{{translate('Ex: 500')}}")
            }
            else if(this.value === 'percent') {
                $("#max_discount_div").show();
                $("#discount_label").text("{{translate('discount_percent')}}")
                $("#discount_input").attr("placeholder", "{{translate('Ex: 50%')}}")
            }
        });
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF FLATPICKR
            // =======================================================
            $('.js-flatpickr').each(function () {
                $.HSCore.components.HSFlatpickr.init($(this));
            });
        });

        function coupon_type_change(order_type) {
            if(order_type=='first_order'){
                $('#user-limit').removeAttr('required');
                $('#limit-for-user').hide();
            }else{
                $('#user-limit').prop('required',true);
                $('#limit-for-user').show();
            }
        }
    </script>

    <script>
        function generateCode() {
            $.get('{{route('admin.coupon.generate-coupon-code')}}', function (data) {
                $('#coupon-code').val(data)
            });
        }

    </script>

    <script>

        function modalShow(t) {
            let couponId = t.id;
            let targetUrl = "{{route('admin.coupon.coupon-details')}}" + "?id=" + couponId;
            $.ajax({
                url: targetUrl,
                type: 'GET',
                dataType: 'json', // added data type
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    // console.log("success...");
                    console.log(data.view);


                    $('.coupon__details').html(data.view);
                    $('#couponDetails').modal('show');
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
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
      <script>
        $(document).ready(function() {
          // Set the minimum date to the current date
          var currentDate = new Date();
          $("#from_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: currentDate,
            onSelect: function(selectedDate) {
              // Optional: You can add additional logic when a date is selected
              console.log('Selected date: ' + selectedDate);
            }
          });
        });
      </script>
@endpush
