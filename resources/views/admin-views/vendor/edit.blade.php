@extends('layouts.admin.app')

@section('title', translate('Vendor'))
<style>
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
    .datatable_wrapper_row .dt-buttons {
    display: inline-flex;
    gap: 8px;
    margin-top: 0 !important;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #111;
}
</style>
@section('content')
        
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/inventory/supplier.png')}}" alt="">
            <span class="page-header-title">
                {{translate('vendor')}} 
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row g-2">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.vendor.update', [$vendor->id]) }}" id="vendor-form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="input-label">{{translate('Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $vendor->name }}" placeholder="{{translate('vendor')}}" required>
                                </div>
                                <div class="form-group">
                                    <label class="input-label">{{translate('Mobile')}} <span class="text-danger">*</span></label>
                                    <input type="number" name="mobile" class="form-control" value="{{ $vendor->mobile }}" required onkeyup="validateMobileNumber(this)">
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{translate('Address')}} <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" placehder="{{translate('Ex: ABC')}}" style="resize: none;">{{ $vendor->address }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="input-label">{{translate('Email')}} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" onkeyup="validationemail()" class="form-control" value="{{ $vendor->email }}" mailto:placeholder="{{translate('abc@gmail.com')}}" required>
                                    <span id="textemail"></span>
                                </div>
                                <div class="form-group">
                                    <label class="input-label">{{translate('GST_No.')}}</label>
                                    <input type="text" name="gst" id="gst" class="form-control" value="{{ $vendor->gst }}" placeholder="{{translate('GST_No.')}}">
                                    <p class="error-message" id="gstError" style="display: none; color:red">Invalid GST No.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="reset" id="reset" class="btn btn-secondary">{{translate('Reset')}}</button>
                            <button type="submit" id="submit" class="btn btn-primary">{{translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@push('script_2')

    <script>
        function validationemail() {
            let form = document.getElementById('vendor-form')
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

        $('#reset').on('click', function() {
            document.getElementById('gstError').style.display = 'none';
            $('#submit').removeAttr('disabled');
        });
    </script>
@endpush
