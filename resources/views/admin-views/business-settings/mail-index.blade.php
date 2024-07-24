@extends('layouts.admin.app')

@section('title', translate('Settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/third-party.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('third_party')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <!-- Inline Page Menu -->
        @include('admin-views.business-settings.partials._3rdparty-inline-menu')

        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <button class="btn btn-secondary" type="button" data-toggle="collapse"
                                    data-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                <i class="tio-email-outlined"></i>
                                {{translate('test_your_email_integration')}}
                            </button>
                            <div class="">
                                <i class="tio-telegram"></i>
                            </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                            <div class="pt-3">
                                <form class="" id="upload-form" action="javascript:">
                                    <div class="d-flex gap-3">
                                        <div class="flex-grow-1">
                                            <label for="inputPassword2"
                                                    class="sr-only">{{translate('mail')}}</label>
                                            <input type="email" id="test-email" class="form-control" onkeyup="validationemail()" 
                                                    placeholder="{{translate('Ex : jhon@email.com')}}">
                                             <span id="textemail"></span>
                                        </div>
                                        <button type="button" onclick="send_mail()" id="submit" class="btn btn-primary">
                                            <i class="tio-telegram"></i>
                                            <span class="d-none d-sm-inline-block">{{translate('send_Mail')}}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php($data= \App\CentralLogics\Helpers::get_business_settings('mail_config'))
            <div class="col-12">
                <form id="upload-form1" action="{{env('APP_MODE')!='demo'?route('admin.business-settings.web-app.mail-config'):'javascript:'}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($data))
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap mb-3">
                                    <label class="control-label h3 mb-0 text-capitalize mr-3">{{translate('Mail Configuration  Status')}}</label>
                                    <!-- <div class="custom--switch">
                                        <input type="checkbox" name="status" value="" id="smtp-mail" switch="primary" class="toggle-switch-input" >
                                        <label for="smtp-mail" data-on-label="on" data-off-label="off"></label>
                                    </div> -->

                                    <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                    <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">on</span>
                                    <span class="mr-2 switch--custom-label-text off text-uppercase">off</span>
                                    <input type="checkbox" name="status" value="1"
                                           class="toggle-switch-input" {{isset($data['status']) && $data['status']==1 ? 'checked' : ''}}>
                                    <span class="toggle-switch-label text">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <label>{{translate('mailer_name')}}<span style="color:red">*</span></label>
                                        <input type="text" placeholder="{{translate('ex : Alex')}}" class="form-control" name="name"
                                            value="{{env('APP_MODE')!='demo'?$data['name']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('host')}}<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="host" value="{{env('APP_MODE')!='demo'?$data['host']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('driver')}}<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="driver" value="{{env('APP_MODE')!='demo'?$data['driver']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('port')}}<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="port" value="{{env('APP_MODE')!='demo'?$data['port']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('username')}}<span style="color:red">*</span></label>
                                        <input type="text" placeholder="{{translate('ex : ex@yahoo.com')}}" class="form-control" name="username"
                                            value="{{env('APP_MODE')!='demo'?$data['username']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('email')}} {{translate('id')}}<span style="color:red">*</span></label>
                                        <input type="email" id="email1" onkeyup="validationemail1()" placeholder="{{translate('ex : ex@yahoo.com')}}" class="form-control" name="email"
                                            value="{{env('APP_MODE')!='demo'?$data['email_id']:''}}" required>
                                     <span id="textemail1"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('encryption')}}</label><span style="color:red">*</span>
                                        <input type="text" placeholder="{{translate('ex : tls')}}" class="form-control" name="encryption"
                                            value="{{env('APP_MODE')!='demo'?$data['encryption']:''}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{translate('password')}}<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="password" value="{{env('APP_MODE')!='demo'?$data['password']:''}}" required>
                                    </div>
                                </div>
                                <div class="btn--container mt-3">
                                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" id="submit1" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary">{{translate('save')}}</button>
                                </div>
                            @else
                                <button type="submit"  class="btn btn-primary">{{translate('configure')}}</button>
                            @endif
                        </div>
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
        let email = document.getElementById('test-email').value
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

    function validationemail1() {
        let form = document.getElementById('upload-form1')
        let email = document.getElementById('email1').value
        let text = document.getElementById('textemail1')
        let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/

        if (email.match(pattern)) {
            form.classList.add('valid')
            form.classList.remove('invalid')
            text.innerHTML = ""
            text.style.color = '#00ff00'
            $('#submit1').removeAttr('disabled');
        } else {
            form.classList.remove('valid')
            form.classList.add('invalid')
            text.innerHTML = "Please Enter Valid Email Address"
            text.style.color = '#ff0000'
            $('#submit1').attr('disabled','disabled');
        }

        if (email == '') {
            form.classList.remove('valid')
            form.classList.remove('invalid')
            text.innerHTML = ""
            text.style.color = '#00ff00'
            $('#submit1').removeAttr('disabled','disabled');
        }
    }
</script>

    <script>
        function ValidateEmail(inputText) {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (inputText.match(mailformat)) {
                return true;
            } else {
                return false;
            }
        }

        function send_mail() {
            if (ValidateEmail($('#test-email').val())) {
                Swal.fire({
                    title: '{{translate('Are you sure?')}}?',
                    text: "{{translate('a_test_mail_will_be_sent_to_your_email')}}!",
                    showCancelButton: true,
                    confirmButtonColor: '#F56A57',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '{{translate('Yes')}}!',
                    cancelButtonText: '{{translate('Cancel')}}!',
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{route('admin.business-settings.web-app.mail-send')}}",
                            method: 'POST',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function () {
                                $('#loading').show();
                            },
                            success: function (data) {
                                if (data.success === 2) {
                                    toastr.error('{{translate('email_configuration_error')}} !!');
                                } else if (data.success === 1) {
                                    toastr.success('{{translate('email_configured_perfectly!')}}!');
                                } else {
                                    toastr.info('{{translate('email_status_is_not_active')}}!');
                                }
                            },
                            complete: function () {
                                $('#loading').hide();

                            }
                        });
                    }
                })
            } else {
                toastr.error('{{translate('invalid_email_address')}} !!');
            }
        }
    </script>
@endpush
