@extends('layouts.branch.app')

@section('title', translate('Promotional campaign'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/promotion.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('promotion_Setup')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('branch.promotion.store')}}" method="post" enctype="multipart/form-data" class="mb-0">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('Select_Banner_Type')}} <span class="text-danger">*</span></label>
                                        <select name="banner_type" id="banner_type" class="form-control js-select2-custom" required>
                                            <option value="" selected>{{ translate('--Select--') }}</option>
                                            <option value="bottom_banner">{{ translate('Bottom Banner (1110*380 px)') }}</option>
                                            <option value="top_right_banner">{{ translate('Top Right Banner (280*450 px)') }}</option>
                                            <option value="bottom_right_banner">{{ translate('Bottom Right Banner (280*350 px)') }}</option>
                                            <option value="video">{{ translate('Video') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-12 from_part_2 image_section" id="image_section" style="display: none">
                                            <label class="input-label">{{translate('Image')}} <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                                <label class="custom-file-label" for="customFileUpload">{{ translate('choose file') }}</label>
                                            </div>
                                            <div class="col-12 from_part_2 mt-2">
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <img style="height:170px;border: 1px solid; border-radius: 10px;" id="viewer"
                                                            src="{{ asset('public/assets/admin/img/400x400/img2.jpg') }}" alt="image" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 from_part_2 video_section" id="video_section" style="display: none">
                                            <label class="input-label">{{translate('youtube_Video_URL')}} <span class="text-danger">*</span></label>
                                            <input type="text" id="url" name="video" class="form-control" placeholder="{{ translate('ex : https://youtu.be/0sus46BflpU') }}" oninput="validateUrl()">
                                            <span id="urlValidationMessage"></span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mt-3">
            <div class="new-top px-card">
                <div class="row justify-content-between align-items-center gy-2">
                    <div class="col-md-4">
                        <h5 class="d-flex align-items-center gap-2 mb-0">
                            {{translate('Promotional_Campaign_Table')}}
                            <span class="badge badge-soft-dark rounded-50 fz-12">{{$promotions->total()}}</span>
                        </h5>
                    </div>
                  
                    {{-- <div class="col-md-8">
                        <form action="{{url()->current()}}" method="GET">
                            <div class="input-group">
                                <!-- <input id="datatableSearch_" type="search" name="search"
                                        class="form-control"
                                        placeholder="{{translate('Search')}}" aria-label="Search"
                                        value="{{$search}}" required autocomplete="off"> -->
                                <div class="input-group-append">
                                    <!-- <button type="submit" class="btn btn-primary">
                                        {{translate('Search')}}
                                    </button> -->
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>

            <div class="set_table responsive-ui branch-pos-order table-view">
                <div class="table-responsive datatable_wrapper_row" style="padding:0 10px">
                    <table id="datatable" class=" table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" >
                        <thead class="thead-light">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('Branch')}}</th>
                                <th>{{translate('Promotion type')}}</th>
                                <th>{{translate('Promotion Banner')}}</th>
                                <th>{{translate('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($promotions as $k=>$promotion)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$promotion->branch->name}}</td>
                                <td>
                                    @php
                                        $promotion_type = $promotion['promotion_type'];
                                        echo str_replace('_', ' ', $promotion_type);
                                    @endphp
                                </td>
                                <td>
                                    @if($promotion['promotion_type'] == 'video')
                                        {{$promotion['promotion_name']}}
                                    @else
                                        <div width="50">
                                            <img class="mx-80px" width="100" src="{{asset('storage/app/public/promotion')}}/{{$promotion['promotion_name']}}"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex  gap-2">
                                        <a href="{{route('branch.promotion.edit',[$promotion['id']])}}"
                                            class="btn btn-outline-info btn-sm edit square-btn"
                                            title="{{translate('Edit')}}">
                                            <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm edit square-btn" title="{{translate('Delete')}}" href="javascript:"
                                            onclick="form_alert('promotion-{{$promotion['id']}}','{{translate('Want to delete this promotion ?')}}')">
                                            <i class="tio-delete"></i>
                                        </a>
                                    </div>
                                    <form action="{{route('branch.promotion.delete',[$promotion['id']])}}"
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
                        {{$promotions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
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

        $("#customFileUpload").change(function () {
            readURL(this);
        })


        $(function() {
            $('#banner_type').change(function(){
               
                if ($(this).val() === 'video'){
                    $('#video_section').show();
                    $('#image_section').hide();
                }else{
                    $('#video_section').hide();
                    $('#image_section').show();
                }
            });
        });

        function validateUrl() {
            var urlInput = document.getElementById('url');
            var validationMessage = document.getElementById('urlValidationMessage');
            var url = urlInput.value;

            // Regular expression for basic URL validation
            var urlRegex = /^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,6}(\/\S*)?$/i;

            if (urlRegex.test(url)) {
            validationMessage.textContent = '';
            validationMessage.style.color = 'green';
            } else {
            validationMessage.textContent = 'Invalid URL. Please enter a valid URL.';
            validationMessage.style.color = 'red';
            }
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
                paging:false,
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

