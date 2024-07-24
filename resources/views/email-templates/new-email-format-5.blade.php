<!DOCTYPE html>
<?php
$lang = \App\CentralLogics\Helpers::get_default_language();
   // $site_direction = \App\CentralLogics\Helpers::system_default_direction();
    $logo = \App\Model\BusinessSetting::where('key','logo')->first()?->value;

?>
{{--<html lang="{{ $lang }}" class="{{ $site_direction === 'rtl'?'active':'' }}">--}}
<html lang="{{ $lang }}" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ translate('Password_Reset') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #f7fbff;
            color: #334257;
            font-size: 13px;
            line-height: 1.5;
            display: flex;align-items: center;justify-content: center;
            min-height: 100vh;

        }
        :root {
           --base: #ffa726
        }
        table {
            border-collapse: collapse !important;
        }
        .border-top {
            border-top: 1px solid rgba(0, 170, 109, 0.3);
            padding: 15px 0 10px;
            display: block;
        }
        .d-block {
            display: block;
        }
        .privacy {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }
        .privacy a {
            text-decoration: none;
            color: #334257;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
        .privacy a span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334257;
            display: inline-block;
            margin: 0 7px;
        }
        .social {
            margin: 15px 0 8px;
            display: block;
        }
        .copyright{
            text-align: center;
            display: block;
        }
        .text-base {
            color: var(--base);
            font-weight: 700
        }

        .mail-img-1 {
            width: 140px;
            height: 60px;
            object-fit: contain
        }
        .mail-img-2 {
            width: 130px;
            height: 45px;
            object-fit: contain
        }
        .mail-img-3 {
            width: 100%;
            height: 172px;
            object-fit: cover
        }
        .social img {
        width: 24px;
        }
    </style>
</head>

<body style="background-color: #e9ecef;padding:15px">
{{--    <table dir="{{ $site_direction }}" style="width:100%;max-width:500px;margin:0 auto;text-align:center;background:#fff">--}}
    <table dir="" style="width:100%;max-width:500px;margin:0 auto;text-align:center;background:#fff">
        <tr>
            <td style="padding:30px 30px 0">
                <img class="mail-img-2" style="width:100px"
                @if ($data['icon'])
                src="{{ asset('storage/app/public/email_template/') }}/{{ $data['icon']??'' }}"
                @else
                {{-- src='{{ asset('/public/assets/admin/img/email-template-img.png') }}' --}}
                @endif
                id="iconViewer" alt="">
                <h3 style="font-size:17px;font-weight:500" class="mt-2" id="mail-title">{{ $title?? translate('Main_Title_or_Subject_of_the_Mail') }}</h3>

            </td>
        </tr>
        <tr>
            <td style="padding:0 30px 30px; text-align:left">
                <span style="font-weight:500;display:block;margin: 20px 0 11px;" id="mail-body">{!! $body??'Please click the link below to change your password' !!}</span>
                @if (isset($url))
                <span style="display:block;margin-bottom:14px">
                    <a href="{{ $url }}" style="color: #0177CD">{{ $url }}</a>
                </span>
                @endif
                @if ($data?->button_url)
                    <span class="d-block text-center" style="margin-top: 16px">
                    <a href="{{ $data['button_url']??'#' }}" class="cmn-btn" id="mail-button">{{ $data['button_name']??'Submit' }}</a>
                    </span>
                    @endif
                    <div class="mb-2" id="mail-footer" style="border-top: 1px solid #e2f5ee;padding-top: 15px;margin-top: 15px;">
                        Please contact us for any queries, we’re always happy to help. 
                   </div>
                   <br>
                  
                   <div>
                       Thanks &amp; Regards,
                   </div>
                   <br>
                   <div class="mb-4">
                    {{ $company_name }}
                   </div>
                
           
                @if ($logo)
                <img style="width:120px;display:block;margin:10px auto" src="{{ asset('storage/app/public/restaurant/' . $logo) }}" alt="public/img">
                @else
                {{-- <img style="width:120px;display:block;margin:10px auto"  src="{{asset('/public/assets/admin/img/favicon.png')}}" alt="public/img"> --}}
                @endif
                {{-- <span class="privacy">
                    @if(isset($data['privacy']) && $data['privacy'] == 1)
                        <a href="{{ route('privacy-policy') }}" id="privacy-check">{{ translate('Privacy_Policy')}}</a>
                    @endif
                    @if(isset($data['contact']) && $data['contact'] == 1)
                        <a href="{{ route('about-us') }}" id="contact-check">{{ translate('Contact_Us')}}</a>
                    @endif
                </span> --}}
                {{--                <span class="social" style="text-align:center">--}}
                {{--                    @php($social_media = \App\Model\SocialMedia::active()->get())--}}
                {{--                    @dd($social_media, $data)--}}
                {{--                    @if (isset($social_media))--}}
                {{--                        @foreach ($social_media as $social)--}}
                {{--                            <a href="{{ $social->link }}" target=”_blank” id="{{ $social->name  }}-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data[$social->name]) && $data[$social->name] == 1)?'':'display:none;' }}">--}}
                {{--                                <img src="{{asset('/public/assets/admin/img/img/')}}/{{ $social->name }}.png" alt="">--}}
                {{--                            </a>--}}
                {{--                        @endforeach--}}
                {{--                    @endif--}}
                {{--                </span>--}}
