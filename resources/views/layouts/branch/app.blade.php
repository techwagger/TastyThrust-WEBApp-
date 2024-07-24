<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    @php($icon = \App\Model\BusinessSetting::where(['key' => 'fav_icon'])->first()->value)
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/restaurant/' . $icon ?? '') }}">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/vendor/icon-set/style.css">
    
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/style.css?v=1.0">
    @stack('css_or_js')

    <!-- <style>
        .scroll-bar {
            max-height: calc(100vh - 100px);
            overflow-y: auto !important;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 1px #cfcfcf;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FC6A57;
        }
    </style> -->

    <script
        src="{{asset('public/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>

<body class="footer-offset">
    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>

{{--loader--}}
<div id="loading" style="display: none;">
    <div class="loader-copound">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        
        @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
        <img width="200" src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}">
    </div>
</div>
       
{{--loader--}}

<!-- Builder -->
@include('layouts.branch.partials._front-settings')
<!-- End Builder -->

<!-- JS Preview mode only -->
@include('layouts.branch.partials._header')
@include('layouts.branch.partials._sidebar')
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
    @yield('content')
    <!-- End Content -->

    <!-- Footer -->
    @include('layouts.branch.partials._footer')
    <!-- End Footer -->

    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <center>
                                <h2 style="color: rgba(96,96,96,0.68);font-size:16px">
                                    <i class="tio-shopping-cart-outlined"></i> {{ translate('You have a new order, please check.') }}
                                </h2>
                                <hr>
                                <button onclick="check_order()" class="btn btn-primary">{{ translate('Ok, let me check') }}</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ========== END MAIN CONTENT ========== -->



<!-- ========== END SECONDARY CONTENTS ========== -->

<script src="{{asset('public/assets/admin')}}/js/custom.js"></script>
<!-- JS Implementing Plugins -->

@stack('script')

<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
<script src="{{asset('public/assets/admin/js/owl.min.js')}}"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif


<script type="text/javascript">

    //validation for mobile no
    function validateMobileNumber(input) {
        var phoneNumber = input.value;
    
        phoneNumber = phoneNumber.replace(/\D/g, '');
        input.value = phoneNumber;

        if(phoneNumber.length > 10) {
            input.value = phoneNumber.slice(0, 10);
        }
    }

    //validation for identity number
    function validateIdentityNumber(input) {
        var IdentityNumber = input.value;
    
        input.value = IdentityNumber;

        if(IdentityNumber.length > 20) {
            input.value = IdentityNumber.slice(0, 20);
        }
    }

    //validation for gst number
    function validateGSTNumber(input) {
        var GstNumber = input.value;
    
        input.value = GstNumber;

        if(GstNumber.length > 15) {
            input.value = GstNumber.slice(0, 15);
        }
    }

    //validation for pin cde
    function validatePinCode(input) {
        var pinCode = input.value;
    
        pinCode = pinCode.replace(/\D/g, '');
        input.value = pinCode;

        if(pinCode.length > 6) {
            input.value = pinCode.slice(0, 6);
        }
    }
</script>

{{-- //--------- For datatable font size ----------// --}}


  <script>
    $(document).on('ready', function() {
        $('#datatable').css('font-size', '13px');
    });
    </script>
<!-- Toggle Direction Init -->
<script>
    $(document).on('ready', function(){

        $(".direction-toggle").on("click", function () {
            setDirection(localStorage.getItem("direction"));
        });

        function setDirection(direction) {
            if (direction == "rtl") {
                localStorage.setItem("direction", "ltr");
                $("html").attr('dir', 'ltr');
            $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                localStorage.setItem("direction", "rtl");
                $("html").attr('dir', 'rtl');
            $(".direction-toggle").find('span').text('Toggle LTR')
            }
        }

        if (localStorage.getItem("direction") == "rtl") {
            $("html").attr('dir', "rtl");
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $("html").attr('dir', "ltr");
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

    })
</script>


<!-- JS Plugins Init. -->

<script>
    // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
    // =======================================================
    var sidebar = $('.js-navbar-vertical-aside').hsSideNav();
    $(document).on('ready', function () {
        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });
        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });
        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });
    });
</script>
@stack('script_2')
<audio id="myAudio">
    <source src="{{asset('public/assets/admin/sound/notification.mp3')}}" type="audio/mpeg">
</audio>

