@extends('layouts.admin.app')

@section('title', translate('Main Branch Setup'))

@push('css_or_js')
    <style>
    #location_map_div {
    position: relative;
}

#pac-input:focus {
    border: 1px solid #fbc1c1;
    /* You can add additional styling here if needed */
}

#location_map_canvas {
    width: 100%;
    height: 300px; /* Adjust the height as needed */
    position: relative;
    z-index: 1; /* Set a lower z-index for the map */
}

    </style>
@endpush

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

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.branch.update', ['id' => $branch['id']])}}" id="upload-form" method="post" enctype="multipart/form-data">
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
                                               for="exampleFormControlInput1">{{translate('name')}}</label>
                                        <input value="{{$branch['name']}}" type="text" name="name" class="form-control" maxlength="255"
                                               placeholder="{{translate('New branch')}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="">{{translate('address')}}</label>
                                        <input value="{{$branch['address']}}" type="text" name="address" class="form-control" placeholder="" required>
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
                                                <input type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="upload-file__input" id="customFileUpload">
                                                <div class="upload-file__img_drag upload-file__img">
                                                    <img width="150" id="viewer" class="ratio-1-to-1"
                                                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img3.jpg')}}'"
                                                         src="{{asset('storage/app/public/branch')}}/{{$branch['image']}}" alt="">
                                                    <input type="hidden" name="image" id="cropped-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('phone')}}</label>
                                        <input value="{{$branch['phone']}}" type="number" name="phone" class="form-control"
                                               placeholder="{{translate('Ex: +098538534')}}" required  id="phone" onkeydown="validationPhone()" onkeyup="validateMobileNumber(this)">
                                        <span id="textphone"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('email')}}</label>
                                        <input value="{{$branch['email']}}" type="email" name="email" id="email" onkeyup="validationemail()" class="form-control" maxlength="255"
                                               placeholder="{{translate('EX : example@example.com')}}" required>
                                        <span id="textemail"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('password')}} <small class="text-danger"> * {{translate('(input_if_you_want_to_reset)') }}</small></label>
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
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="mb-0 d-flex gap-2 align-items-center">
                                <i class="tio-map"></i>
                                {{translate('Store_Location ')}}
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
                                                       title="{{ translate('Click on the map select your default location.') }}">
                                                    </i>
                                                </label>
                                                <input type="text" id="latitude" name="latitude" class="form-control"
                                                       placeholder="{{ translate('Ex:') }} 23.8118428"
                                                       value="{{ $branch['latitude'] }}" readonly required >
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="form-label text-capitalize"
                                                       for="longitude">{{ translate('longitude') }}
                                                    <i class="tio-info-outined"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="{{ translate('Click on the map select your default location.') }}">
                                                    </i>
                                                </label>
                                                <input type="text" name="longitude" class="form-control"
                                                       placeholder="{{ translate('Ex:') }} 90.356331" id="longitude"
                                                       value="{{ $branch['longitude'] }}" readonly  required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label">
                                                    {{translate('coverage (km)')}}
                                                    <i class="tio-info-outined"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="{{ translate('This value is the radius from your restaurant location, and customer can order food inside  the circle calculated by this radius.') }}">
                                                    </i>

                                                </label>
                                                <input type="number" name="coverage" min="1" max="1000" class="form-control" placeholder="{{ translate('Ex : 3') }}" value="{{ $branch['coverage'] }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="location_map_div">
                                    <label for="pac-input" class="sr-only">Search Location</label>
                                    <input id="pac-input"  class="form-control" 
                                           data-toggle="tooltip"
                                           data-placement="right"
                                           data-original-title="{{ translate('search_your_location_here') }}"
                                           type="text" 
                                           placeholder="{{ translate('search_here') }}" 
                                           style="margin-bottom: 20px;" />
                                           
                                    <div id="location_map_canvas" class="map-container rounded">
                                        <!-- Your map rendering code goes here -->
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-5">
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

    <script src="https://maps.googleapis.com/maps/api/js?key={{ \App\Model\BusinessSetting::where('key', 'map_api_client_key')->first()?->value }}&libraries=places&v=3.45.8"></script>

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


        $( document ).ready(function() {
            function initAutocomplete() {
                var myLatLng = {

                    lat: {{$branch['latitude'] ?? 23.811842872190343}},
                    lng: {{$branch['longitude'] ??  90.356331}},
                };
                const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                    center: {
                        lat: {{$branch['latitude'] ?? 23.811842872190343}},
                        lng: {{$branch['longitude'] ?? 90.356331}},
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
