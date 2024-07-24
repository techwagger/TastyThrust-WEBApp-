@extends('layouts.admin.app')

@section('title', translate('Add New Chef'))

@push('css_or_js')

@endpush

@section('content')


<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/cooking.png')}}" alt="">
            <span class="page-header-title">
                {{translate('Add_New_Chef')}}
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.kitchen.add-new')}}" id="upload-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlSelect1">{{translate('Select Branch')}} <span class="text-danger">*</span></label>
                                    <select name="branch_id" class="custom-select" required>
                                        <option value="" selected disabled>{{ translate('--Select_Branch--') }}</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">{{translate('First Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="f_name" class="form-control" id="f_name"
                                           placeholder="{{translate('Ex')}} : {{translate('John')}}" value="{{old('f_name')}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name">{{translate('Last Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="l_name" class="form-control" id="l_name"
                                           placeholder="{{translate('Ex')}} : {{translate('Doe')}}" value="{{old('l_name')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="">
                        <div class="row">
                            <div class="col-md-6 mb-3 ">
                               <div class="content-row">
                                <div class="col-area-2">
                                <label for="name">{{translate('Code')}} <span class="text-danger">*</span></label>
                                    {{-- <input type="hidden" name="country_code" value="{{old('country_code')}}" class="form-control" id="country_code" 
                                           placeholder="{{translate('Ex')}} : +91" required> --}}
                                          
                                        <div  id="country-dropdown" class="form-control" style="z-index: 1;"></div>
                                        <input type="hidden"  id="hidden-country-code"    name="country_code">
                                        <input type="hidden"  id="hidden-country-code-string"  name="country_code_string">

                                            {{-- only for show store country code --}}
                                        <input type="hidden"  id="hidden-country-code-string-db" value="">
                                </div>
                                <div class="col-area-10">
                                <label for="name">{{translate('Phone')}} <span class="text-danger">*</span> </label>
                                    <input type="number" name="phone" value="{{old('phone')}}" class="form-control" id="phone1"
                                           placeholder="{{translate('Ex')}} : 88017********" required style="border-radius:0 .3125rem  .3125rem 0" onkeyup="validateMobileNumber(this)">
                               
                                </div>
                               </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name">{{translate('Email')}} <span class="text-danger">*</span></label>
                                    <input value="{{old('email')}}" type="email" id="email" onkeyup="validationemail()" name="email" class="form-control" placeholder="{{translate('Ex : ex@example.com')}}"
                                    required>
                                    <span id="textemail"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">{{translate('password')}} 
                                    <span class="text-danger">*</span> 
                                    <span class="badge badge-soft-danger" style="background:white;font-weight:400">{{translate('(minimum length will be 6 character)')}}</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" class="js-toggle-password form-control form-control input-field" id="password"
                                           placeholder="{{translate('Password')}}" required
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
                                <label for="confirm_password">{{translate('confirm_Password')}}<span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="confirm_password" class="js-toggle-password form-control form-control input-field" id="confirm_password"
                                           placeholder="{{translate('confirm password')}}" required
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
                       <br>
                        <div class="row">
                            {{-- <div class="col-md-6 mb-3">
                            </div>  --}}
                            <div class="col-md-12 mb-3">
                                <label for="name">{{translate('image')}} <span class="text-danger">*</span></label>
                                <span class="badge badge-soft-danger" style="background:white;font-weight:400">( {{translate('ratio')}} 1:1 )</span>
                                <div class="form-group">
                                    <div class="custom-file text-left">
                                        <input type="file" id="customFileUpload" class="custom-file-input" accept=".jpg, .png, .jpeg, , .tiff|image/*" required >
                                        <label class="custom-file-label" for="customFileUpload">{{translate('choose')}} {{translate('file')}}</label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <img class="upload-img-view" id="viewer" src="{{asset('public\assets\admin\img\400x400\img2.jpg')}}" alt="image"/>
                                    <input type="hidden" name="image" id="cropped-image">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                            <button type="submit" id="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/select2.min.js"></script>
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
        
        // function readURL(input) {
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function (e) {
        //             $('#viewer').attr('src', e.target.result);
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>
   <script>
    function isNumber(evt) {
      evt = evt || window.event;
      var charCode = evt.which || evt.keyCode;
      
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter only Numbers.");
        return false;
      }
  
      // Validate the length of the phone number
      var phoneNo = document.getElementById('phone');
      if (phoneNo.value.length < 7 || phoneNo.value.length > 15) {
        alert("Please enter a phone number between 7 and 15 digits.");
        return false;
      }
  
      return true;
    }
  
    var phoneInput = document.getElementById('phone');
    var myForm = document.forms.myForm;
    var result = document.getElementById('result');  // only for debugging purposes
  
    phoneInput.addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
  
    myForm.addEventListener('submit', function(e) {
      phoneInput.value = phoneInput.value.replace(/\D/g, '');
      result.innerText = phoneInput.value;  // only for debugging purposes
      
      // You may add additional validation here if needed
      
      // e.preventDefault(); // You might want to prevent the form submission based on your requirements
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

    document.getElementById('upload-form').addEventListener('submit', function (e) {
        if (!croppedImageInput.value) {
            e.preventDefault();
            alert('Please select and crop an image.');
        }
    });
  </script>
@endpush