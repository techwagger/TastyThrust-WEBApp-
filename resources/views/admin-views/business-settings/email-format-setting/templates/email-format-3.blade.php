<?php
$company_name = App\Model\BusinessSetting::where('key', 'restaurant_name')->first()->value;
?>

<style>
    td.p-1.px-3 {
        text-align: end;
    }
    #mail-body p {
        margin-bottom: -5px;
    }
</style>
<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <h2 class="mb-3" id="mail-title">{{ $data['title']?? translate('Main_Title_or_Subject_of_the_Mail') }}</h2>
                <div class="mb-1" id="mail-body">{!! $data['body']?? translate('Hi_Sabrina,') !!}</div>
                <span class="d-block text-center mb-3">
                    <a href="#" class="cmn-btn" id="mail-button">{{ $data['button_name']??'Track Order' }}</a>
                </span>
                <table class="bg-section p-10 w-100">
                    <tbody>
                        <tr>
                            <td class="p-10">
                                <span class="d-block text-center">
                                    @php($restaurant_logo = \App\Models\EmailTemplate::get()[0]->logo)

                                    <img class="mb-2 mail-img-2" onerror="this.src='{{ asset('storage/app/public/email_template/' . $restaurant_logo) }}'"
                                    src="{{ asset('storage/app/public/email_template/') }}/{{ $data['logo']??'' }}" id="logoViewer" alt="">
                                    <h3 class="mb-3 mt-0">{{ translate('Order_Info') }}</h3>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="order-table w-100">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="pl-2 mt-1">
                                                    <h3 class="subtitle">{{ translate('Order_Summary') }}</h3>
                                                    <span class="d-block">{{ translate('Order') }}# 48573</span>
                                                    <span class="d-block">23 Jul, 2023 4:30 am</span>
                                                </div>

                                            </td>
                                            <td style="max-width:130px">
                                                <h3 class="subtitle mt-2">{{ translate('Delivery_Address') }}</h3>
                                                <span class="d-block">Munam qq Shahariar</span>
                                                <span class="d-block" >4517 Washington Ave. Manchester, Kentucky 39495</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"style="height:15px"></td>
                                        </tr>
                                        <td colspan="2" class="">
                                            <table class="w-100">
                                                <thead class="bg-section-2">
                                                    <tr>
                                                        <th class="text-left p-1 px-3">{{ translate('DESCRIPTION') }}</th>
                                                        <th class="text-center p-1 px-3">{{ translate('QTY') }}</th>
                                                        <th class="text-right p-1 px-3">{{ translate('PRICE') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border">
                                                        <td class="border text-left p-2 px-3" width="65%">
                                                          <b style="font-size: 14px;">Schezwan Noodles</b><br>
                                                             Portion Size :<br>
                                                             Price : ₹265.00<br>
                                                        </td>
                                                        <td class="border text-center p-2 px-3">
                                                            1
                                                        </td>
                                                        <td class="border text-right p-2 px-3">
                                                            <b style="font-size: 14px;">
                                                            ₹265.00
                                                            </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border text-left p-2 px-3" width="65%">
                                                          <b style="font-size: 14px;"> Noodles</b><br>
                                                             Portion Size :<br>
                                                             Price : ₹150.00<br>
                                                        </td>
                                                        <td class="border text-center p-2 px-3">
                                                            1
                                                        </td>
                                                        <td class="border text-right p-2 px-3">
                                                            <b style="font-size: 14px;">
                                                             ₹150.00
                                                            </b>
                                                        </td>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <td colspan="3">
                                                            {{-- <hr class="mt-0"> --}}
                                                            <table style="width: 100%; margin-top:5px;">
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Item Price :</td>
                                                                    <td class="text-right p-1 px-3">₹85.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Addon Price :</td>
                                                                    <td class="text-right p-1 px-3">₹85.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Item Discount :</td>
                                                                    <td class="text-right p-1 px-3">₹85.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3"><b>Sub total :</b></td>
                                                                    <td class="text-right p-1 px-3"><b>₹90.00</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Coupon Discount :</td>
                                                                    <td class="text-right p-1 px-3">₹00.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Extra Discount :</td>
                                                                    <td class="text-right p-1 px-3">₹00.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Tax / GST :</td>
                                                                    <td class="text-right p-1 px-3">₹15.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Delivery Fee :</td>
                                                                    <td class="text-right p-1 px-3">₹20.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">Round Off :</td>
                                                                    <td class="text-right p-1 px-3">₹20.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 15%"></td>
                                                                    <td class="p-1 px-3">
                                                                        <h4>Total :</h4>
                                                                    </td>
                                                                    <td class="text-right p-1 px-3">
                                                                        <h4>₹105.00</h4>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class="mb-2" id="mail-footer">
                    {{ $data['footer_text'] ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}
                </div>
                <div>
                    {{ translate('Thanks_&_Regards') }},
                </div>
                <div class="mb-4">
                    {{ $company_name }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span class="privacy">
                    
                    <a href="#" id="privacy-check" style="{{ (isset($data['privacy']) && $data['privacy'] == 1)?'':'display:none;' }}">{{ translate('Privacy_Policy')}}</a>
                    <a href="#" id="refund-check" style="{{ (isset($data['refund']) && $data['refund'] == 1)?'':'display:none;' }}">{{ translate('Refund_Policy') }}</a>
                    <a href="#" id="cancelation-check" style="{{ (isset($data['cancelation']) && $data['cancelation'] == 1)?'':'display:none;' }}">{{ translate('Cancellation_Policy') }}</a>
                    <a href="#" id="contact-check" style="{{ (isset($data['contact']) && $data['contact'] == 1)?'':'display:none;' }}">{{ translate('Contact_us') }}</a>
                </span>
                <span class="social" style="text-align:center">
                    <a href="#" id="facebook-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data['facebook']) && $data['facebook'] == 1)?'':'display:none;' }}">
                        <img src="{{asset('/public/assets/admin/img/img/facebook.png')}}" alt="">
                    </a>
                    <a href="#" id="instagram-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data['instagram']) && $data['instagram'] == 1)?'':'display:none;' }}">
                        <img src="{{asset('/public/assets/admin/img/img/instagram.png')}}" alt="">
                    </a>
                    <a href="#" id="twitter-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data['twitter']) && $data['twitter'] == 1)?'':'display:none;' }}">
                        <img src="{{asset('/public/assets/admin/img/img/twitter.png')}}" alt="">
                    </a>
                    <a href="#" id="linkedin-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data['linkedin']) && $data['linkedin'] == 1)?'':'display:none;' }}">
                        <img src="{{asset('/public/assets/admin/img/img/linkedin.png')}}" alt="">
                    </a>
                    <a href="#" id="pinterest-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data['pinterest']) && $data['pinterest'] == 1)?'':'display:none;' }}">
                        <img src="{{asset('/public/assets/admin/img/img/pinterest.png')}}" alt="">
                    </a>
                </span>
                <span class="copyright" id="mail-copyright">
                    {{ $data['copyright_text']?? translate('Copyright_2023_eFood._All_right_reserved') }}
                </span>
            </td>
        </tr>
    </tbody>
</table>
