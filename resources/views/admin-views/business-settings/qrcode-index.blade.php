@extends('layouts.admin.app')

@section('title', translate('Business Settings'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/business_setup2.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('business_setup')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <!-- Inine Page Menu -->
        @include('admin-views.business-settings.partials._business-setup-inline-menu')

        <section class="qr-code-section">
            <div class="card">
                <div class="card-body">
                    <div class="qr-area">
                        <div class="left-side pr-xl-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="text-dark w-0 flex-grow-1">{{ translate('QR Card Design') }}</div>
                                <div class="btn--container flex-nowrap print-btn-grp">
                                {{-- <a href="{{ route('admin.business-settings.restaurant.qrcode.download-pdf') }}" class="btn btn-secondary pt-1"><i class="tio-file-text-outlined"></i> {{translate('Save PDF')}}</a>--}}
                                    <a type="button" href="{{ route('admin.business-settings.restaurant.qrcode.print') }}" class="btn btn-primary pt-1"><i class="tio-print"></i> {{translate('Print')}}</a>
                                </div>
                            </div>
                            {{-- @php($restaurant_logo = \App\Models\EmailTemplate::get()[0]->logo) --}}
                            @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                            <div class="qr-wrapper" style="background: url({{asset('public/assets/admin/img/qr-bg.png')}}) no-repeat center center / 100% 100%">
                                <a href="" class="qr-logo">
                                    <img class="mb-2" onerror="this.src='{{ asset('storage/app/public/restaurant/' . $restaurant_logo) }}'"
                                    src="{{ asset('storage/app/public/restaurant/') }}/{{ $data['logo']??'' }}" id="logoViewer" alt="">

                                </a>
                                <a class="view-menu" href="">
                                    {{ isset($data) ? $data['title'] : translate('title') }}
                                </a>
                                <div class="text-center mt-4">
                                    <div>
                                        <img src="{{asset('public/assets/admin/img/scan-me.png')}}" class="mw-100" alt="">
                                    </div>
                                    <div class="my-3">
                                        {!! $code !!}
                                        {{-- <img src="{{asset('public/assets/admin/img/qr-code.png')}}" class="mw-100" alt="">--}}
                                    </div>
                                </div>
                                <div class="subtext">
                                    <span>
                                        {{ isset($data) ? $data['description'] : translate('description') }}
                                    </span>
                                </div>
                                {{-- <div class="open-time">
                                    <div>{{ translate('OPEN DAILY') }}</div>
                                    <div>{{ isset($data) ? $data['opening_time'] : '09:00 AM' }} - {{ isset($data) ? $data['closing_time'] : '09:00 PM' }}</div>
                                </div> --}}
                                <div class="phone-number">
                                    {{ translate('PHONE NUMBER') }} : {{ isset($data) ? $data['phone'] : '+00 123 4567890' }}
                                </div>
                                <div class="row g-0 text-center bottom-txt">
                                    <div class="col-6 border-right py-3 px-2">
                                        {{ isset($data) ? $data['website'] : 'www.website.com' }}
                                    </div>
                                    <div class="col-6 py-3">
                                        {{ isset($data) ? $data['social_media'] : translate('@social-media-name') }}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-side">
                            <form method="post" action="{{ route('admin.business-settings.restaurant.qrcode.store') }}" id="upload-form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label class="input-label">{{translate('QR Code Content')}}</label>--}}
{{--                                            <div class="">--}}
{{--                                                <!-- Custom Radio -->--}}
{{--                                                <div class="form-control d-flex flex-column-2">--}}
{{--                                                    <label class="custom-radio d-flex gap-2 align-items-center m-0">--}}
{{--                                                        <input type="radio" class="" name="include_branch" onclick="section_visibility('include_branch')" checked>--}}
{{--                                                        <span class="media align-items-center mb-0">--}}
{{--                                                            <span class="media-body">--}}
{{--                                                                {{translate('Include Branch')}}--}}
{{--                                                            </span>--}}
{{--                                                    </span>--}}
{{--                                                    </label>--}}

{{--                                                    <label class="custom-radio d-flex gap-2 align-items-center m-0">--}}
{{--                                                        <input type="radio" class="" name="include_branch" onclick="section_visibility('general_qr_code')">--}}
{{--                                                        <span class="media align-items-center mb-0">--}}
{{--                                                            <span class="media-body">--}}
{{--                                                                {{translate('General QR Code')}}--}}
{{--                                                            </span>--}}
{{--                                                    </span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                                <!-- End Custom Radio -->--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-12" id="branch_section">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Branch')}} <span class="text-danger">*</span></label>
                                            <select class="form-control js-select2-custom" name="branch_id">
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch['id'] }}">{{ $branch['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Logo / Icon')}}</label>
                                            <label class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input"
                                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <span class="custom-file-label">{{translate('choose_File')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Title')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="title" placeholder="{{ translate('Ex : Title') }}" class="form-control" value="{{old('title')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Description')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="description" placeholder="{{ translate('Ex : Description') }}" value="{{old('description')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Opening Time')}} <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" name="opening_time" value="{{old('opening_time')}}" required>
                                            {{-- <i class="tio-time-1"></i> --}}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Closing Time')}} <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" name="closing_time" value="{{old('closing_time')}}" required>
                                            {{-- <i class="tio-time-1"></i> --}}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Phone')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" id="phone" onkeydown="validationPhone()" onkeyup="validateMobileNumber(this)" placeholder="{{ translate('Ex : +123456') }}" value="{{old('phone')}}" class="form-control" required>
                                            <span id="textphone"></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Website Link')}} <span class="text-danger">*</span></label>
                                            <input type="url" id="url" oninput="validateUrl()" name="website" value="{{old('website')}}" placeholder="{{ translate('Ex : www.website.com') }}" class="form-control" required>
                                            <span id="urlValidationMessage"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-label">{{translate('Social Media Name')}} <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="{{ translate('@social media name')  }}" name="social_media" value="{{old('social_media')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="btn--container">
                                            <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                            <button type="submit" id="submit" class="btn btn-primary">{{translate('submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script_2')
    <script>

        function validationPhone() {
            let form = document.getElementById('upload-form')
            let phone = document.getElementById('phone').value
            let text = document.getElementById('textphone')
            let pattern =/^\d{6,15}$/

            if (phone.match(pattern)) {
                form.classList.add('valid')
                form.classList.remove('invalid')
                text.innerHTML = ""
                text.style.color = '#00ff00'
                $('#submit').removeAttr('disabled');
            } else {
                form.classList.remove('valid')
                form.classList.add('invalid')
                text.innerHTML = "Please Enter Valid Phone Number should be more than 7 & less than 15."
                text.style.color = '#ff0000'
                $('#submit').attr('disabled','disabled');
            }

            if (phone == '') {
                form.classList.remove('valid')
                form.classList.remove('invalid')
                text.innerHTML = ""
                text.style.color = '#00ff00'
                $('#submit').removeAttr('disabled','disabled');

            }
        }


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

{{--    <script>--}}
{{--        function section_visibility(id) {--}}
{{--            if (id == 'include_branch') {--}}
{{--                $('#branch_section').show()--}}
{{--            } else {--}}
{{--                $('#branch_section').hide()--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
<script>
//     function isNumber(evt) {
// evt = (evt) ? evt : window.event;
// var charCode = (evt.which) ? evt.which : evt.keyCode;
// if (charCode > 31 && (charCode < 48 || charCode > 57)) {
// alert("Please enter only Numbers.");
// return false;
// }
// if (phoneNo.value.length < 10 || phoneNo.value.length > 10) {
// alert("Please enter 10 Digit only Numbers.");
// return false;
// }

// return true;
// }

// var phoneInput = document.getElementById('phone');
// var myForm = document.forms.myForm;
// var result = document.getElementById('result');  // only for debugging purposes

// phoneInput.addEventListener('input', function (e) {
// var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
// e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
// });

// myForm.addEventListener('submit', function(e) {
// phoneInput.value = phoneInput.value.replace(/\D/g, '');
// result.innerText = phoneInput.value;  // only for debugging purposes

// e.preventDefault(); // You wouldn't prevent it
// });

    </script>
@endpush

