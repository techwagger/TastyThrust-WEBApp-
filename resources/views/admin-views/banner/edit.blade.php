@extends('layouts.admin.app')

@section('title', translate('Update banner'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img " src="{{asset('public/assets/admin/img/icons/banner.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Update_Banner')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->


        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.banner.update',[$banner['id']])}}" id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf @method('put')

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('title')}}<span class="text-danger ml-1">*</span></label>
                                        <input type="text" name="title" value="{{$banner['title']}}" class="form-control"
                                            placeholder="{{translate('New banner')}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label">{{translate('item_Type')}}<span class="text-danger ml-1">*</span></label>
                                        <select name="item_type" class="custom-select" onchange="show_item(this.value)">
                                            <option value="product" {{$banner['product_id']==null?'':'selected'}}>{{translate('product')}}</option>
                                            <option value="category" {{$banner['category_id']==null?'':'selected'}}>{{translate('category')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="type-product" style="display: {{$banner['product_id']==null?'none':'block'}}">
                                        <label class="input-label">{{translate('product')}} <span class="text-danger ml-1">*</span></label>
                                        <select name="product_id" class="custom-select">
                                            @foreach($products as $product)
                                                <option value="{{$product['id']}}" {{$banner['product_id']==$product['id']?'selected':''}}>{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="type-category" style="display: {{$banner['category_id']==null?'none':'block'}}">
                                        <label class="input-label">{{translate('category')}} <span class="text-danger ml-1">*</span></label>
                                        <select name="category_id" class="form-control js-select2-custom">
                                            @foreach($categories as $category)
                                                <option value="{{$category['id']}}" {{$banner['category_id']==$category['id']?'selected':''}}>{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{translate('banner_Image')}}</label>
                                            <small class="text-danger">* ( {{translate('ratio 3:1')}} )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" id="customFileUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img width="465" class="ratio-3-to-1" src="{{asset('storage/app/public/banner')}}/{{$banner['image']}}" onerror="this.src='{{asset('public/assets/admin/img/icons/upload_img2.png')}}'" alt="" id="viewer">
                                                    <input type="hidden" name="image" id="cropped-image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn-primary">{{translate('update')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
