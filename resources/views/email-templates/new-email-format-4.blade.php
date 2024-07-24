<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
</head>
<body>


<table class="main-table" style="width: 600px; background: #fff; margin: 0 auto; padding: 8px; font-family: Roboto, sans-serif;
  font-size: 11.5207px; line-height: 21px;  color: #737883;border: 1px solid #f4f4f4;">
    <tbody>
        <tr>
            <td class="main-table-td">
                <h2 class="mb-3" id="mail-title" style="color: #000; text-align: center;">
                    <img style="width:100px" src="{{ asset('storage/app/public/email_template/') }}/{{ $data['icon']??'' }}" />
                </h2>
                <h2 class="mb-3" id="mail-title" style="color: #5b6777; text-align: center;font-size: 22px;margin-bottom: 0;">
                    {{ $title?? translate('Main_Title_or_Subject_of_the_Mail') }}
                </h2>
                <div class="mb-1" id="mail-body" style="text-align:center; margin-top: 0;"><p style="text-align:center; margin-top: 5px;">Please enter 4 digit code.</p>
                    <h2 class="mb-3" style="color: #5b6777; text-align: center;font-size: 26px;margin-bottom: 0;">
                    {{ $code??'' }}
                </h2>
                </div>
                
                
                
                <div class="mb-2" id="mail-footer" style="border-top: 1px solid #e2f5ee;padding-top: 15px;margin-top: 15px;">
                     Please contact us for any queries, we’re always happy to help. 
                </div>
                <div>
                    Thanks &amp; Regards,
                </div>
                <div class="mb-4">
                    {{ $company_name }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span class="privacy" style="display: block;width: 100%;text-align: center;">
                        @if(isset($data['privacy']) && $data['privacy'] == 1)
                            <a href="{{ route('privacy-policy') }}" id="privacy-check">{{ translate('Privacy_Policy')}}</a><span style="content: '';
                            width: 6px;
                            height: 6px;
                            border-radius: 50%;
                            background: #334257;
                            display: inline-block;
                            margin: 0 7px;"></span>
                        @endif
                       
                        @if(isset($data['refund']) && $data['refund'] == 1)
                            <a href="{{ route('refund-page') }}" id="refund-check">{{ translate('Refund_Policy')}}</a><span style="content: '';
                                width: 6px;
                                height: 6px;
                                border-radius: 50%;
                                background: #334257;
                                display: inline-block;
                                margin: 0 7px;"></span>
                        @endif
                        @if(isset($data['cancelation']) && $data['cancelation'] == 1)
                            <a href="{{ route('return-page') }}" id="return-check">{{ translate('Cancellation_Policy')}}</a><span style="content: '';
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
    </tbody>
</table>


</body>
</html> 