<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }
</script>
<script>
    setInterval(function () {
        $.get({
            url: '{{route('branch.get-restaurant-data')}}',
            dataType: 'json',
            success: function (response) {
                let data = response.data;
                if (data.new_order > 0) {
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                }
            },
        });
    }, 10000);

    function check_order() {
        location.href = '{{route('branch.order.list',['status'=>'all'])}}';
    }

    function route_alert(route, message) {
        Swal.fire({
            title: '{{ translate('Are you sure?') }}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('No') }}',
            confirmButtonText: '{{ translate('Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    function form_alert(id, message) {
        Swal.fire({
            // title: '{{ translate('Are you sure?') }}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('No') }}',
            confirmButtonText: '{{ translate('Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }
</script>

<script>
    function call_demo(){
        toastr.info('{{ translate('Update option is disabled for demo!') }}', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>

    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF SHOW PASSWORD
            // =======================================================
            $('.js-toggle-password').each(function () {
                new HSTogglePassword(this).init()
            });

            // INITIALIZATION OF FORM VALIDATION
            // =======================================================
            $('.js-validate').each(function () {
                $.HSCore.components.HSValidation.init($(this));
            });
        });
    </script>
  @php($date_format=\App\Model\BusinessSetting::where('key','date_format')->first()->value)
  <script>
           
           $(function () {
                // Get today's date
                var today = new Date();
                // Set maxDate option to today to hide future dates
                var maxDate = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

                $("#expire_date").datepicker({
                    dateFormat: "dd-mm-yy", // Customize the date format
                    changeMonth: true,
                    changeYear: true,
                    maxDate: maxDate // Hide future dates
                });

                $("#start_date").datepicker({
                    dateFormat: "dd-mm-yy", // Customize the date format
                    changeMonth: true,
                    changeYear: true,
                    maxDate: maxDate // Hide future dates
                });

                // Initialize the datepicker for the "from_date" input field
                $("#from_date").datepicker({
                    dateFormat: "<?php echo $date_format ?>", // Customize the date format
                    changeMonth: true,
                    changeYear: true,
                    maxDate: maxDate // Hide future dates
                });

                // Initialize the datepicker for the "to_date" input field
                $("#to_date").datepicker({
                    dateFormat: "<?php echo $date_format ?>", // Customize the date format
                    changeMonth: true,
                    changeYear: true,
                    maxDate: maxDate // Hide future dates
                });
            });
     
 </script> 
 {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<link rel="stylesheet" href="https://cdn.rawgit.com/weareoutman/clockpicker/v0.0.7/dist/bootstrap-clockpicker.min.css">
<script src="https://cdn.rawgit.com/weareoutman/clockpicker/v0.0.7/dist/jquery-clockpicker.min.js"></script>

<!-- Your existing script -->
<script>
    $(function () { 
        $('#datetimepicker1').clockpicker({
            autoclose: true,
            'default': '10:30', // Default time for available_time_starts
        });

        $('#datetimepicker2').clockpicker({
            autoclose: true,
            'default': '10:30', // Default time for available_time_starts
        });
    });
</script>


<!-- Include jQuery UI library -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://www.jquery-az.com/jquery/js/intlTelInput/intlTelInput.js"></script>
<link rel="stylesheet" href="{{asset('public/assets/admin/css/demo.css')}}">
<link href="https://www.jquery-az.com/jquery/css/intlTelInput/intlTelInput.css" rel="stylesheet" />
<!-- Include jQuery UI CSS for styling -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
    $(document).ready(function() {
        var countryDropdown = $("#country-dropdown");
        var selectedCountryData = $("#selected-country-data");
        var hiddenInput = $("#hidden-country-code");
        var hiddenInputString = $("#hidden-country-code-string");
        var hiddenInputStringDB = $("#hidden-country-code-string-db").val();

        let preferredCountries_data = 'in';

        if(hiddenInputStringDB != '') {
            preferredCountries_data = hiddenInputStringDB;
        }

        // Initialize the country dropdown
        countryDropdown.intlTelInput({
            preferredCountries: [preferredCountries_data],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
        });

        // Manually trigger the 'countrychange' event to update the hidden input
        countryDropdown.trigger("countrychange");

        // Event listener for the change event
        countryDropdown.on("countrychange", function() {
            // Get selected country data
            var countryData = countryDropdown.intlTelInput('getSelectedCountryData');

            // Set the value of the hidden input field
            hiddenInput.val("+" + countryData.dialCode);
            hiddenInputString.val(countryData.iso2);

            // Display selected country data
            selectedCountryData.text("Selected Country Data: " + JSON.stringify(countryData));
        });

    });
    
</script>
<script>
    $('#from_date, #to_date').change(function () {
        let fr = $('#from_date').val();
        let to = $('#to_date').val();
        
        if (fr !== '' && to !== '') {
            // Parse dates in the format dd-mm-yy
            let fromDate = parseDate(fr);
            let toDate = parseDate(to);
            if (isNaN(fromDate) || isNaN(toDate) || fromDate > toDate) {
            // if (isNaN(fromDate) || isNaN(toDate) || fromDate >= toDate) {
                $('#from_date').val('');
                $('#to_date').val('');
                toastr.error('Invalid date range! Start date must be less than end date.', 'Error', {
                    closeButton: true,
                    progressBar: true
                });
            }
        }
    });

    $('#reset_btn').click(function () {
        $('#customer').val(null).trigger('change');
    });

    // Function to parse date in the format dd-mm-yy
    function parseDate(dateString) {
        let parts = dateString.split("-");
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }
</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>


</body>
</html>
