@extends('layouts.admin.app')

@section('title', translate('Update Notification'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <i class="tio-notifications"></i>
                <span class="page-header-title">
                    {{translate('notification_Update')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.notification.update',[$notification['id']])}}" id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('title')}} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$notification['title']}}" name="title" class="form-control" placeholder="{{translate('New notification')}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('description')}} <span class="text-danger">*</span></label>
                                        <textarea name="description" class="form-control" required>{{$notification['description']}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{translate('image')}}</label>
                                            <small class="text-danger">* ( {{translate('ratio')}} 3:1 )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input" id="customFileUpload">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img class="ratio-3-to-1" onerror="this.src='{{asset('public/assets/admin/img/icons/upload_img2.png')}}'"
                                                    src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}" alt="" id="viewer" style="width: auto; height: 140px; object-fit: contain; max-height: unset">
                                                    <input type="hidden" name="image" id="cropped-image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
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
    
        // document.getElementById('upload-form').addEventListener('submit', function (e) {
        //     if (!croppedImageInput.value) {
        //         e.preventDefault();
        //         alert('Please select and crop an image.');
        //     }
        // });
    </script>
@endpush
