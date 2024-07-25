@extends('layouts.admin.app')

@section('title', translate('Banner list'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->

        {{-- abhi  --}}
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/banner.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Banner_Setup')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->
        <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css">
        <script src="https://unpkg.com/cropperjs"></script>
        <div class="row g-2">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data" id="bannerForm">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('title')}}<span class="text-danger ml-1">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="{{translate('New banner')}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('item_Type')}}<span class="text-danger ml-1">*</span></label>
                                        <select name="item_type" class="custom-select js-select2-custom" onchange="show_item(this.value)">
                                            <option selected disabled>{{translate('select_item_type')}}</option>
                                            <option value="product">{{translate('product')}}</option>
                                            <option value="category">{{translate('category')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type-product">
                                        <label class="input-label">{{translate('product')}} <span class="text-danger ml-1">*</span></label>
                                        <select name="product_id" class="custom-select js-select2-custom">
                                            <option selected disabled>{{translate('select_a_product')}}</option>
                                            @foreach(\App\Model\Product::all() as $product)
                                                <option value="{{$product['id']}}">{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="type-category" style="display: none">
                                        <label class="input-label">{{translate('category')}} <span class="text-danger ml-1">*</span></label>
                                        <select name="category_id" class="custom-select js-select2-custom">
                                            <option selected disabled>{{translate('select_a_category')}}</option>
                                            @foreach(\App\Model\Category::where('parent_id', 0)->get() as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{ translate('banner_Image') }}</label>
                                            <small class="text-danger">* ( {{ translate('ratio 3:1') }} )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" name="image" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input" id="imageInput">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img width="465" class="ratio-3-to-1" id="viewer" src="{{ asset('public/assets/admin/img/icons/upload_img2.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" id="submit-btn" class="btn btn-primary">{{translate('submit')}}</button>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Initialize Cropper.js
                                    var imageInput = document.getElementById('imageInput');
                                    var viewer = document.getElementById('viewer');
                                    var cropper;
                            
                                    imageInput.addEventListener('change', function () {
                                        var file = this.files[0];
                            
                                        if (file) {
                                            var reader = new FileReader();
                            
                                            reader.onload = function (e) {
                                                viewer.src = e.target.result;
                            
                                                if (cropper) {
                                                    cropper.destroy();
                                                }
                            
                                                cropper = new Cropper(viewer, {
                                                    aspectRatio: 3 / 1,
                                                    viewMode: 3, // You can adjust this value based on your requirements
                                                });
                                            };
                            
                                            reader.readAsDataURL(file);
                                        }
                                    });
                            
                                    // Handle form submission
                                    var bannerForm = document.getElementById('bannerForm');
                            
                                    bannerForm.addEventListener('submit', function (event) {
                                        $("#submit-btn").attr("disabled", true);
                                        event.preventDefault();

                            
                                        // Get the cropped data
                                        var croppedCanvas = cropper.getCroppedCanvas();
                            
                                        if (!croppedCanvas) {
                                            alert('Please select an area to crop.');
                                            return;
                                        }
                            
                                        // Convert the canvas data to a blob
                                        croppedCanvas.toBlob(function (blob) {
                                            // Create a new FormData and append the cropped image blob
                                            var formData = new FormData(bannerForm);
                                            formData.set('image', blob, 'cropped_image.png');
                            
                                            // Use fetch API or AJAX to submit the cropped image data
                                            // Use fetch API or AJAX to submit the cropped image data
                                    fetch('{{ route('admin.banner.store') }}', {
                                        method: 'POST',
                                        body: formData,
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            // Handle the response if needed
                                            console.log(data);
                                            alert('Successfully uploaded Banner!');
                                            // You can also reset the form or perform any other actions after a successful upload
                                            bannerForm.reset();
                                            $("#submit-btn").removeAttr("disabled");
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            // Display an error message to the user if the upload fails
                                            alert('Banner Added Successfully!.');
                                            $("#submit-btn").removeAttr("disabled");
                                            window.location.reload();
                                            
                                        });

                                        });
                                    });
                                });
                            </script>
                            
                            
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

        <div class="row g-2">
            <div class="col-12">
                <!-- Card -->
                <div class="card">
                    <div class="new-top px-card ">
                        <div class="row align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h5 class="d-flex align-items-center gap-2 mb-0">
                                    {{translate('Banner_List')}}
                                    <span class="badge badge-soft-dark rounded-50 fz-12">{{count($banners)}}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group">
                                        {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search_by_Title')}}" aria-label="Search" value="" required="" autocomplete="off"> --}}
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

                    <!-- Table -->
                    <div class="set_table banner-tbl">
                        <div class="table-responsive datatable_wrapper_row "  style="padding-right: 10px;">
                            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('Banner_Image')}}</th>
                                    <th>{{translate('title')}}</th>
                                    <th>{{translate('Item_Type')}}</th>
                                    <th>{{translate('status')}}</th>
                                    <th>{{translate('action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($banners as $key=>$banner)
                                    <tr>
                                        {{-- <td>{{$banners->firstitem()+$key}}</td> --}}
                                        <td class="text-center">{{($key+1)}}</td>
                                        <td>
                                            <img class="img-vertical-150" src="{{asset('storage/app/public/banner')}}/{{$banner['image']}}"
                                                onerror="this.src='{{asset('public/assets/admin/img/900x400/img1.jpg')}}'">
                                        </td>
                                        <td>
                                            <div class="max-w300 text-wrap">
                                                {{-- {{$banner['title']}} --}}
                                                <?php 
                                                    $title = $banner['title'];
                                                    if (strlen($title) > 15) {
                                                        echo substr($title, 0, 15)."...";
                                                    } else {
                                                        echo $title;
                                                    }
                                                ?>
                                            </div>
                                        </td>
                                        @if(isset($banner->category_id))
                                            <td>
                                                {{translate('category')}} : 
                                                {{-- {{substr(\App\Model\Category::find($banner->category_id)?->name, 0, 15)}} --}}
                                                <?php 
                                                    $category_name = \App\Model\Category::find($banner->category_id)?->name;
                                                    if (strlen($category_name) > 25) {
                                                        echo substr($category_name, 0, 25)."...";
                                                    } else {
                                                        echo $category_name;
                                                    }
                                                ?>
                                            </td>
                                        @elseif(isset($banner->product_id))
                                            <td>
                                                {{translate('product')}} : 
                                                {{-- {{ substr(\App\Model\Product::find($banner->product_id)?->name,0, 15) }} --}}
                                                <?php 
                                                    $product_name = \App\Model\Product::find($banner->product_id)?->name;
                                                    if (strlen($product_name) > 25) {
                                                        echo substr($product_name, 0, 25)."...";
                                                    } else {
                                                        echo $product_name;
                                                    }
                                                ?>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td>
                                            <label class="switcher ">
                                                <input class="switcher_input" type="checkbox" {{$banner['status']==1 ? 'checked' : ''}} id="{{$banner['id']}}"
                                                    data-url="{{route('admin.banner.status',[$banner['id'],0])}}" onchange="status_change(this)">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex  gap-2">
                                                <a class="btn btn-outline-info btn-sm edit square-btn"
                                                    href="{{route('admin.banner.edit',[$banner['id']])}}"><i class="tio-edit"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn"
                                                    onclick="form_alert('banner-{{$banner['id']}}','{{translate('Want to delete this banner')}}')"><i class="tio-delete"></i></button>
                                            </div>
                                            <form action="{{route('admin.banner.delete',[$banner['id']])}}"
                                                method="post" id="banner-{{$banner['id']}}">
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
                                {{-- {!! $banners->links() !!} --}}
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });


        function show_item(type) {
            if (type === 'product') {
                $("#type-product").show();
                $("#type-category").hide();
            } else {
                $("#type-product").hide();
                $("#type-category").show();
            }
        }
    </script>

    <script>
        $(".js-select2-custom").select2({
            placeholder: "Select a state",
            allowClear: true
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
