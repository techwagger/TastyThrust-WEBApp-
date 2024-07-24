@extends('layouts.admin.app')

@section('title', translate('New_Sale'))

@push('css_or_js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
<style>
    .dataTables_paginate {
        margin-top: 15px; /* Adjust the top margin as needed */
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    display: inline-block !important;
    min-width: 1.5em !important;
    padding: .5em 1em !important;
    margin-left: 2px !important;
    text-align: center !important;
    text-decoration: none !important;
    cursor: pointer !important;
    color: #8c98a4 !important;
    border: 1px solid transparent !important;
    border-radius: .3125rem !important;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff!important;
    background-color: #ff611d;
    border-color: #ff611d;
}
    /* #location_map_div #pac-input{
        height: 40px;
        border: 1px solid #fbc1c1;
        outline: none;
        box-shadow: none;
        top: 7px !important;
        transform: translateX(7px);
        padding-left: 10px;
    } */
    #location_map_div #pac-input {
    height: 40px;
    border: 1px solid #fbc1c1;
    outline: none;
    width: 100%;
    box-shadow: none;
    position: relative;
    top: 5px !important;
    /* transform: translateX(7px); */
    padding-left: 10px;
}


</style>
<script>
    // function validateform() {
    //     let phone = document.getElementById('phone').value;
    //     if(phone.length > 7 && phone.length < 15) {
    //         alert('Please enter a valid phone number');
    //         return false;
    //     }
    // }
</script>
@endpush

