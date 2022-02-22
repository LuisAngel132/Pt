<?php

namespace App\Http\Controllers\Cart;

use DB;
use Redirect;
use App\Models\Cart;
use App\Models\Lang;
use App\Models\User;
use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{
    protected $user;
    protected $cart;
    protected $lang;

    /**
     * __construct
     */
    public function __construct(User $user, Cart $cart, Lang $lang, Customer $customer)
    {
        $this->user     = $user;
        $this->cart     = $cart;
        $this->lang     = $lang;
        $this->customer = $customer;
        $this->redirect = Redirect::to('cart');
    }

    /**
     * Gets the session language.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     \Illuminate\Http\Request  The session language.
     */
    public function getSessionLang(Request $request)
    {
        //$data = $request->session()->all();
        if ($request->session()->has('lang')) {
            $iso_code = $request->session()->get('lang'); // si existe imprime el valor de la variable mensaje
            return $this->lang->where('iso_code', $iso_code)->first();
        } else {
            return $this->lang->where('iso_code', 'es')->first();
        }
    }

    public function summaryPaypal(Request $request)
    {
        $request->all();
        $lang       = $this->getSessionLang($request);
        $tokenLogin = $this->getTokenLogin($request);
        $envio      = "0.00";
        $method     = "paypal";
        $currency   = $lang->currency_code;
        if ($request->is_billable == "true") {
            $is_billable = true;
        } else {
            $is_billable = false;
        }
        $payment_method_id    = $request->payment_method_id;
        $addresses_id         = $request->address;
        $origin               = "web";
        $paypal_trasaction_id = $request->data['id'];
        $amount               = $request->total;
        $codes_id             = $this->getSessionCode($request);
        $shipping_amount      = strval($envio);
        $products             = $this->getCart($request);
        $fees                 = $this->getSessionFees($request);
        $gift_message         = $this->getSessionGiftmessages($request);
        if (!$codes_id) {
            if ($fees) {
                if ($gift_message) {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'shipping_amount', 'products', 'fees', 'gift_message')]);
                } else {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'shipping_amount', 'products', 'fees')]);
                }
            } else {
                config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'shipping_amount', 'products')]);
            }
        } else {
            if ($fees) {
                if ($gift_message) {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'codes_id', 'shipping_amount', 'products', 'fees', 'gift_message')]);
                } else {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'codes_id', 'shipping_amount', 'products', 'fees')]);
                }
            } else {
                config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'paypal_trasaction_id', 'amount', 'origin', 'codes_id', 'shipping_amount', 'products')]);
            }
        }
        $json = config('paymentopenpay');
        \Log::notice(config('paymentopenpay'));
        $client = new Client([
        ]);
        $r = $client->request('POST', config('constants.BASE_URL') . '/v1/orders', [
            'headers'     => [
                'Authorization'   => 'Bearer ' . $tokenLogin,
                'Accept'          => 'application/json',
                'Accept-Language' => $lang->iso_code,
            ],
            'json'        => config('paymentopenpay'),
            'http_errors' => false,
        ]);
        $data     = $r->getBody();
        $response = json_decode($data, true);

        try {
            if ($response['type'] == "success") {
                $order_id     = $response['data']['order_id'];
                $order        = Order::where('order_id', $order_id)->first();
                $deletCarrito = $this->deleteCart($products, $request);
                $order_id     = $response['data']['order_id'];
                $order        = Order::where('order_id', $order_id)->first();
                $data         = [
                    'status'  => "success",
                    'message' => trans('lang.alert_seccess_order'),
                    'order'   => $order->id,
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'status'  => "error",
                    'message' => trans('lang.alert_error_order'),
                ];
                return response()->json($data, 500);
            }
        } catch (Exception $e) {
            $data = [
                'status'  => "error",
                'message' => trans('lang.alert_error_order'),
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * delete Cart
     *
     * @param      <type>  $products  The products
     */
    public function deleteCart($products, $request)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customer->where('users_id', Auth::id())->first();
            $cart     = $this->cart->where('customers_id', $customer->id)->get();
            foreach ($cart as $value) {
                $cartDel = Cart::find($value->id);
                $cartDel->delete();
            }
            \Session::put('cost', 0.00);
            \Session::put('descuento', 0.00);
            $request->session()->forget('cupon');
            $request->session()->forget('envio');
            $request->session()->forget('subtotal');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Gets the token login.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     <type>                    The token login.
     */
    public function getTokenLogin(Request $request)
    {
        return $request->session()->get('token');
    }

    /**
     * Gets the session code.
     *
     * @param      \Illuminate\Http\Request         $request  The request
     *
     * @return     \Illuminate\Http\Request|string  The session code.
     */
    public function getSessionCode(Request $request)
    {
        if ($request->session()->has('cupon')) {
            return $code = $request->session()->get('cupon');
        } else {
            return "";
        }
    }

    /**
     * Gets the session fees.
     *
     * @param      \Illuminate\Http\Request         $request  The request
     *
     * @return     \Illuminate\Http\Request|string  The session fees.
     */
    public function getSessionFees(Request $request)
    {
        $fess = [];
        if ($request->session()->has('cost_id')) {
            $cost = $request->session()->get('cost_id');
            foreach ($cost as $value) {
                $fees[] = [

                    "id"       => $value,
                    "quantity" => 1,
                ];
            }
            return $fees;
        } else {
            return "";
        }
    }

/**
 * Gets the session giftmessages.
 *
 * @param      \Illuminate\Http\Request         $request  The request
 *
 * @return     \Illuminate\Http\Request|string  The session giftmessages.
 */
    public function getSessionGiftmessages(Request $request)
    {
        if ($request->session()->has('gift_messages')) {
            return $gift = $request->session()->get('gift_messages');
        } else {
            return "";
        }
    }

    /**
     * Gets the user.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The user.
     */
    public function getUser(Request $request)
    {
        //$data = $request->session()->all();
        $user_id = Auth::id();
        if ($request->session()->has('user_log')) {
            $user_log = $request->session()->get('user_log'); // si existe imprime el valor de la variable mensaje
            return $this->user->where('id', $user_id)->first();
        } else {
            \Session::put('user_log', $user_id);
            return $this->user->where('id', $user_id)->first();
        }
    }

    /**
     * Gets the total send.
     * @param      \Illuminate\Http\Request        $request  The request
     * @return     \Illuminate\Http\Request|float  The total send.
     */
    public function getTotalSend(Request $request)
    {

        if ($request->session()->has('envio')) {
            $envio = $request->session()->get('envio'); // si existe imprime el valor de la variable
        } else {
            $envio = 0.00;
        }

        return $envio;
    }

    public function getCart(Request $request)
    {
        $products = [];
        $customer = $this->customer->where('users_id', Auth::id())->first();
        $cart     = $this->cart->where('customers_id', $customer->id)->get();
        foreach ($cart as $value) {
            $products[] = [
                "id"        => $value->products_id,
                "sizes_id"  => $value->sizes_id,
                "colors_id" => $value->colors_id,
                "quantity"  => $value->qty,
            ];
        }
        return $products;
    }
}
