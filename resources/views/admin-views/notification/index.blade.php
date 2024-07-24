@extends('layouts.admin.app')

@section('title', translate('Add new notification'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <i class="tio-notifications "></i>
                <span class="page-header-title">
                    {{translate('send_Notification')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.notification.store')}}" id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('title')}}
                                            <i class="tio-info-outined" data-toggle="tooltip" data-placement="right" title="{{ translate('not_more_than_100_characters') }}">
                                            </i> 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" maxlength="100" class="form-control" placeholder="{{translate('title')}}" required>
                                    </div>  
                                    <div class="form-group">
                                        <label class="input-label">{{translate('description')}}
                                            <i class="tio-info-outined" data-toggle="tooltip" data-placement="right" title="{{ translate('not_more_than_255_characters') }}">
                                            </i>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description" maxlength="256" class="form-control" placeholder="{{translate('Description...')}}" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{translate('notification_Banner')}}</label>
                                            <small class="text-danger">* ( {{translate('ratio')}} 3:1 )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input" id="customFileUpload">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img  class="ratio-3-to-1" id="viewer" src="{{asset('public/assets/admin/img/icons/upload_img2.png')}}" alt="">
                                                    <input type="hidden" name="image" id="cropped-image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn-primary">{{translate('send_notification')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="new-top px-card">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-6 col-md-6 col-lg-8">
                                <h5 class="d-flex align-items-center gap-2 mb-0">
                                    {{translate('Notification_Table')}}
                                    <span class="badge badge-soft-dark rounded-50 fz-12">{{ count($notifications) }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group">
                                        {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by title or description')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off"> --}}
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


                    <div class="set_table new-responsive search-style">
                        <div class="table-responsive datatable_wrapper_row "  style="padding-right: 10px;">
                            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{translate('SL')}}</th>
                                    <th>{{translate('image')}}</th>
                                    <th>{{translate('title')}}</th>
                                    <th>{{translate('description')}}</th>
                                    <th>{{translate('status')}}</th>
                                    <th>{{translate('action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($notifications as $key=>$notification)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($notification['image']!=null)
                                                <img class="img-vertical-150"
                                                     onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                                     src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}">
                                            @else
                                                <label class="badge badge-soft-warning">{{translate('No')}} {{translate('image')}}</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="max-w300 text-wrap">
                                                {{substr($notification['title'],0,25)}} {{strlen($notification['title'])>25?'...':''}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="max-w300 text-wrap">
                                                {{substr($notification['description'],0,25)}} {{strlen($notification['description'])>25?'...':''}}
                                            </div>
                                        </td>
                                        <td>
                                            <label class="switcher category-mid">
                                                <input class="switcher_input" type="checkbox" onclick="status_change(this)" id="{{$notification['id']}}"
                                                    data-url="{{route('admin.notification.status',[$notification['id'],0])}}" {{$notification['status'] == 1? 'checked' : ''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <!-- Dropdown -->
                                            <div class="d-flex  gap-2">
                                                <a class="btn btn-outline-info btn-sm edit square-btn" href="{{route('admin.notification.edit',[$notification['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete square-btn" onclick="form_alert('notification-{{$notification['id']}}','{{translate('Want to delete this notification ?')}}')">
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </div>
                                            <form
                                                action="{{route('admin.notification.delete',[$notification['id']])}}"
                                                method="post" id="notification-{{$notification['id']}}">
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
                                {{-- {!! $notifications->links() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
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
        let cropper;
        const imageInput = document.getElementById('customFileUpload');
        const image = document.getElementById('viewer');
        const croppedImageInput = document.getElementById('cropped-image');
        const preview = document.querySelector('.preview');
    
        imageInput.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const url = URL.createObjectURL(file);
                image.src = url;
                image.style.display = 'block';
    
                if (cropper) {
                    cropper.destroy();
                }
    
                cropper = new Cropper(image, {
                    aspectRatio: 3/1,
                    viewMode: 1,
                    preview: preview,
                    crop(event) {
                        const canvas = cropper.getCroppedCanvas({
                            width: 160,
                            height: 160,
                        });
                        croppedImageInput.value = canvas.toDataURL('image/jpeg');
                    },
                });
            }
        });
    
        document.getElementById('upload-form').addEventListener('submit', function (e) {
            if (!croppedImageInput.value) {
                e.preventDefault();
                alert('Please select and crop an image.');
            }
        });
    </script>
@endpush
