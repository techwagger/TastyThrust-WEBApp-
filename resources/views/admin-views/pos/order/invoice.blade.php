
<style>
    .font-size-sm{
        font-size:12px;
    }
    .invoice-logo img {
        max-width: 100px;
    }
</style>    

<div style="width:360px;" id="printableAreaContent">
    <div class="text-center pt-4 mb-3 w-100">
        <div class="row">
            <div class="col-sm-4 p-0 invoice-logo">
                @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                <img src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}" onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="Logo"/>
            </div>
            <div class="col-sm-8">
                <h2 style="line-height: 1">{{\App\Model\BusinessSetting::where(['key'=>'restaurant_name'])->first()->value}}</h2>
                <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
                    {{\App\Model\BusinessSetting::where(['key'=>'address'])->first()->value}}
                </h5>
                <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                    {{translate('Phone')}}
                    : {{\App\Model\BusinessSetting::where(['key'=>'phone'])->first()->value}}
                </h5>
                <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                    {{translate('GSTIN')}}
                    : {{\App\Model\BusinessSetting::where(['key'=>'gst_number'])->first()->value}}
                </h5>
            </div>
        </div>
    </div>

    {{-- <span>------------------------------------------</span> --}}
    <div style="border:1px dashed gray"></div>
    <div class="row mt-3">
        <div class="col-6">
            <h5>{{translate('Order ID')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6" style="text-align: right">
            <h5 style="font-weight: lighter;" class="order_id font-size-sm">
                {{date('d/M/Y h:i a', strtotime($order['created_at']))}}
            </h5>
        </div>

        @if($order->customer)
            <div class="col-12">
                <h5>{{translate('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</h5>
                <h5>{{translate('Phone')}} : {{$order->customer['phone']}}</h5>
            </div>
        @else
            <div class="col-12">
                <h5>{{translate('Customer Name')}} : Walking Customer</h5>
                <h5>{{translate('Phone')}} : (XXX)-XXX-XXX </h5>
            </div>
        @endif

        @if(isset($order->customer['gst_number']) && !empty($order->customer['gst_number']))
            <div class="col-12">
                <h5>{{translate('GSTIN')}} : {{$order->customer['gst_number']}}</h5>
            </div>
        @endif
    </div>

    {{-- <span>------------------------------------------</span> --}}
    <div style="border:1px dashed gray"></div>
    
    <table class="table table-bordered mt-3" style="width: 98%">
        <thead>
        <tr>
            <th style="width: 10%">{{translate('QTY')}}</th>
            <th class="">{{translate('DESCRIPTION')}}</th>
            <th style="text-align:center;">{{translate('PRICE')}}</th>
        </tr>
        </thead>

        <tbody>
        @php($item_price=0)
        @php($total_tax=0)
        @php($total_dis_on_pro=0)
        @php($add_ons_cost=0)
        @php($add_on_tax=0)
        @php($add_ons_tax_cost=0)
        @foreach($order->details as $detail)
        <?php 
            echo "<pre>";
                print_r(json_decode($detail->product_details)->discount_type);
        ?>
            @if($detail->product)
                @php($add_on_qtys=json_decode($detail['add_on_qtys'],true))
                @php($add_on_prices=json_decode($detail['add_on_prices'],true))
                @php($add_on_taxes=json_decode($detail['add_on_taxes'],true))
                <?php
                    $amount = 0; 
                    $addon_price = array();
                ?>
                <tr>
                    <td class="" style="text-align:center">
                        {{$detail['quantity']}}
                    </td>
                    <td class="" style="text-align:left">
                        <span style="word-break: break-all;"> {{ Str::limit($detail->product['name'], 200) }}</span><br>
                        @if (count(json_decode($detail['variation'], true)) > 0)
                            <strong>{{ translate('variation') }} : </strong>
                            @foreach(json_decode($detail['variation'],true) as  $variation)
                                @if ( isset($variation['name'])  && isset($variation['values']))
                                    <span class="d-block text-capitalize">
                                        <strong>{{  $variation['name']}} - </strong>
                                    </span>
                                    @foreach ($variation['values'] as $value)
                                        <span class="d-block text-capitalize">
                                            {{ $value['label']}} :
                                            <strong>{{\App\CentralLogics\Helpers::set_symbol( $value['optionPrice'])}}</strong>
                                        </span>
                                        <?php
                                            $amount = $amount + $value['optionPrice']; 
                                        ?>
                                    @endforeach
                                @else
                                    @if (isset(json_decode($detail['variation'],true)[0]))
                                        @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                            <div class="font-size-sm text-body">
                                                <span>{{$key1}} :  </span>
                                                <span class="font-weight-bold">{{$variation}}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                    @break
                                @endif
                            @endforeach
                        @else
                            <div class="font-size-sm text-body">
                                <span>{{ translate('Price') }} : </span>
                                <span class="font-weight-bold">
                                    {{ \App\CentralLogics\Helpers::set_symbol($detail->price) }}
                                </span>
                            </div>
                            <?php
                                $amount = $amount + $detail->price; 
                            ?>
                        @endif

                        @foreach(json_decode($detail['add_on_ids'],true) as $key2 =>$id)
                            @php($addon=\App\Model\AddOn::find($id))
                            @if($key2==0)<strong class="font-size-sm">{{translate('Addons')}} :</strong>@endif

                            @if($add_on_qtys==null)
                                @php($add_on_qty=1)
                            @else
                                @php($add_on_qty=$add_on_qtys[$key2])
                            @endif

                            <div class="font-size-sm text-body" style="width:173px">
                                <span>{{$addon ? $addon['name'] : translate('addon deleted')}} :  </span>
                                <span class="font-weight-bold">
                                    {{$add_on_qty}} x {{ \App\CentralLogics\Helpers::set_symbol($add_on_prices[$key2]) }} <br>
                                </span>
                            </div>
                            <span class="font-size-sm">
                                @php($add_ons_cost+=$add_on_prices[$key2] * $add_on_qty)
                                @php($add_ons_tax_cost +=  $add_on_taxes[$key2] * $add_on_qty)
                            </span>
                        @endforeach
                        <span class="font-size-sm">
                            <?php 
                                $discount_amt = 0;
                                if(json_decode($detail->product_details)->discount_type == 'percent') {
                                    $discount_amt = ($amount * json_decode($detail->product_details)->discount) / 100;
                                } else {
                                    $discount_amt = json_decode($detail->product_details)->discount * $detail['quantity'];
                                }    
                            ?>
                            {{-- {{translate('Discount')}} : {{ \App\CentralLogics\Helpers::set_symbol($detail['discount_on_product']*$detail['quantity']) }} --}}
                            {{translate('Discount')}} : {{ \App\CentralLogics\Helpers::set_symbol($discount_amt) }}
                        </span>
                          
                    </td>

                    <td style="width: 28%;padding-right:4px; text-align:right">
                        {{-- @php($amount=($amount-$detail['discount_on_product'])*$detail['quantity']) --}}
                        @php($amount = ($amount - $discount_amt) * $detail['quantity'])
                        {{ \App\CentralLogics\Helpers::set_symbol($amount) }}

                        {{-- @php($total_after_discount = ($detail['price'] - $detail['discount_on_product']) * $detail['quantity']) --}}
                        @php($total_after_discount = $amount)
                       
                    </td>

                    <?php 
                        // $taxable_amt = 0;
                        // echo $taxable_amt = $amount - $tot_discount;
                        if(json_decode($detail['product_details'])->tax_type == 'percent') {
                            $taxable_amt = ($amount * json_decode($detail['product_details'])->tax) / 100;
                        } else {
                            $taxable_amt = json_decode($detail['product_details'])->tax * $detail['quantity'];
                        }

                        // $total_tax = $total_tax + ($taxable_amt * $detail['quantity']) ;
                        $total_tax = $total_tax + ($taxable_amt) ;

                    ?>
                    
                </tr>
                    @php($item_price += $total_after_discount)

                    @if($detail->product['tax_type'] == 'percent')
                        @php($price_tax = (($detail->price / 100) * $detail->product['tax']) * $detail['quantity']) 
                        @php($total_gst = (($total_after_discount / 100) * $detail->product['tax']) * $detail['quantity'])
                    @else
                        @php($price_tax = $detail->product['tax'])
                    @endif
                    
                    {{-- @php($total_tax += $price_tax * $detail['quantity']) --}}
                    
            @endif
        @endforeach
        </tbody>
    </table>

    {{-- <span>------------------------------------------</span> --}}
    <div style="border:1px dashed gray"></div>
    <br/>
    <div class="row justify-content-md-end">
        <div class="col-md-12 col-lg-12">
            <dl class="row text-right" style="color: black !important;">
                <dt class="col-8">{{translate('Items Price')}}:</dt>
                <dd class="col-4" >{{\App\CentralLogics\Helpers::set_symbol($item_price)}}</dd>
               
                <dt class="col-8">{{translate('Addons Price')}}:</dt>
                <dd class="col-4">{{\App\CentralLogics\Helpers::set_symbol($add_ons_cost)}}</dd>

                @php($subtotal = $add_ons_cost + $item_price)
                <dt class="col-8" style="font-weight: bold">{{translate('Subtotal')}}:</dt>
                <dd class="col-4" style="font-weight: bold">{{ \App\CentralLogics\Helpers::set_symbol($subtotal) }}</dd>

                <dt class="col-8">{{translate('Coupon Discount')}}:</dt>
                <dd class="col-4">-{{ \App\CentralLogics\Helpers::set_symbol($order['coupon_discount_amount']) }}</dd>

                <dt class="col-8">{{translate('Extra Discount')}}:</dt>
                <dd class="col-4">-{{ \App\CentralLogics\Helpers::set_symbol($order['extra_discount']) }}</dd>
                    
                <dt class="col-8">{{translate('Tax')}} / {{translate('GST')}}:</dt>
                <dd class="col-4">{{\App\CentralLogics\Helpers::set_symbol($total_tax + $add_ons_tax_cost)}}</dd>

                @if($order['packing_fee']!=0)
                    <dt class="col-8">{{ translate('Packing Fee') }}:</dt>
                    <dd class="col-4">{{ \App\CentralLogics\Helpers::set_symbol($order['packing_fee']) }}</dd>
                @endif
                
                
                @if($order['order_type']=='delivery')
                    <dt class="col-8">{{translate('Delivery Fee:')}}</dt>
                    <dd class="col-4">
                        @if($order['order_type']=='take_away')
                            @php($del_c=0)
                        @else
                            @php($del_c=$order['delivery_charge'])
                        @endif
                        {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                        <hr>
                    </dd>
                @endif
                    
                <dt class="col-8" style="display: none;">{{translate('Delivery Fee:')}}</dt>
                <dd class="col-4" style="display: none;">
                    @if($order['order_type']=='take_away')
                        @php($del_c=0)
                    @else
                        @php($del_c=$order['delivery_charge'])
                    @endif
                    {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                </dd>

                {{-- <div class="col-12">
                    <hr style="margin: 0px 0px 15px 0px;"/>
                </div> --}}

                <?php $total = $subtotal+$total_tax + $add_ons_tax_cost-$order['coupon_discount_amount']-$order['extra_discount']+$del_c+$order['packing_fee'] ?>
                {{-- <dt class="col-8"><b>{{translate('Total')}}:</b></dt>
                <dd class="col-4"><b>{{ \App\CentralLogics\Helpers::set_symbol($total) }}</b></dd> --}}

                <dt class="col-8">{{translate('round_off')}}:</dt>
                <dd class="col-4">
                    <?php 
                        $round_off = round($total) - $total; 
                        if($round_off > 0) {
                            echo \App\CentralLogics\Helpers::set_symbol($round_off);
                        } else {
                            echo "- ".\App\CentralLogics\Helpers::set_symbol(str_replace("-","",$round_off));
                        }   
                    ?>
                    {{-- {{ \App\CentralLogics\Helpers::set_symbol(round($total) - $total) }} --}}
                </dd>

                <div class="col-12">
                    <hr style="margin: 10px 0px 15px 0px;"/>
                </div>

                <dt class="col-8" style="font-weight: bold;"><h4>{{translate('Total')}}:</h4></dt>
                <dd class="col-4" style="font-weight: bold;"><h4>{{ \App\CentralLogics\Helpers::set_symbol(round($total)) }}</h4></dd>
            </dl>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-between border-top">
        <span>{{translate('Paid_by')}}: <span style="font-weight:bold">{{ translate($order->payment_method)}}</span></span>
    </div>
    {{-- <span>------------------------------------------</span> --}}
    <div style="border:1px dashed gray"></div>
    <h5 class="text-center pt-3">
        """{{translate('THANK YOU')}}"""
    </h5>
    {{-- <span>------------------------------------------</span> --}}
    <div style="border:1px dashed gray"></div>
</div>