@section('content')
    {{--    loader--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="loading" class="d--none">
                    <div class="loading-inner">
                        <img width="200" src="{{asset('public/assets/admin/img/loader.gif')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    loader--}}
    <div class="content">
        <header id="header"
                class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered d-none">
            <div class="navbar-nav-wrap">
                <div class="navbar-brand-wrapper">
                    <a class="navbar-brand py-0" href="{{route('admin.dashboard')}}" aria-label="Front">
                        @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                        <img class="navbar-brand-logo rounded-circle avatar avatar-lg"
                             style="border: 5px solid #80808012"
                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                             src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}"
                             alt="Logo">
                    </a>
                    {{\Illuminate\Support\Str::limit($current_branch->name,15)}}
                </div>

                <div class="navbar-nav-wrap-content-right">
                    <ul class="navbar-nav align-items-center flex-row">
                        <li class="nav-item d-none d-sm-inline-block">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                                   href="{{route('admin.orders.list',['status'=>'pending'])}}">
                                    <i class="tio-shopping-cart-outlined"></i>
                                    {{--<span class="btn-status btn-sm-status btn-status-danger"></span>--}}
                                </a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                                   data-hs-unfold-options='{
                                    "target": "#accountNavbarDropdown",
                                    "type": "css-animation"
                                }'>
                                    <div class="avatar avatar-sm avatar-circle">
                                        @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                                        <img class="avatar-img"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                             src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                             alt="Image">
                                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                    </div>
                                </a>

                                <div id="accountNavbarDropdown"
                                     class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account navbar-dropdown-lg">
                                    <div class="dropdown-item-text">
                                        <div class="media align-items-center">
                                            <div class="avatar avatar-sm avatar-circle mr-2">
                                                <img class="avatar-img"
                                                     onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                     src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                                     alt="Owner image">
                                            </div>
                                            <div class="media-body">
                                                <span class="card-title h5">{{ $current_branch->name }}</span>
                                                <span class="card-text">{{ $current_branch->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="javascript:" onclick="Swal.fire({
                                title: '{{translate('Do you want to logout')}}?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonColor: '#FC6A57',
                                cancelButtonColor: '#363636',
                                confirmButtonText: '{{translate('Yes')}}',
                                denyButtonText: `{{translate('Do not Logout')}}`,
                                }).then((result) => {
                                if (result.value) {
                                location.href='{{route('admin.auth.logout')}}';
                                } else{
                                Swal.fire('Canceled', '', 'info')
                                }
                                })">
                                        <span class="text-truncate pr-2" title="Sign out">{{translate('sign_out')}}</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>


        {{--<main id="content" role="main" class="main pointer-event">--}}
        <!-- ========================= SECTION CONTENT ========================= -->
        <section class="section-content padding-y-sm bg-default mt-3">
            <div class="container-fluid">
                <div class="row gy-3 gx-2">
                    <div class="col-lg-7">
                        <div class="card">
                            <!-- POS Title -->
                            <div class="pos-title">
                                <h4 class="mb-0">{{translate('Product_Section')}}</h4>
                            </div>
                            <!-- End POS Title -->

                            <!-- POS Filter -->
                            <div class="d-flex flex-wrap flex-md-nowrap justify-content-between gap-3 gap-xl-4 px-4 py-4">
                                <div class="w-100 mr-xl-2">
                                    <select name="category" id="category" class="form-control js-select2-custom-x mx-1" title="select category" onchange="set_category_filter(this.value)">
                                        <option value="">{{translate('All Categories')}}</option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}" {{$category==$item->id?'selected':''}}>{{ Str::limit($item->name, 40)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 ml-xl-2">
                                    {{-- <form id="search-form"> --}}
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush border rounded">
                                            <div class="input-group-prepend pl-2">
                                                <div class="input-group-text">
                                                    <!-- <i class="tio-search"></i> -->
                                                    <img width="13" src="{{asset('public/assets/admin/img/icons/search.png')}}" alt="">
                                                </div>
                                            </div>
                                            <input type="text" id="pos_search" onkeyup="PosSearch()" class="form-control border-0" placeholder="{{translate('Search here')}}" aria-label="Search here">
                                        </div>
                                        <!-- End Search -->
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <!-- End POS Filter -->

                            <!-- POS Products -->
                            <div class="card-body pt-0" id="items">
                                <div class="pos-item-wrap justify-content-center" id="pos_item">
                                    @foreach($products as $product)
                                        @include('admin-views.pos._single_product',['product'=>$product])
                                    @endforeach
                                </div>
                            </div>
                            <!-- End POS Products -->

                            <div class="p-3 d-flex justify-content-end">
                                {{-- {!!$products->withQueryString()->links()!!} --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card billing-section-wrap">
                            <!-- POS Title -->
                            <div class="pos-title">
                                <h4 class="mb-0">{{translate('Billing_Section')}}</h4>
                            </div>
                            <!-- End POS Title -->

                            <div class="p-2 p-sm-4">
                                <div class="form-group d-flex gap-2">
                                    <select onchange="store_key('customer_id',this.value)" id='customer' name="customer_id" data-placeholder="{{translate('Walk_In_Customer')}}" class="js-select2-custom-x form-ellipsis form-control">
                                    <option  disabled selected>{{translate('select Customer')}}</option>
                                    <option  selected>{{translate('Walk_In_Customer')}}</option>
                                    @foreach(\App\User::select('id', 'f_name', 'l_name')->get() as $customer)
                                            <option value="{{$customer['id']}}" {{ session()->get('customer_id') == $customer['id'] ? 'selected' : '' }}>{{$customer['f_name']. ' '. $customer['l_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success rounded text-nowrap" id="add_new_customer" type="button" data-toggle="modal" data-target="#add-customer" title="Add Customer">
                                        <i class="tio-add"></i>
                                        {{translate('Customer')}}
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label for="branch" class="font-weight-semibold fz-16 text-dark">{{translate('select_branch')}}</label>
                                    <select onchange="store_key('branch_id',this.value)" id='branch' name="branch_id" class="js-select2-custom-x form-ellipsis form-control">
                                        <option disabled selected>{{translate('select_branch')}}</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch['id']}}" {{ session()->get('branch_id') == $branch['id'] ? 'selected' : '' }}>{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="input-label font-weight-semibold fz-16 text-dark">{{translate('Select Order Type')}}</label>
                                    <div class="">
                                        <!-- Custom Radio -->
                                        <div class="form-control d-flex flex-column-3 p-area">
                                            <label class="custom-radio d-flex gap-2 align-items-center m-0">
                                                <input type="radio" class="" name="order_type" onclick="select_order_type('take_away')" {{ !session()->has('order_type') || session()->get('order_type') == 'take_away' ? 'checked' : '' }}>
                                                <span class="media align-items-center mb-0">
                                                    <span class="media-body">{{translate('Take Away')}}</span>
                                                </span>
                                            </label>

                                            <label class="custom-radio d-flex gap-2 align-items-center m-0">
                                                <input type="radio" class="" name="order_type" onclick="select_order_type('dine_in')" {{ session()->has('order_type') && session()->get('order_type') == 'dine_in' ? 'checked' : '' }}>
                                                <span class="media align-items-center mb-0">
                                                    <span class="media-body">{{translate('Dine-In')}}</span>
                                                    </span>
                                            </label>

                                            <label class="custom-radio d-flex gap-2 align-items-center m-0">
                                                <input type="radio" class="" name="order_type" onclick="select_order_type('home_delivery')" {{ session()->has('order_type') && session()->get('order_type') == 'home_delivery' ? 'checked' : '' }}>
                                                <span class="media align-items-center mb-0">
                                                    <span class="media-body">{{translate('Home Delivery')}}</span>
                                                </span>
                                            </label>
                                        </div>
                                        <!-- End Custom Radio -->
                                    </div>
                                </div>

                                <div class="d-none" id="dine_in_section">
                                    <div class="form-group d-flex flex-wrap flex-sm-nowrap gap-2">
                                        <select id='table' onchange="store_key('table_id',this.value)" name="table_id" class="js-select2-custom-x form-ellipsis form-control">
                                            <option disabled selected>{{translate('select_table')}}</option>
                                            @foreach($tables as $table)
                                                <option value="{{$table['id']}}" {{ session()->get('table_id') == $table['id'] ? 'selected' : '' }}>{{translate('table ')}} - {{$table['number']}}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="form-group d-flex flex-wrap flex-sm-nowrap gap-2">
                                        <input type="number" value="{{ session('people_number') }}" name="number_of_people"  step="1"
                                               oninput="this.value = this.value.replace(/[^\d]/g, '')"
                                               onkeyup="store_key('people_number',this.value)" id="number_of_people"
                                               class="form-control" id="number_of_people" min="1" max="99"
                                               placeholder="{{translate('Number Of People')}}">
                                    </div>
                                </div>

                                <div class="form-group d-none" id="home_delivery_section">
                                    <div class="d-flex justify-content-between">
                                        <label for="" class="font-weight-semibold fz-16 text-dark">{{translate('Delivery Information')}}
                                            <small>({{ translate('Home Delivery') }})</small>
                                        </label>
                                        <span class="edit-btn cursor-pointer" id="delivery_address" data-toggle="modal"
                                              data-target="#AddressModal"><i class="tio-edit"></i>
                                        </span>
                                    </div>
                                    <div class="pos--delivery-options-info d-flex flex-wrap" id="del-add">
                                        @include('admin-views.pos._address')
                                    </div>
                                </div>

                                <div class='w-100' id="cart">
                                    @include('admin-views.pos._cart')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- container //  -->
        </section>

        <!-- End Content -->
        <div class="modal fade" id="quick-view" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" id="quick-view-modal">

                </div>
            </div>
        </div>

        <div class="modal fade" id="add-customer" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{translate('Add_New_Customer')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetForm()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.pos.customer-store')}}" method="post" id="customer-form" onsubmit="return validateform()">
                            @csrf
                            <div class="row pl-2">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">
                                            {{translate('First_Name')}}
                                            <span class="input-label-secondary text-danger">*</span>
                                        </label>
                                        <input type="text" name="f_name" class="form-control" value="" placeholder="First name" required="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">
                                            {{translate('Last_Name')}}
                                            <span class="input-label-secondary text-danger">*</span>
                                        </label>
                                        <input type="text" name="l_name" class="form-control" value="" placeholder="Last name" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-2">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">
                                            {{translate('Email')}}
                                            <small class="input-label-secondary text-danger">*</small>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control" value="" placeholder="Ex : ex@example.com"  onkeyup="validationemail()"  required>
                                        <span id="textemail"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="content-row">
                                            <div class="col-area-2">
                                                <label for="name">{{translate('Code')}} <span class="text-danger">*</span></label>
                                                <div id="country-dropdown" class="form-control" style="z-index: 1;"></div>
                                                <input type="hidden"  id="hidden-country-code"  name="country_code">
                                                <input type="hidden"  id="hidden-country-code-string"  name="country_code_string">
    
                                                {{-- only for show store country code --}}
                                                <input type="hidden"  id="hidden-country-code-string-db">
                                            </div>
                                            <div class="col-area-10">
                                                <label>{{translate('Phone')}} <span class="text-danger">*</span></label> <br>
                                                <input type="number" name="phone" id="phone" class="form-control" value="" placeholder="{{translate('Ex : +88017*****')}}" required="" onkeyup="validateMobileNumber(this)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">
                                            {{translate('DOB')}}
                                            <small class="text-danger" style="margin-top: 3px;"> </small>
                                            <span class="input-label-secondary text-danger"></span>
                                        </label>
                                        <input type="date" name="dob" class="form-control" >
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label">
                                            {{translate('GSTIN')}}
                                            <small class="text-danger" style="margin-top: 3px;"> </small>
                                            <span class="input-label-secondary text-danger"></span>
                                        </label>
                                        <input type="text" name="gst_number" id="gst" class="form-control" value="" placeholder="{{translate('GSTIN')}}" onkeyup="validateGSTNumber(this)">
                                        <p class="error-message" id="gstError" style="display: none; color:red">Invalid GST No.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-secondary mr-1">{{translate('reset')}}</button>
                                <button type="submit" id="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                    <script>
                        function resetForm() {
                            document.getElementById("customer-form").reset();
                        }
                    </script>
                </div>
            </div>
        </div>

        @php($order=\App\Model\Order::find(session('last_order')))
        @if($order)
            @php(session(['last_order'=> false]))
            <div class="modal fade" id="print-invoice" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{translate('Print Invoice')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row ff-emoji">
                            <div class="col-md-12">
                                <center>
                                    <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                                           value="{{translate('Proceed, If thermal printer is ready.')}}"/>
                                    <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{translate('Back')}}</a>
                                </center>
                                <hr class="non-printable">
                            </div>
                            <div class="row m-auto" id="printableArea">
                                @include('admin-views.pos.order.invoice')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="modal fade" id="AddressModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom py-3">
                        <h5 class="modal-title flex-grow-1 text-center">{{ translate('Delivery Information') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php
                        if(session()->has('address')) {
                            $old = session()->get('address');
                        }else {
                            $old = null;
                        }
                        ?>
                        <form id='delivery_address_store'>
                            @csrf

                            <div class="row g-2" id="delivery_address">
                                <div class="col-md-6">
                                    <label class="input-label" for="">{{ translate('contact_person_name') }}
                                        <span class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" class="form-control" name="contact_person_name"
                                           value="{{ $old ? $old['contact_person_name'] : '' }}" placeholder="{{ translate('Ex :') }} Jhon" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="input-label" for="">{{ translate('Contact Number') }}
                                        <span class="input-label-secondary text-danger">*</span></label>
                                    <input type="number" class="form-control" name="contact_person_number" id="contact_person_number"
                                           value="{{ $old ? $old['contact_person_number'] : '' }}"  placeholder="{{ translate('Ex :') }} +3264124565" onkeyup="validateMobileNumber(this)" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="input-label" for="">{{ translate('Road') }}</label>
                                    <input type="text" class="form-control" name="road" value="{{ $old ? $old['road'] : '' }}"  placeholder="{{ translate('Ex :') }} 4th">
                                </div>
                                <div class="col-md-4">
                                    <label class="input-label" for="">{{ translate('House') }}</label>
                                    <input type="text" class="form-control" name="house" value="{{ $old ? $old['house'] : '' }}" placeholder="{{ translate('Ex :') }} 45/C">
                                </div>
                                <div class="col-md-4">
                                    <label class="input-label" for="">{{ translate('Floor') }}</label>
                                    <input type="text" class="form-control" name="floor" value="{{ $old ? $old['floor'] : '' }}"  placeholder="{{ translate('Ex :') }} 1A">
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <label class="input-label" for="">{{ translate('longitude') }}<span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                           value="{{ $old ? $old['longitude'] : '' }}" readonly required>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <label class="input-label" for="">{{ translate('latitude') }}<span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                           value="{{ $old ? $old['latitude'] : '' }}" readonly required>
                                </div>
                                <div class="col-md-12">
                                    <label class="input-label">{{ translate('address') }}</label>
                                    <textarea name="address" id="address" class="form-control" required>{{ $old ? $old['address'] : '' }}</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-primary">
                                            {{ translate('* pin the address in the map to calculate delivery fee') }}
                                        </span>
                                    </div>
                                    <div id="location_map_div">
                                        <input id="pac-input" class="controls rounded initial-8"
                                               title="{{ translate('search_your_location_here') }}" type="text"
                                               placeholder="{{ translate('search_here') }}" />
                                        <div id="location_map_canvas" class="overflow-hidden rounded" style="height: 80%;position: relative;top: 20px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class=" mt-5">
                                <div class="btn--container justify-content-end">
                                    <button class="btn btn-sm btn-primary w-100" type="button" onclick="deliveryAdressStore()" data-dismiss="modal">
                                        {{  translate('Update') }} {{ translate('Delivery address') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--</main>--}}
    </div>
@endsection

@push('script_2')
    <!-- JS Implementing Plugins -->
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
    {{-- <script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/toastr.js"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ \App\Model\BusinessSetting::where('key', 'map_api_client_key')->first()?->value }}&libraries=places&v=3.51"></script>

    {{--{!! Toastr::message() !!}--}}

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
    <script>
        function validationemail() {
            let form = document.getElementById('customer-form')
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

        document.getElementById('gst').addEventListener('input', function() {
            var gstNumber = this.value.trim();
            var gstRegex = /^(\d{2})([A-Z]{5})(\d{4})([A-Z]{1})([1-9]{1})([Z]{1})([A-Z\d]{1})$/;
            if (gstNumber === '') {
                document.getElementById('gstError').style.display = 'none';
                $('#submit').removeAttr('disabled','disabled');
            } else if (gstRegex.test(gstNumber)) {
                document.getElementById('gstError').style.display = 'none';
                $('#submit').removeAttr('disabled');
            } else {
                document.getElementById('gstError').style.display = 'block';
                $('#submit').attr('disabled','disabled');
            }
        });



        
    </script>
    
    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {
            @if($order)
            $('#print-invoice').modal('show');
            @endif
        });

        function printDiv(divName) {

            if($('html').attr('dir') === 'rtl') {
                $('html').attr('dir', 'ltr')
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                $('#printableAreaContent').attr('dir', 'rtl')
                window.print();
                document.body.innerHTML = originalContents;
                $('html').attr('dir', 'rtl')
                location.reload();
            }else{
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }

        }

        function set_category_filter(id) {
            var nurl = new URL('{!!url()->full()!!}');
            nurl.searchParams.set('category_id', id);
            location.href = nurl;
        }


        // $('#datatableSearch').on('input', function () {
        //     var keyword = $(this).val();
        //     var nurl = new URL('{!!url()->full()!!}');
        //     nurl.searchParams.set('keyword', keyword);
        //     location.href = nurl;
        // });

        function PosSearch() {
            var keyword = $('#pos_search').val();
            var base_url = window.location.origin;
            if(keyword.length > 0) {
                $.ajax({
                    url: base_url+'/admin/pos/pos-product-search',
                    type: "POST",
                    data: {
                        keyword: keyword,
                        _token:'{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(data){
                        let item = ''
                        let length = data.length;
 
                        for(let i = 0; i < length; i++) {
                            item += '<div class="pos-product-item card" onclick="quickView(' + data[i].id + ')">' +
                                        '<div class="pos-product-item_thumb">' +
                                            '<img src="' + base_url + '/storage/app/public/product/' + data[i].image + '" onerror="this.src="public/assets/admin/img/160x160/img2.jpg"" class="img-fit">' +
                                        '</div>' +
                                        '<div class="pos-product-item_content clickable">' +
                                            '<div class="pos-product-item_title">' + data[i].name + '</div>' +    
                                        '</div>' +
                                    '</div>';
                        }
                        $('#pos_item').html(item);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $.ajax({
                    url: base_url+'/admin/pos/pos-product-search',
                    type: "POST",
                    data: {
                        keyword: keyword,
                        _token:'{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(data){
                        let item = ''
                        let length = data.length;
 
                        for(let i = 0; i < length; i++) {
                            item += '<div class="pos-product-item card" onclick="quickView(' + data[i].id + ')">' +
                                        '<div class="pos-product-item_thumb">' +
                                            '<img src="' + base_url + '/storage/app/public/product/' + data[i].image + '" onerror="this.src="public/assets/admin/img/160x160/img2.jpg"" class="img-fit">' +
                                        '</div>' +
                                        '<div class="pos-product-item_content clickable">' +
                                            '<div class="pos-product-item_title">' + data[i].name + '</div>' +    
                                        '</div>' +
                                    '</div>';
                        }
                        $('#pos_item').html(item);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }


        function addon_quantity_input_toggle(e)
        {
            var cb = $(e.target);
            if(cb.is(":checked"))
            {
                cb.siblings('.addon-quantity-input').css({'visibility':'visible'});
            }
            else
            {
                cb.siblings('.addon-quantity-input').css({'visibility':'hidden'});
            }
        }
        function quickView(product_id) {
            $.ajax({
                url: '{{route('admin.pos.quick-view')}}',
                type: 'GET',
                data: {
                    product_id: product_id
                },
                dataType: 'json', // added data type
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    console.log("success...");
                    console.log(data);

                    // $("#quick-view").removeClass('fade');
                    // $("#quick-view").addClass('show');

                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });

        }

        function checkAddToCartValidity() {
            return true;
        }

        function cartQuantityInitialize() {
            $('.btn-number').click(function (e) {
                e.preventDefault();

                var fieldName = $(this).attr('data-field');
                var type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function () {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                var name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title:'{{translate("Cart")}}',
                        text: '{{translate('Sorry, the minimum value was reached')}}'
                    });
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title:'{{translate("Cart")}}',
                        confirmButtonText:'{{translate("Ok")}}',
                        text: '{{translate('Sorry, stock limit exceeded')}}.'
                    });
                    $(this).val($(this).data('oldValue'));
                }
            });
            $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }

        function getVariantPrice() {
            if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.pos.variant_price') }}',
                    data: $('#add-to-cart-form').serializeArray(),
                    success: function (data) {
                        if(data.error == 'quantity_error'){
                            toastr.error(data.message);
                        }
                        else{
                            $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                            // $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                        }
                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.pos.variant_price_new') }}',
                    data: $('#add-to-cart-form').serializeArray(),
                    success: function (data) {
                        console.log(data);
                        if(data.error == 'quantity_error'){
                            toastr.error(data.message);
                        }
                        else{
                            $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                            $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                            $('#chosen_priceTop').text(data.price);
                           
                            $('#chosen_priceTopdiscount').text(data.price);
                           
                            $('#set-discount-amount').text(data.discount_amount);

                            $('#chosen_priceTopstrike').text(data.pricestrike);
                        }
                    }
                });
            }
        }

        function addToCart(form_id = 'add-to-cart-form') {
          
            if (checkAddToCartValidity()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('admin.pos.add-to-cart') }}',
                    data: $('#' + form_id).serializeArray(),
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.data == 1) {
                            Swal.fire({
                                confirmButtonColor: '#FC6A57',
                                icon: 'info',
                                title: '{{translate("Cart")}}',
                                confirmButtonText:'{{translate("Ok")}}',
                                text: "{{translate('Product already added in cart')}}"
                            });
                            return false;
                        } else if (data.data == 0) {
                            Swal.fire({
                                confirmButtonColor: '#FC6A57',
                                icon: 'error',
                                title: '{{translate("Cart")}}',
                                confirmButtonText:'{{translate("Ok")}}',
                                text: '{{translate('Sorry, product out of stock')}}.'
                            });
                            return false;
                        }
                        else if (data.data == 'variation_error') {
                            Swal.fire({
                                confirmButtonColor: '#FC6A57',
                                icon: 'error',
                                title: 'Cart',
                                text: data.message
                            });
                            return false;
                        }
                        $('.call-when-done').click();

                        toastr.success('{{translate('Item has been added in your cart')}}!', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                        updateCart();
                    },
                    complete: function () {
                        $('#loading').hide();
                    }
                });
            } else {
                Swal.fire({
                    confirmButtonColor: '#FC6A57',
                    type: 'info',
                    title: '{{translate("Cart")}}',
                    confirmButtonText:'{{translate("Ok")}}',
                    text: '{{translate('Please choose all the options')}}'
                });
            }
        }

        function removeFromCart(key) {
            $.post('{{ route('admin.pos.remove-from-cart') }}', {_token: '{{ csrf_token() }}', key: key}, function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    updateCart();
                    toastr.info('{{translate('Item has been removed from cart')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }

            });
        }

        function emptyCart(id) {
            if(id > 0) {
                $.post('{{ route('admin.pos.emptyCart') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                    updateCart();
                    toastr.info('{{translate('Item has been removed from cart')}}', {
                        CloseButton: true,
                        ProgressBar: true,
                        onHidden: function () {
                            location.reload();
                        }
                    });
                });
            }
        }

        function updateCart() {
            $.post('<?php echo e(route('admin.pos.cart_items')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
                $('#cart').empty().html(data);
            });
        }

        $(function(){
            $(document).on('click','input[type=number]',function(){ this.select(); });
        });


        function updateQuantity(e){
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            // maxValue = parseInt(element.attr('max'));
            var valueCurrent = parseInt(element.val());

            var key = element.data('key');
            if (valueCurrent >= minValue) {
                $.post('{{ route('admin.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:valueCurrent}, function (data) {
                    updateCart();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '{{translate("Cart")}}',
                    confirmButtonText:'{{translate("Ok")}}',
                    text: '{{translate('Sorry, the minimum value was reached')}}'
                });
                element.val(element.data('oldValue'));
            }
            // if (valueCurrent <= maxValue) {
            //     $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            // } else {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Cart',
            //         text: 'Sorry, stock limit exceeded.'
            //     });
            //     $(this).val($(this).data('oldValue'));
            // }


            // Allow: backspace, delete, tab, escape, enter and .
            if(e.type == 'keydown')
            {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            }

        };



        // INITIALIZATION OF SELECT2
        // =======================================================
        // $('.js-select2-custom').each(function () {
        //     var select2 = $.HSCore.components.HSSelect2.init($(this));
        // });

        $('.branch-data-selector').select2();
        $('.table-data-selector').select2();

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{route('admin.pos.customers')}}',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });


        $('#order_place').submit(function(eventObj) {
            if($('#customer').val())
            {
                $(this).append('<input type="hidden" name="user_id" value="'+$('#customer').val()+'" /> ');
            }
            return true;
        });

        function store_key(key, value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.post({
                url: '{{route('admin.pos.store-keys')}}',
                data: {
                    key:key,
                    value:value,
                },
                success: function (data) {
                    console.log(data);
                    var selected_field_text = key;
                    var selected_field = selected_field_text.replace("_", " ");
                    var selected_field = selected_field.replace("id", " ");
                    var message = selected_field+' '+'selected!';
                    var new_message = message.charAt(0).toUpperCase() + message.slice(1);
                    toastr.success((new_message), {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    // if (data === 'table_id') {
                    //     $('#pay_after_eating_li').css('display', 'block')
                    // }
                },

            });
        };


        $(document).ready(function (){
            $('#branch').on('change', function (){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/pos/session-destroy') }}",
                    success: function() {
                        location.reload();
                    }
                });
            });
        });

        $(document).ready(function() {
            var orderType = {!! json_encode(session('order_type')) !!};

            if (orderType === 'dine_in') {
                $('#dine_in_section').removeClass('d-none');
            } else if (orderType === 'home_delivery') {
                $('#home_delivery_section').removeClass('d-none');
                $('#dine_in_section').addClass('d-none');
            } else {
                $('#home_delivery_section').addClass('d-none');
                $('#dine_in_section').addClass('d-none');
            }
        });

        function select_order_type(order_type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.post({
                url: '{{route('admin.pos.order_type.store')}}',
                data: {
                    order_type:order_type,
                },
                success: function (data) {
                    console.log(data);
                    updateCart();
                },
            });

            if (order_type == 'dine_in') {
                $('#dine_in_section').removeClass('d-none');
                $('#home_delivery_section').addClass('d-none')
            } else if(order_type == 'home_delivery') {
                $('#home_delivery_section').removeClass('d-none');
                $('#dine_in_section').addClass('d-none');
            }else{
                $('#home_delivery_section').addClass('d-none')
                $('#dine_in_section').addClass('d-none');
            }
        }

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
                                document.getElementById('address').value = results[1].formatted_address;
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

        function deliveryAdressStore(form_id = 'delivery_address_store') {
            let contact_person_number = $('#contact_person_number').val();
            if(contact_person_number.length )
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.pos.add-delivery-address') }}',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    console.log(data.errors);
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#del-add').empty().html(data.view);
                    }
                    updateCart();
                    $('.call-when-done').click();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }


    </script>
    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom-x').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
    <!-- IE Support -->
    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
    </script>

   

@endpush
{{-- </body>
</html> --}}

