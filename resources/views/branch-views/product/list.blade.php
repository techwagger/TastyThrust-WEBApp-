@extends('layouts.branch.app')

@section('title', translate('Product List'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<style>
    .dataTables_paginate.paging_simple_numbers {
    margin: 10px;
}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    display: inline-block !important;
    min-width: 20px !important;
    padding: 5px 10px !important;
    margin-left: 2px !important;
    text-align: center !important;
    text-decoration: none !important;
    cursor: pointer !important;
    color: #8c98a4 !important;
    border: 1px solid transparent !important;
    border-radius: .3125rem !important;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff!important;
    background-color: #ff611d;
    border-color: #ff611d;
}
</style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/product.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Product_List')}}
                </span>
            </h2>
            {{-- <span class="badge badge-soft-dark rounded-50 fz-14">{{ $products->total() }}</span> --}}
            <span class="badge badge-soft-dark rounded-50 fz-14">{{ count($products) }}</span>
        </div>
        <!-- End Page Header -->


        <div class="row g-2">
            <div class="col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-top px-card pt-4">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-lg-4">
                                <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group" style="display: none">
                                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('search_by_product_name')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <div class="set_table ">
                        <div class="table-responsive datatable_wrapper_row " id="set-rows" style="padding:0 10px;">
                            <table id="datatable" class="mt-3 table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="padding-right: 10px">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('product_name')}}</th>
                                    <th>{{translate('price')}}</th>
                                    <th>{{translate('stock')}}</th>
                                    <th>{{translate('Availability')}}</th>
                                    <th>{{translate('update_price')}}</th>
                                </tr>
                                </thead>

                                <tbody id="set-rows">
                                    @php($i = 1)
                                @foreach($products as $key=>$product)
                                    <tr>
                                        {{-- <td>{{$products->firstitem()+$key}}</td> --}}
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="media align-items-center gap-3 category-mid">
                                                <div class="avatar">
                                                    <img src="{{asset('storage/app/public/product')}}/{{$product['image']}}" class="rounded img-fit"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                                </div>
                                                <div class="media-body branch-width">
                                                        {{ Str::limit($product['name'], 30) }}
                                                </div>
                                            </div>
                                        </td>

                                        @php($pb = json_decode($product->product_by_branch, true))
                                        @if(isset($pb[0]))
                                            <td>{{ Helpers::set_symbol($pb[0]['price']) }}</td>
                                        @else
                                            <td>{{ Helpers::set_symbol($product['price']) }}</td>
                                        @endif
                                        <td>
                                            <div><span class="">{{ translate('Stock Type') }} : {{ ucfirst($product->sub_branch_product?->stock_type) }}</span></div>
                                            @if(isset($product->sub_branch_product) && $product->sub_branch_product->stock_type != 'unlimited')
                                                <div><span class="">{{ translate('Stock') }} : {{ $product->sub_branch_product->stock - $product->sub_branch_product->sold_quantity }}</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <label class="switcher">
                                                    @forelse($product->product_by_branch as $item)
                                                        <input id="{{$product['id']}}" class="switcher_input"
                                                            type="checkbox" {{ ($item->product_id == $product->id) && $item->is_available == 1 ? 'checked' : ''}}
                                                            data-url="{{route('branch.product.status',[$product['id'],0])}}" onchange="status_change(this)">
                                                        <span class="switcher_control"></span>
                                                    @empty
                                                        <input id="{{$product['id']}}" class="switcher_input" type="checkbox"
                                                            data-url="{{route('branch.product.status',[$product['id'],0])}}" onchange="status_change(this)">
                                                        <span class="switcher_control"></span>
                                                    @endforelse
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2 category-mid">
                                                <a class="btn btn-outline-info btn-sm edit square-btn"
                                                    href="{{route('branch.product.set-price',[$product['id']])}}"><i class="tio-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="table-responsive mt-4 px-3 pagination-style">
                            <div class="d-flex justify-content-lg-end justify-content-sm-end">
                                <!-- Pagination -->
                                {!! $products->links() !!}
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- End Card -->
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
                url: '{{route('admin.product.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });

        function status_change(t) {
            let url = $(t).data('url');
            let checked = $(t).prop("checked");
            let status = checked === true ? 1 : 0;

            Swal.fire({
                // title: 'Are you sure?',
                text: 'Want to change status',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FC6A57',
                cancelButtonColor: 'default',
                cancelButtonText: '{{translate("No")}}',
                confirmButtonText: '{{translate("Yes")}}',
                reverseButtons: true
            }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: url,
                            data: {
                                status: status
                            },
                            success: function (data, status) {
                                // console.log(data.variation_message);
                                // console.log(data.success_message);

                                if(data.variation_message !== undefined ){
                                    toastr.error(data.variation_message);

                                }
                                if(data.success_message !== undefined ){
                                    toastr.success(data.success_message);

                                }
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            },
                            error: function (data) {
                                toastr.error("{{translate('Status changed failed')}}");
                            },
                        });
                    }

                    else if (result.dismiss) {
                        if (status == 1) {
                            $('#' + t.id).prop('checked', false)

                        } else if (status == 0) {
                            $('#'+ t.id).prop('checked', true)
                        }
                        toastr.info("{{translate("Status hasn't changed")}}");
                    }
                }
            )
        }

    </script>
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
