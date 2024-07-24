@extends('layouts.admin.app')

@section('title', translate('Chef Edit'))

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/cooking.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Chef_Update')}}
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.kitchen.update',[$chef['id']])}}" id="upload-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-label">{{translate('Select Branch')}} <span class="text-danger">*</span></label>
                                    <select name="branch_id" class="custom-select" required>
                                        <option disabled selected>{{ translate('--select_Branch--') }}</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch['id']}}" {{ $branch->id == ($chef_branch->branch_id?? 0) ? 'selected' : '' }}>{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="f_name">
                                    {{translate('First_Name')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="f_name" value="{{$chef['f_name']}}" class="form-control" id="f_name" placeholder="{{translate('Ex')}} : {{translate('John')}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="l_name">
                                    {{translate('Last_Name')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="l_name" value="{{$chef['l_name']}}" class="form-control" id="l_name" placeholder="{{translate('Ex')}} : {{translate('Doe')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 ">
                              <div class="content-row">
                                <div class="col-area-2">
                                    <label for="name">{{translate('Code')}} <span class="text-danger">*</span></label>
                                    {{-- <input type="hidden" name="country_code" value="{{old('country_code')}}" class="form-control" id="country_code" 
                                           placeholder="{{translate('Ex')}} : +91" required> --}}
                                          
                                    <div  id="country-dropdown" class="form-control" style="z-index: 1;"></div>
                                    <input type="hidden" id="hidden-country-code" name="country_code">
                                    <input type="hidden"  id="hidden-country-code-string"  name="country_code_string">

                                        {{-- only for show store country code --}}
                                    <input type="hidden"  id="hidden-country-code-string-db" value="{{ $chef['country_code_string'] }}">
                                       
                                </div>
                                <div class="col-area-10">
                                    <label for="name">{{translate('Phone')}} <span class="text-danger">*</span> </label>
                                    <input type="number" name="phone" value="{{ $chef['phone'] }}" class="form-control" id="phone" placeholder="{{translate('Ex')}} : 88017********" required style="border-radius:0 .3125rem .3125rem 0" oninput="validatePhone()" onkeyup="validateMobileNumber(this)">
                                </div>
                              </div>
                            </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name">{{translate('Email')}} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{$chef['email']}}" class="form-control" id="email" onkeyup="validationemail()"
                                           placeholder="{{translate('Ex')}} : ex@gmail.com" required>
                                    <span id="textemail"></span>
                                </div>
                            </div>
                        

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">{{translate('Password')}}</label><small class="badge badge-soft-danger" style="background:white;font-weight:400"> ( {{translate('input if you want to change')}} )</small>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" class="js-toggle-password form-control form-control input-field" id="password"
                                           placeholder="{{translate('Password')}}"
                                           data-hs-toggle-password-options='{
                                        "target": "#changePassTarget",
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": "#changePassIcon"
                                        }'>
                                    <div id="changePassTarget" class="input-group-append">
                                        <a class="input-group-text" href="javascript:">
                                            <i id="changePassIcon" class="tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password">{{translate('confirm_Password')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="confirm_password" class="js-toggle-password form-control form-control input-field" id="confirm_password"
                                           placeholder="{{translate('confirm password')}}"
                                           data-hs-toggle-password-options='{
                                        "target": "#changeConPassTarget",
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": "#changeConPassIcon"
                                        }'>
                                    <div id="changeConPassTarget" class="input-group-append">
                                        <a class="input-group-text" href="javascript:">
                                            <i id="changeConPassIcon" class="tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">{{translate('image')}} </label>
                                    <span class="badge badge-soft-danger" style="background:white;font-weight:400">( {{translate('ratio')}} 1:1 )</span>
                                    <div class="custom-file text-left">
                                        <input type="file" id="customFileUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload">{{translate('choose')}} {{translate('file')}}</label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <img class="upload-img-view" id="viewer" onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'" src="{{asset('storage/app/public/kitchen')}}/{{$chef['image']}}" alt="image"/>
                                    <input type="hidden" name="image" id="cropped-image">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                            <button type="submit" id="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')

<script src="{{ asset('public/assets/admin/js/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
    function validationemail() {
        let form = document.getElementById('upload-form')
        let email = document.getElementById('email').value
        let text = document.getElementById('textemail')
        let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/

        if (email.match(pattern)) {
            form.classList.add('valid')
            form.classList.remove('invalid')
            text.innerHTML = ""
            text.style.color = '#00ff00'
            $('#submit').removeAttr('disabled');
        } else {
            form.classList.remove('valid')
            form.classList.add('invalid')
            text.innerHTML = "Please Enter Valid Email Address"
            text.style.color = '#ff0000'
            $('#submit').attr('disabled','disabled');
        }

        if (email == '') {
            form.classList.remove('valid')
            form.classList.remove('invalid')
            text.innerHTML = ""
            text.style.color = '#00ff00'
            $('#submit').removeAttr('disabled','disabled');

        }
    }
</script>
<script>
    $(document).ready(function () {
        // Select2 initialization
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

        // Image preview
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
        });

        // Mobile Number Masking
        var phoneInput = document.getElementById('phone');
        var existingPhoneNumber = "{{$chef['phone']}}"; // Get the existing phone number from the server
        phoneInput.value = formatPhoneNumber(existingPhoneNumber);

        phoneInput.addEventListener('input', function (e) {
            e.target.value = formatPhoneNumber(e.target.value);
        });

        function formatPhoneNumber(phoneNumber) {
            return phoneNumber.replace(/\D/g, '').replace(/(\d{0,3})(\d{0,3})(\d{0,4})/, function (_, p1, p2, p3) {
                return !p2 ? p1 : '(' + p1 + ') ' + p2 + (p3 ? '-' + p3 : '');
            });
        }
    });
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
                aspectRatio: 1,
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

    // document.getElementById('upload-form').addEventListener('submit', function (e) {
    //     if (!croppedImageInput.value) {
    //         e.preventDefault();
    //         alert('Please select and crop an image.');
    //     }
    // });
</script>
@endpush
