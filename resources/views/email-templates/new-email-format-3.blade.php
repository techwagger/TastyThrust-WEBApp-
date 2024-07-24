<!DOCTYPE html>
<html>
  <head>
    <title>{{ translate('Email_Template') }}</title>
    <style>
        td.p-1.px-3 {
            text-align: end;
        }
        #mail-body p {
            margin-bottom: -5px;
        }
    </style>
  </head>
  <body>
    <table class="main-table" style="width: 600px; background: #f4f4f4; margin: 0 auto; padding: 8px; font-family: Roboto, sans-serif;
 font-size: 11.5207px; line-height: 21px;  color: #737883;border: 1px solid #f4f4f4;">
      <tbody>
        <tr>
          <td class="main-table-td">
            <h2 class="mb-3" id="mail-title" style="color: #000;">{{ $title?? translate('Main_Title_or_Subject_of_the_Mail') }}</h2>
            <div class="mb-1" id="mail-body">{!! $body?? translate('Hi_Sabrina,') !!}</div>
            
            {{-- <span class="d-block text-center mb-3" style="text-align: center;display: block;">
              <a href="#" class="cmn-btn" id="mail-button" style="background: #ff7a00; color: #fff; padding: 8px 20px;  display: inline-block; text-decoration: none;"></a>
            </span> --}}
            <table class="bg-section p-10 w-100" width="100%">
              <tbody>
                {{-- <tr>
                  <td style="height: 10px;"></td>
                </tr> --}}
                <tr>
                  <td class="p-10" style="background-color: #e3f5f1;text-align: center; padding: 10px;">
                    <span class="d-block text-center"> @php($restaurant_logo = \App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value) <img class="mb-2 mail-img-2" style="width:100px" onerror="this.src='{{ asset('storage/app/public/restaurant/' . $restaurant_logo) }}'" src='{{ asset("storage/app/public/email_template/")."/".$data["logo"] }}' id="logoViewer" alt='{{ asset("storage/app/public/email_template/")."/".$data["logo"] }}'>  
                      <h3 class="mb-3 mt-0" style="color: #000000;font-size: 18px;margin: 0 0 5px;">{{ translate('Order_Info') }}</h3>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table class="order-table w-100" width="100%">
                      <tbody>
                        <tr>
                          <td>
                            <div class="pl-2 mt-1">
                              <h3 class="subtitle" style="color: #000000;font-size: 18px;margin: 0 0 5px;">Order Summary</h3>
                              <span class="d-block">{{ translate('Order') }}# {{ $order->id  }}</span>
                              <br>
                              <span class="d-block">{{date('d M Y',strtotime($order['created_at']))}} {{ date(config('time_format'), strtotime($order['created_at'])) }}</span>
                            </div>
                          </td>
                          <td style="max-width:130px; text-align:right;">
                            <h3 class="subtitle mt-2" style="color: #000000;font-size: 18px;margin: 0 0 5px;">Delivery Address</h3>
                            <span class="d-block">{{ $address['address'] ?? $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}</span><br>
                              <span class="d-block">
                               {{ $order['delivery_address']['address'] }}
                              </span>

                            <span class="d-block">{{ $address['contact_person_number'] ?? null }}</span>
                          </td>
                        </tr> 
                        @php($sub_total=0) @php($total_tax=0) @php($total_dis_on_pro=0) @php($add_ons_cost=0) @php($add_on_tax=0) @php($add_ons_tax_cost=0) 
                        <tr>
                          <td colspan="2">
                            <table class="order-table w-100" width="100%">
                              <thead class="bg-section-2" style="background-color: #cccccd;">

                                {{-- <tr>
                                  <th class="text-left p-1 px-3" style="text-align: left; padding-left: 5px; color: #000; width:75%;">Product</th>
                                  <th class="text-right p-1 px-3" style="text-align: right;  padding-right: 5px; color: #000; width:25%">Price</th>
                                </tr> --}}

                                <tr>
                                  <th class="text-left p-1 px-3">{{ translate('DESCRIPTION') }}</th>
                                  <th class="text-center p-1 px-3">{{ translate('QTY') }}</th>
                                  <th class="text-right p-1 px-3">{{ translate('PRICE') }}</th>
                              </tr>
                              </thead>
                              <tbody>
                                @php($item_price=0)   
                                @php($sub_total=0)
                                @php($total_tax=0)
                                @php($total_dis_on_pro=0)
                                @php($add_ons_cost=0)
                                @php($add_on_tax=0)
                                @php($add_ons_tax_cost=0)
                                @foreach($order->details as $detail)
                                  @php($product_details = json_decode($detail['product_details'], true))
                                  @php($add_on_qtys=json_decode($detail['add_on_qtys'],true))
                                  @php($add_on_prices=json_decode($detail['add_on_prices'],true))
                                  @php($add_on_taxes=json_decode($detail['add_on_taxes'],true))
                                  <?php
                                    $amount = 0; 
                                    $addon_price = array();
                                  ?>
                                    {{-- <tr class="border">
                                      <td class="border text-left p-2 px-3" width="65%">
                                        <b style="font-size: 14px;">Schezwan Noodles</b><br>
                                          Portion Size :<br>
                                          Full : ₹265.00<br>
                                      </td>
                                      <td class="border text-center p-2 px-3">
                                          1
                                      </td>
                                      <td class="border text-right p-2 px-3">
                                          <b style="font-size: 14px;">
                                          ₹265.00
                                          </b>
                                      </td>
                                    </tr> --}}



                                  <tr class="border">
                                    <td class="border text-left p-2 px-3" style="text-align: left;">
                                      <b style="font-size: 14px;">{{$product_details['name']}}</b>
                                      <div class="d-flex gap-2">
                                        @if (isset($detail['variation']))
                                          @foreach(json_decode($detail['variation'],true) as  $variation)
                                            @if (isset($variation['name'])  && isset($variation['values']))
                                              <span class="d-block text-capitalize">
                                                <strong>{{  $variation['name']}} -</strong>
                                              </span>
                                              @foreach ($variation['values'] as $value)
                                                <span class="d-block text-capitalize">
                                                  {{ $value['label']}} :
                                                  <strong>{{\App\CentralLogics\Helpers::set_symbol( $value['optionPrice'])}}</strong>
                                                  <?php
                                                    $amount = $amount + $value['optionPrice']; 
                                                  ?>
                                                </span>
                                              @endforeach
                                            @else
                                              @if (isset(json_decode($detail['variation'],true)[0]))
                                                <strong><u> {{  translate('Variation') }} : </u></strong>
                                                @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                  <div class="font-size-sm text-body">
                                                    <span>{{$key1}} :  </span>
                                                    <span class="font-weight-bold">{{$variation}}</span>
                                                  </div>
                                                @endforeach
                                              @endif
                                            @endif
                                          @endforeach
                                        @else
                                          <div class="font-size-sm text-body">
                                            <span class="text-dark">{{translate('price')}}  : {{\App\CentralLogics\Helpers::set_symbol($detail['price'])}}</span>
                                          </div>
                                          <?php
                                            $amount = $amount + $detail->price; 
                                          ?>
                                        @endif

                                        @php($addon_ids = json_decode($detail['add_on_ids'],true))

                                        <div class="d-flex gap-2">
                                          {{-- <span class="">{{translate('Qty')}} :  </span>
                                          <span>{{$detail['quantity']}}</span> --}}

                                          @if (isset($detail['variation']) && count($addon_ids) < 1)
                                            <b class="">{{translate('price')}} : {{\App\CentralLogics\Helpers::set_symbol($detail['price'])}}</b>
                                            <br/>
                                          @endif
                                        </div>

                                        @if ($addon_ids)
                                          <span>
                                            <b>{{translate('addons')}}</b>
                                            @foreach($addon_ids as $key2 =>$id)
                                              @php($addon=\App\Model\AddOn::find($id))
                                              @php($add_on_qtys==null? $add_on_qty=1 : $add_on_qty=$add_on_qtys[$key2])
                                                  <b>{{$addon ? $addon['name'] : translate('addon deleted')}} :  
                                                    {{$add_on_qty}} x {{ \App\CentralLogics\Helpers::set_symbol($add_on_prices[$key2]) }} </b> <br>
                                              @php($add_ons_cost+=$add_on_prices[$key2] * $add_on_qty)
                                              {{-- @php($add_ons_tax_cost +=  $add_on_taxes[$key2] * $add_on_qty) --}}
                                              @php($add_ons_tax_cost +=  $add_on_taxes[$key2] * $add_on_qtys[$key2])
                                            @endforeach
                                          </span>
                                          <br/>
                                        @endif
                                      </div>
                                    </td>

                                    <td class="border text-center p-2 px-3">
                                          {{$detail['quantity']}}
                                    </td>

                                    <td class="border text-right p-2 px-3" style="text-align: right;">
                                      @if (!empty(json_decode($detail['variation'])))
                                        @php($amount = $amount * $detail['quantity'])
                                      @else
                                          @php($amount = $detail['price'] * $detail['quantity'])
                                      @endif

                                      {{-- @php($amount=($detail['price']-$detail['discount_on_product'])*$detail['quantity']) --}}
                                      <b>{{ \App\CentralLogics\Helpers::set_symbol($amount) }}</b>

                                      <?php 
                                          $tot_discount = 0;
                                          if(json_decode($detail['product_details'])->discount_type == 'percent') {
                                              $tot_discount = ($amount * json_decode($detail['product_details'])->discount) / 100;
                                          } else {
                                              $tot_discount = json_decode($detail['product_details'])->discount * $detail['quantity'];
                                          }

                                          $taxable_amt = 0;
                                          $taxable_amt = $amount - $tot_discount;
                                          if(json_decode($detail['product_details'])->tax_type == 'percent') {
                                              $taxable_amt = ($taxable_amt * json_decode($detail['product_details'])->tax) / 100;
                                          } else {
                                              $taxable_amt = json_decode($detail['product_details'])->tax;
                                          }

                                          $total_tax = $total_tax + ($taxable_amt * $detail['quantity']) ;

                                      ?>
                                      @php($total_dis_on_pro += $tot_discount)

                                      @php($total_after_discount = ($detail['price'] - $detail['discount_on_product']) * $detail['quantity'])

                                      @php($sub_total+=$amount)

                                      @php($item_price += $total_after_discount)

                                      @if($detail->product['tax_type'] == 'percent')
                                          @php($price_tax = ($detail->price / 100) * $detail->product['tax']) 
                                          @php($total_gst = ($total_after_discount / 100) * $detail->product['tax'])
                                      @else
                                          @php($total_gst = $detail->product['tax'])
                                      @endif
                                    </td>
                                  </tr>  
                                  @endforeach         
                                  <tr>
                                    <td colspan="3">
                                      {{-- <hr class="mt-0"> --}}
                                        <table style="width: 100%; margin-top:5px;">
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3">{{ translate('Item_Price') }}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($sub_total) }}</td>
                                          </tr>
                                          {{-- <tr>
                                            <td style="width: 40%"></td>
                                            <td class="p-1 px-3">{{translate('tax')}} / {{translate('vat')}}</td>
                                            <td class="text-right p-1 px-3">{{ \App\CentralLogics\Helpers::set_symbol($total_tax) }}</td>
                                          </tr> --}}
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3">{{translate('Addons')}} {{translate('Price')}}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($add_ons_cost) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3">{{ translate('Item_Discount') }}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($total_dis_on_pro) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3"><b>{{ translate('Subtotal') }}</b></td>
                                            <td class="text-right p-1 px-3" style="text-align: right;"><b>{{ \App\CentralLogics\Helpers::set_symbol($sub_total + $add_ons_cost - $total_dis_on_pro) }}</b></td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3">{{translate('Coupon')}} {{translate('Discount')}}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($order['coupon_discount_amount']) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3"> {{translate('Extra Discount')}}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($order['extra_discount']) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3"> {{translate('Tax / GST')}}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($total_tax + $add_ons_tax_cost) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3"> {{translate('Delivery Fee')}}</td>
                                              @if($order['order_type']=='take_away')
                                                @php($del_c=0)
                                              @else
                                                @php($del_c=$order['delivery_charge'])
                                              @endif
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($del_c) }}</td>
                                          </tr>
                                          <?php 
                                              $total_due_amount = 0;
                                              $total_due_amount = $total = $sub_total+$del_c+$total_tax+$add_ons_cost-$order['coupon_discount_amount']-$order['extra_discount']+$add_ons_tax_cost+$order['packing_fee']-$total_dis_on_pro;
                                          ?>
                                          {{-- <tr>
                                            <td style="width: 40%"></td>
                                            <td class="p-1 px-3"><h4>{{ translate('total') }}</h4></td>
                                            <td class="text-right p-1 px-3" style="text-align: right;"><h4>{{ \App\CentralLogics\Helpers::set_symbol($total) }}</h4></td>
                                          </tr> --}}
                                          @if ($order->order_partial_payments->isNotEmpty())
                                            @foreach ($order->order_partial_payments as $partial)
                                              <tr>
                                                <td style="width: 15%"></td>
                                                <td class="p-1 px-3"> {{translate('Paid By')}} ({{str_replace('_', ' ',$partial->paid_with)}})</td>
                                                <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($partial->paid_amount) }}</td>
                                              </tr>
                                            @endforeach
                                            <tr>
                                              <td style="width: 15%"></td>
                                              <td class="p-1 px-3"> {{translate('Due Amount')}}</td>
                                              <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol($total_due_amount = $total - $partial->paid_amount) }}</td>
                                            </tr>
                                          @endif
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3">{{translate('Round')}} {{translate('Off')}}</td>
                                            <td class="text-right p-1 px-3" style="text-align: right;">{{ \App\CentralLogics\Helpers::set_symbol(round($total_due_amount) - $total_due_amount) }}</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 15%"></td>
                                            <td class="p-1 px-3" style="font-weight: bold;"><h3>{{ translate('Total') }}</h3></td>
                                            <td class="text-right p-1 px-3" style="text-align: right;"><h3>{{ \App\CentralLogics\Helpers::set_symbol(round($total_due_amount)) }}</h3></td>
                                          </tr>
                                        </table>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <hr>
            <div class="mb-2" id="mail-footer"> Order Placement </div>
            <div> Thanks &amp; Regards, </div>
            <div class="mb-4"> {{ $company_name }} </div>
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
            <span class="copyright" id="mail-copyright"> Copyright 2024 TastyThrust all rights reserved. </span>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>