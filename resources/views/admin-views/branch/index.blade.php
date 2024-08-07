@extends('layouts.admin.app')

@section('title', translate('Add New Branch'))

@push('css_or_js')
    <style>
        #pac-input:focus {
    border: 1px solid #fbc1c1;
    /* You can add additional styling here if needed */
}
        #location_map_div #pac-input{
            height: 40px;
            border: 1px solid #e7eaf3;
            outline: none;
            box-shadow: none;
            top: 7px !important;
            /* transform: translateX(5px); */
            /* padding-left: 10px; */
            /* margin:32px 0 10px 0; */
            width:100%;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/branch.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('Add_New_Branch')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.branch.store')}}" id="upload-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 d-flex gap-2 align-items-center">
                                <i class="tio-user"></i>
                                {{translate('Branch_Information')}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{translate('name')}}<span class="text-danger ml-1">*</span></label>
                                        <input value="{{old('name')}}" type="text" name="name" class="form-control" maxlength="255"
                                               placeholder="{{translate('New branch')}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="">{{translate('address')}}<span class="text-danger ml-1">*</span></label>
                                        <input value="{{old('address')}}" type="text" name="address" class="form-control" placeholder="{{ translate('Enter Address') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{translate('branch_Image')}}</label>
                                            <small class="text-danger">* ( {{translate('ratio 1:1')}} )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" id="customFileEg1" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img width="150" style="height:150px; oject-fit:cover;" class="img-fitarea" id="viewer" src="{{asset('public/assets/admin/img/icons/upload_img.png')}}" alt="">
                                                    <input type="hidden" name="image" id="cropped-image-1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('phone')}}<span class="text-danger ml-1">*</span></label>
                                        <input type="number" name="phone" class="form-control" placeholder="{{translate('Ex: (xxx)-xxx-xxxx')}}" required onkeyup="validateMobileNumber(this)">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('email')}}<span class="text-danger ml-1">*</span></label>
                                        <input value="{{old('email')}}" type="email" name="email" id="email" class="form-control" maxlength="255"
                                               placeholder="{{translate('EX : example@example.com')}}" onkeyup="validationemail()" required>
                                               <span id="textemail"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('password')}}<span class="text-danger ml-1">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" class="js-toggle-password form-control form-control input-field" id="password" required
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
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <label class="mb-0">{{translate('branch_cover_image')}}</label>
                                            <small class="text-danger">* ( {{translate('ratio 3:1')}} )</small>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <div class="upload-file">
                                                <input type="file" id="customFileEg2" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img width="150" class="ratio-3-to-1" id="viewer2" src="{{asset('public/assets/admin/img/icons/upload_img2.png')}}" alt="">
                                                    <input type="hidden" name="cover_image" id="cropped-image-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="mb-0 d-flex gap-2 align-items-center">
                                <i class="tio-map"></i>
                                {{translate('branch_Location')}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="form-label text-capitalize"
                                                       for="latitude">{{ translate('latitude') }}
                                                        <i class="tio-info-outined"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="{{ translate('Click on the map select your default location.') }}"></i><span
                                                        class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('click_on_the_map_select_your_default_location') }}"></span></label>
                                                <input type="number" step="any" id="latitude" name="latitude" class="form-control"
                                                       placeholder="{{ translate('Ex:') }} 23.8118428"
                                                       value="{{ old('latitude') }}" required >
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="form-label text-capitalize"
                                                       for="longitude">
                                                        {{ translate('longitude') }}
                                                        <i class="tio-info-outined"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="{{ translate('Click on the map select your default location.') }}"></i>
                                                       <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('click_on_the_map_select_your_default_location') }}">
                                                       </span>
                                                </label>
                                                <input type="number" step="any" name="longitude" class="form-control"
                                                       placeholder="{{ translate('Ex:') }} 90.356331" id="longitude"
                                                       value="{{ old('longitude') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label">
                                                    {{translate('coverage (km)')}}
                                                    <i class="tio-info-outined"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="{{ translate('This value is the radius from your restaurant location, and customer can order food inside  the circle calculated by this radius.') }}"></i>
                                                </label>
                                                <input type="number" name="coverage" min="1" max="1000" class="form-control" placeholder="{{ translate('Ex : 3') }}" value="{{ old('coverage') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6" id="location_map_div">
                                    <input id="pac-input" class="controls rounded" data-toggle="tooltip"
                                           data-placement="right"
                                           data-original-title="{{ translate('search_your_location_here') }}"
                                           type="text" placeholder="{{ translate('search_here') }}" />
                                    <div id="location_map_canvas" class="overflow-hidden rounded" style="height: 200px"></div>
                                </div>

                            </div>



                            <div class="btn--container mt-4">
                                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                <button type="submit" id="submit" class="btn btn-primary">{{translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection

@push('script_2')

    <script src="https://maps.googleapis.com/maps/api/js?key={{ \App\Model\BusinessSetting::where('key', 'map_api_client_key')->first()?->value }}&libraries=places&v=3.51"></script>
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



        // function readURL(input) {
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function (e) {
        //             $('#viewer').attr('src', e.target.result);
        //             $('#viewer_2').attr('src', e.target.result);
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }

        $("#customFileEg1").change(function () {
            readURL(this);
        });


        $( document ).ready(function() {
            function initAutocomplete() {
                var myLatLng = {

                    lat: 23.811842872190343,
                    lng: 90.356331
                };
                const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                    center: {
                        lat: 23.811842872190343,
                        lng: 90.356331
                    },
                    zoom: 13,
                    mapTypeId: "roadmap",
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                });

                marker.setMap(map);
                var geocoder = geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                    var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                    var coordinates = JSON.parse(coordinates);
                    var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                    marker.setPosition(latlng);
                    map.panTo(latlng);

                    document.getElementById('latitude').value = coordinates['lat'];
                    document.getElementById('longitude').value = coordinates['lng'];


                    geocoder.geocode({
                        'latLng': latlng
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                document.getElementById('address').innerHtml = results[1].formatted_address;
                            }
                        }
                    });
                });
                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];
                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var mrkr = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
                        google.maps.event.addListener(mrkr, "click", function(event) {
                            document.getElementById('latitude').value = this.position.lat();
                            document.getElementById('longitude').value = this.position.lng();
                        });

                        markers.push(mrkr);

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            };
            initAutocomplete();
        });


        $('.__right-eye').on('click', function(){
            if($(this).hasClass('active')) {
                $(this).removeClass('active')
                $(this).find('i').removeClass('tio-invisible')
                $(this).find('i').addClass('tio-hidden-outlined')
                $(this).siblings('input').attr('type', 'password')
            }else {
                $(this).addClass('active')
                $(this).siblings('input').attr('type', 'text')


                $(this).find('i').addClass('tio-invisible')
                $(this).find('i').removeClass('tio-hidden-outlined')
            }
        })
    </script>
 <script>
    function isNumber(evt) {
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
alert("Please enter only Numbers.");
return false;
}
if (phoneNo.value.length < 10 || phoneNo.value.length > 10) {
alert("Please enter 10 Digit only Numbers.");
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

e.preventDefault(); // You wouldn't prevent it
});

    </script>

<script>
    let cropper;
    const imageInput = document.getElementById('customFileEg1');
    const image = document.getElementById('viewer');
    const croppedImageInput = document.getElementById('cropped-image-1');
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

<script>
    let cropper2;
    const imageInput2 = document.getElementById('customFileEg2');
    const image2 = document.getElementById('viewer2');
    const croppedImageInput2 = document.getElementById('cropped-image-2');
    const preview2 = document.querySelector('.preview');

    imageInput2.addEventListener('change', (e) => {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const url = URL.createObjectURL(file);
            image2.src = url;
            image2.style.display = 'block';

            if (cropper2) {
                cropper2.destroy();
            }

            cropper2 = new Cropper(image2, {
                aspectRatio: 3/1,
                viewMode: 1,
                preview: preview2,
                crop(event) {
                    const canvas = cropper2.getCroppedCanvas({
                        width: 160,
                        height: 160,
                    });
                    croppedImageInput2.value = canvas.toDataURL('image/jpeg');
                },
            });
        }
    });
    document.getElementById('upload-form').addEventListener('submit', function (e) {
        if (!croppedImageInput2.value) {
            e.preventDefault();
            alert('Please select and crop an image.');
        }
    });
</script>
@endpush
