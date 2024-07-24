@extends('layouts.admin.app')

@section('title', translate('Promotional Campaign'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/campaign.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Promotion_Setup')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.promotion.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('Select Branch')}} <span class="text-danger ml-1">*</span></label>
                                <select name="branch_id" class="custom-select" required>
                                    <option disabled selected>{{ translate('-- Select --') }}</option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('Select Banner Type')}} <span class="text-danger ml-1">*</span></label>
                                <select name="banner_type" id="banner_type" class="custom-select" required>
                                    <option disabled selected>{{ translate('-- Select --') }}</option>
                                    {{-- <option value="bottom_banner">{{ translate('Bottom Banner (1110*380 px)') }}</option> --}}
                                    <option value="top_right_banner">{{ translate('Banner') }}</option>
                                    {{-- <option value="top_right_banner">{{ translate('Top Right Banner (280*450 px)') }}</option>
                                    <option value="bottom_right_banner">{{ translate('Bottom Right Banner (280*350 px)') }}</option> --}}
                                    <option value="video">{{ translate('Video') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- ... Your existing code ... -->
                                <div class=" from_part_2 video_section d--none" id="video_section">
                                    <label class="input-label">{{translate('youtube Video URL')}}<span class="text-danger ml-1">*</span></label>
                                    <input type="text" name="video" class="form-control" placeholder="{{ translate('ex : https://youtu.be/0sus46BflpU') }}" id="url" oninput="validateUrl()">
                                    <span id="urlValidationMessage"></span>
                                </div>
                                <div class=" from_part_2 image_section d--none" id="image_section">
                                    <label class="input-label">{{translate('Image')}} <span class="text-danger ml-1">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg" class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                               onchange="previewImage(this)">
                                        <label class="custom-file-label" for="customFileEg">{{ translate('choose file') }}</label>
                                    </div>
                                    <div class="col-12 from_part_2 mt-2">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <img style="height:170px;border: 1px solid; border-radius: 10px;" id="imagePreview" src="{{ asset('public/assets/admin/img/400x400/img2.jpg') }}" alt="image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function previewImage(input) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    document.getElementById('imagePreview').src = e.target.result;
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        </script>
                        
                    </div>
                    <!-- Include jQuery library if not already included -->




                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                        <button type="submit" id="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="new-top px-card">
                <div class="row justify-content-between align-items-center gy-2">
                    <div class="col-sm-4 col-md-6 col-lg-8">
                        <h5 class="d-flex gap-2 mb-0">
                            {{translate('Promotion_Table')}}
                            <span class="badge badge-soft-dark rounded-50 fz-12">{{count($promotions)}}</span>
                        </h5>
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{url()->current()}}" method="GET">
                            <div class="input-group">
                                {{-- <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Type')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off"> --}}
                                <div class="input-group-append">
                                    {{-- <button type="submit" class="btn btn-primary">{{translate('Search')}}</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="set_table new-responsive">
                <div class="table-responsive datatable_wrapper_row "  style="padding-right: 10px;">
                    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('Branch')}}</th>
                            <th>{{translate('Banner type')}}</th>
                            <th>{{translate('Promotion_Banner')}}</th>
                            <th>{{translate('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($promotions as $k=>$promotion)
                            <tr>
                                {{-- <th scope="row" class="align-middle">{{$promotions->firstitem() + $k}}</th> --}}
                                <th scope="row" class="align-middle">{{$k+1}}</th>
                                <td>
                                    <a class="text-dark" href="{{route('admin.promotion.branch',[$promotion->branch_id])}}">{{$promotion->branch->name}}</a>
                                </td>
                                <td>
                                    {{-- @php
                                        $promotion_type = $promotion['promotion_type'];
                                        echo str_replace('_', ' ', $promotion_type);
                                    @endphp --}}

                                    {{ $promotion->promotion_type == 'top_right_banner' ? 'Banner' : 'Video' }}
                                  
                                </td>
                                <td>
                                    @if($promotion['promotion_type'] == 'video')
                                        <a href="{{$promotion['promotion_name']}}" target="_blank">{{$promotion['promotion_name']}}</a>
                                    @else
                                        <div>
                                            <img class="mx-80px" width="100" src="{{asset('storage/app/public/promotion')}}/{{$promotion['promotion_name']}}"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex  gap-3">
                                        <a href="{{route('admin.promotion.edit',[$promotion['id']])}}" class="btn btn-outline-info btn-sm square-btn"
                                        title="{{translate('Edit')}}">
                                            <i class="tio-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm square-btn" title="{{translate('Delete')}}"
                                        onclick="form_alert('promotion-{{$promotion['id']}}','{{translate('Want to delete this promotion ?')}}')">
                                            <i class="tio-delete"></i>
                                        </button>
                                    </div>
                                    <form action="{{route('admin.promotion.delete',[$promotion['id']])}}"
                                            method="post" id="promotion-{{$promotion['id']}}">
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
                        {{-- {{$promotions->links()}} --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@push('script_2')

    <script>
        // $(function() {
        //     $('#banner_type').change(function(){
        //         if ($(this).val() === 'video'){
        //             $('#video_section').show();
        //             $('#image_section').hide();
        //         }else{
        //             $('#video_section').hide();
        //             $('#image_section').show();
        //         }
        //     });
        // });

        
        $(function() {
            const customFile = $('#customFileEg');
            const bannerType = $('#banner_type');
            const submitButton = $('#submit');

            submitButton.prop('disabled', true);

            bannerType.change(function() {
                if ($(this).val() === 'video') {
                    $('#video_section').show();
                    $('#image_section').hide();
                    submitButton.prop('disabled', true);
                } else {
                    $('#video_section').hide();
                    $('#image_section').show();
                    checkSubmitButtonState(); 
                }
            });

            customFile.on('change', function() {
                checkSubmitButtonState(); 
            });

            function checkSubmitButtonState() {
                if (bannerType.val() !== 'video' && customFile.val().trim() === '') {
                    $('#submit').attr('disabled','disabled');
                } else {
                    $('#submit').removeAttr('disabled');
                }
            }

            $('#reset').on('click', function() {
              $('#submit').attr('disabled','disabled');
              });
        });

        function readURL(input, viewer_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+viewer_id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg").change(function () {
            readURL(this, 'viewer');
        });

    </script>
    <script>
        // function validateUrl() {
        //     var urlInput = document.getElementById('url');
        //     var validationMessage = document.getElementById('urlValidationMessage');
        //     var url = urlInput.value;

        //     // Regular expression for basic URL validation
        //     var urlRegex = /^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,6}(\/\S*)?$/i;

        //     if (urlRegex.test(url)) {
        //     validationMessage.textContent = '';
        //     validationMessage.style.color = 'green';
        //     } else {
        //     validationMessage.textContent = 'Invalid URL. Please enter a valid URL.';
        //     validationMessage.style.color = 'red';
        //     }
        // }

        
        function validateUrl() {
                var urlInput = document.getElementById('url');
                var validationMessage = document.getElementById('urlValidationMessage');
                var url = urlInput.value;
                var urlRegex = /^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,6}(\/\S*)?$/i;
                $('#submit').attr('disabled', 'disabled');

                if (url.trim() === '') {
                    validationMessage.textContent = '';
                    $('#submit').removeAttr('disabled');
                } else if (urlRegex.test(url)) {
                    validationMessage.textContent = '';
                    validationMessage.style.color = 'green';
                    $('#submit').removeAttr('disabled');
                } else {
                    validationMessage.textContent = 'Invalid URL. Please enter a valid URL.';
                    validationMessage.style.color = 'red';
                    $('#submit').attr('disabled', 'disabled');
                }
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
                paging:true,
                info:false,
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
