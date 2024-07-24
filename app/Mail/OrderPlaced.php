<?php

namespace App\Mail;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\Helpers;
use App\Model\BusinessSetting;
use App\Models\EmailTemplate;
use App\Model\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_id = $this->order_id;
       
        $order=Order::where('id', $order_id)->first();
        $company_name = BusinessSetting::where('key', 'restaurant_name')->first()->value;
        
        $data=EmailTemplate::with('translations')->where('type','user')->where('email_type', 'new_order')->first();
        
        $socialMediaData = DB::table('social_medias')->get();
        //  $data= EmailTemplate::with('translations')->where('type','user')->where('email_type', 'forget_password')->first();
        
        $template=$data?$data->email_template:3;
        
        $user_name = $order->customer->f_name.' '.$order->customer->l_name;
        
        $restaurant_name = $order->branch->name;
        
        $delivery_man_name = ($order->delivery_man) ? $order->delivery_man->f_name.' '.$order->delivery_man->l_name : "test";
        
        $local = $order->customer->language_code ?? 'en';

        $content = [
            'title' => $data->title,
            'body' => $data->body,
            'footer_text' => $data->footer_text,
            'copyright_text' => $data->copyright_text
        ];
        
        if ($local != 'en'){
            if (isset($data->translations)){
                foreach ($data->translations as $translation){
                    if ($local == $translation->locale){
                        $content[$translation->key] = $translation->value;
                    }
                }
            }
        }
        $url = '';

        $title = Helpers::text_variable_data_format( value:$data['title']??'',user_name:$user_name??'',restaurant_name:$restaurant_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        
        $body = Helpers::text_variable_data_format( value:$data['body']??'',user_name:$user_name??'',restaurant_name:$restaurant_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');

        if($body == $data['body'] && $user_name != ''){
            $body = "<p>Hello ".$user_name.",</p>";
          //  $body = "<p>Hello ".$user_name.",</p><br/><p>&nbsp;</p>";
        }
        
        $footer_text = Helpers::text_variable_data_format( value:$data['footer_text']??'',user_name:$user_name??'',restaurant_name:$restaurant_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        
        $copyright_text = Helpers::text_variable_data_format( value:$data['copyright_text']??'',user_name:$user_name??'',restaurant_name:$restaurant_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        
       // $this->subject(translate('Order_Place_Mail'))
        $this->subject(translate('Your_Tasty_Thrust_order_has_been_placed'))
        ->view('email-templates.new-email-format-' . $template, [
        'company_name' => $company_name,
        'data' => $data,
        'socialMediaData' => $socialMediaData,
        'title' => $title,
        'body' => $body,
        'footer_text' => $footer_text,
        'copyright_text' => $copyright_text,
        'order' => $order
        ]);
       
    }
}
