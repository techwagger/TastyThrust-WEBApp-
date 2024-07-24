@extends('layouts.admin.app')

@section('title', translate('QR Code'))

@section('content')
    <div class="content container-fluid">
        <section class="qr-code-section">
            <div class="card">
                <div class="card-body">
                    <div class="qr-area">
                        <div class="left-side pr-xl-4">
                            @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()?->value)
                            <div class="qr-wrapper" tyle="background: url({{asset('public/assets/admin/img/qr-bg.png')}}) no-repeat scroll 0% 0% / 100% 100% !important; -webkit-print-color-adjust: exact !important; color-adjust: exact !important; print-color-adjust: exact !important;">

                                <div class="d-flex justify-content-center">
                                    <a href="" class="qr-logo">
                                        <img src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}" class="mw-100"
                                        onerror="this.src='{{asset('public/assets/admin/img/logo2.png')}}'" alt="">
                                    </a>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="view-menu" tyle="border-top: 1px solid #f7c446; border-bottom: 1px solid #f7c446; padding-bottom: .25rem; margin-top: 1rem;">
                                        {{ isset($data) ? $data['title'] : translate('title') }}
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <div>
                                        <img src="{{asset('public/assets/admin/img/scan-me.png')}}" class="mw-100" alt="">
                                    </div>
                                    <div class="my-3">
                                        {!! $code !!}
                                    </div>
                                </div>
                                <div class="subtext">
                                    <span>
                                        {{ isset($data) ? $data['description'] : translate('description') }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="open-time" style="background: #dc373f; padding: 8px 16px; margin-top: 20px; border-radius: 5px; color: #fff">
                                        <div>{{ translate('OPEN DAILY') }}</div>
                                        <div>{{ isset($data) ? $data['opening_time'] : '09:00 AM' }} - {{ isset($data) ? $data['closing_time'] : '09:00 PM' }}</div>
                                    </div>
                                </div>
                                <div class="phone-number text-center mt-3" style="border-bottom: 1px solid #ff6767; padding-bottom: .5rem;">
                                    {{ translate('PHONE NUMBER') }} : {{ isset($data) ? $data['phone'] : '+00 123 4567890' }}
                                </div>

                                <div class="row g-0 text-center bottom-txt">
                                    <div class="col-6 border-right py-3" style="border-right: 1px solid #ff6767;">
                                        {{ isset($data) ? $data['website'] : 'www.website.com' }}
                                    </div>
                                    <div class="col-6 py-3">
                                        {{ isset($data) ? $data['social_media'] : translate('@social-media-name') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-side">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