<tr>
    <td>
        <span class="privacy" style="display: block;width: 100%;text-align: center;">
                @if(isset($data['privacy']) && $data['privacy'] == 1)
                    <a href="{{ route('privacy-policy') }}" id="privacy-check">{{ translate('Privacy_Policy')}}</a>
                    <span style="content: '';
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: #334257;
                    display: inline-block;
                    margin: 0 7px;"></span>
                @endif
                @if(isset($data['refund']) && $data['refund'] == 1)
                    <a href="{{ route('refund-page') }}" id="refund-check">{{ translate('Refund_Policy')}}</a>
                    <span style="content: '';
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: #334257;
                    display: inline-block;
                    margin: 0 7px;"></span>
                @endif

                @if(isset($data['cancelation']) && $data['cancelation'] == 1)
                    <a href="{{ route('return-page') }}" id="return-check">{{ translate('Cancellation_Policy')}}</a>
                    <span style="content: '';
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: #334257;
                    display: inline-block;
                    margin: 0 7px;"></span>
                @endif 
                @if(isset($data['contact']) && $data['contact'] == 1)
                    <a href="{{ route('about-us') }}" id="contact-check">{{ translate('Contact_Us')}}</a>
                    {{-- <span style="content: '';
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: #334257;
                    display: inline-block;
                    margin: 0 7px;"></span> --}}
                @endif
            
        </span>
    </td>
</tr>
<tr>
    <td style="text-align: center;">
        <span class="social" style="text-align:center">
           @foreach ($socialMediaData as $value)
                @if(isset($value->name) && $value->name == 'facebook')
                    <a href="https://{{ $value->link }}" id="facebook-check" style="margin: 0 5px;text-decoration:none;">
                        <img style="width:30px" src="https://food.progocrm.com/public/assets/admin/img/img/facebook.png" alt="">
                    </a>
                @endif

                @if(isset($value->name) && $value->name == 'instagram')
                    <a href="https://{{ $value->link }}" id="instagram-check" style="margin: 0 5px;text-decoration:none;">
                        <img style="width:30px" src="https://food.progocrm.com/public/assets/admin/img/img/instagram.png" alt="">
                    </a>
                @endif

                @if(isset($value->name) && $value->name == 'twitter')
                    <a href="https://{{ $value->link }}" id="twitter-check" style="margin: 0 5px;text-decoration:none;">
                        <img style="width:30px" src="https://food.progocrm.com/public/assets/admin/img/img/twitter.png" alt="">
                    </a>
                @endif

                @if(isset($value->name) && $value->name == 'linkedin')
                    <a href="https://{{ $value->link }}" id="linkedin-check" style="margin: 0 5px;text-decoration:none;">
                        <img style="width:30px" src="https://food.progocrm.com/public/assets/admin/img/img/linkedin.png" alt="">
                    </a>
                @endif
                @if(isset($value->name) && $value->name == 'pinterest')
                <a href="https://{{ $value->link }}" id="pinterest-check" style="margin: 0 5px;text-decoration:none;">
                    <img style="width:30px" src="https://food.progocrm.com/public/assets/admin/img/img/pinterest.png" alt="">
                </a>
                @endif
                <!-- Add similar blocks for other social media platforms as needed -->
            @endforeach
        </span>
    </td>
</tr>
<tr>
    <td style="text-align: center;">
        <span class="copyright" id="mail-copyright">
            {{ $copyright_text ?? translate('Copyright_2023_eFood._All_right_reserved') }}
        </span>
    </td>
</tr>
    </table>
</body>

</html>
