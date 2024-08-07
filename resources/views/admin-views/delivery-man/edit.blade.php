@extends('layouts.admin.app')

@section('title', translate('Update delivery-man'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/deliveryman.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('update_Delivery_partner')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.delivery-man.update',[$delivery_man['id']])}}" id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center gap-2 mb-0">
                                <i class="tio-user"></i>
                                {{translate('general_Information')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('first_Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$delivery_man['f_name']}}" name="f_name" class="form-control" placeholder="New delivery-man" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('last_Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$delivery_man['l_name']}}" name="l_name" class="form-control" placeholder="Last Name" required>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Type')}} <span class="text-danger">*</span></label>
                                        <select name="identity_type" class="form-control">
                                            <option value="passport" {{$delivery_man['identity_type']=='passport'?'selected':''}}>
                                                {{translate('passport')}}
                                            </option>
                                            <option value="driving_license" {{$delivery_man['identity_type']=='driving_license'?'selected':''}}>
                                                {{translate('driving')}} {{translate('license')}}
                                            </option>
                                            <option value="nid" {{$delivery_man['identity_type']=='nid'?'selected':''}}>{{translate('nid')}}
                                            </option>
                                            <option value="restaurant_id" {{$delivery_man['identity_type']=='restaurant_id'?'selected':''}}>
                                                {{translate('restaurant_Id')}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="identity_number" value="{{$delivery_man['identity_number']}}" class="form-control" placeholder="Ex : DH-23434-LS" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Image')}}</label>
                                        <div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="input-label">{{translate('phone')}} <span class="text-danger">*</span></label>
                                        <input type="number" onkeyup="validateMobileNumber(this)" name="phone" value="{{$delivery_man['phone']}}" class="form-control" placeholder="Ex : 017********" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('branch')}} <span class="text-danger">*</span></label>
                                        <select name="branch_id" class="form-control">
                                            <option value="0" {{$delivery_man['branch_id']==0?'selected':''}}>{{translate('all')}}</option>
                                            @foreach(\App\Model\Branch::all() as $branch)
                                                <option value="{{$branch['id']}}" {{$delivery_man['branch_id']==$branch['id']?'selected':''}}>{{$branch['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{translate('Delivery_partner_Image')}}</label>
                                        <small class="text-danger">* ( {{translate('ratio')}} 1:1 )</small>
                                        <div class="custom-file">
                                            <input type="file" id="customFileEg1" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileEg1">{{translate('choose_File')}}</label>
                                        </div>
                                        <center class="mt-3">
                                            <img class="upload-img-view" id="viewer" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                src="{{asset('storage/app/public/delivery-man').'/'.$delivery_man['image']}}" alt="delivery-man image"/>
                                                <input type="hidden" name="image" id="cropped-image">
                                        </center>
                                       
                                    </div>

                                   
                                </div>
                                @foreach(json_decode($delivery_man['identity_image'],true) as $img)
                                <div class="col-sm-2">
                                    <img height="150" onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" src="{{asset('storage/app/public/delivery-man').'/'.$img}}">
                               </div>
                               @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center gap-2 mb-0">
                                <i class="tio-user"></i>
                                {{translate('Account_Information')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('email')}} <span class="text-danger">*</span></label>
                                        <input type="email" id="email" onkeyup="validationemail()" value="{{$delivery_man['email']}}" name="email" class="form-control" placeholder="Ex : ex@example.com" required>
                                        <span id="textemail"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('password')}}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" class="js-toggle-password form-control form-control input-field" id="password"
                                                   placeholder="{{translate('Ex: 8+ Characters')}}"
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
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="confirm_password">{{translate('confirm_Password')}}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="confirm_password" class="js-toggle-password form-control form-control input-field"
                                                   id="confirm_password" placeholder="{{translate('confirm password')}}"
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
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3 gap-3">
                        <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                        <button type="submit" id="submit" class="btn btn-primary">{{translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')

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

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>

    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '230px',
                groupClassName: 'col-6 col-lg-4 ',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/admin/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        let cropper;
        const imageInput = document.getElementById('customFileEg1');
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
