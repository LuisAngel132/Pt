<?php

namespace App\Http\Controllers\Cart;

use DB;
use Redirect;
use Validator;
use App\Models\Cart;
use App\Models\Lang;
use App\Models\User;
use App\Models\Order;
use GuzzleHttp\Client;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AddressTypeTranslation;

/**
 * Controls the data flow into a summary object and updates the view whenever data changes.
 */
class SummaryController extends Controller
{

    protected $user;
    protected $cart;
    protected $lang;
    protected $address;
    protected $customer;
    protected $customerAddress;
    protected $addressTypeTranslation;
    /**
     * __construct
     */
    public function __construct(User $user, Cart $cart, Lang $lang, Customer $customer, AddressTypeTranslation $addressTypeTranslation, CustomerAddress $customerAddress, Address $address)
    {
        $this->user                   = $user;
        $this->cart                   = $cart;
        $this->lang                   = $lang;
        $this->address                = $address;
        $this->customer               = $customer;
        $this->customerAddress        = $customerAddress;
        $this->addressTypeTranslation = $addressTypeTranslation;
        $this->redirect               = Redirect::to('cart');
    }

    /**
     * Gets the descount.
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function getDescount(Request $request)
    {
        if ($request->ajax()) {
            if ($request->session()->has('descuento')) {
                return $descuento = $request->session()->get('descuento'); // si existe imprime el valor de la variable
            } else {
                \Session::put('descuento', 0.00);
                return $descuento = $request->session()->get('descuento');
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the envio.
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function getEnvio(Request $request)
    {
        if ($request->ajax()) {
            if ($request->session()->has('envio')) {
                return $envio = $request->session()->get('envio'); // si existe imprime el valor de la variable
            } else {
                \Session::put('envio', 0.00);
                return $envio = $request->session()->get('envio');
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the gift.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     \Illuminate\Http\Request  The gift.
     */
    public function getGift(Request $request)
    {
        if ($request->ajax()) {
            if ($request->session()->has('cost')) {
                return $cost = $request->session()->get('cost'); // si existe imprime el valor de la variable
            } else {
                \Session::put('cost', 0.00);
                return $cost = $request->session()->get('cost');
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the total.
     * @param      \Illuminate\Http\Request          $request  The request
     * @return     \Illuminate\Http\Request|integer  The total.
     */
    /*public function getTotal(Request $request) {
    if ($request->ajax()) {
    $envio = 0;
    $descuento = 0;
    $cost = 0;
    $totalCart = 0;
    $total = 0;
    if ($request->session()->has('envio')) {
    $envio = $request->session()->get('envio'); // si existe imprime el valor de la variable
    }
    if ($request->session()->has('descuento')) {
    $descuento = $request->session()->get('descuento'); // si existe imprime el valor de la variable
    }
    if ($request->session()->has('subtotal')) {
    $total = $request->session()->get('subtotal');
    }
    if ($request->session()->has('cost')) {
    $cost = $request->session()->get('cost'); // si existe imprime el valor de la variable
    }

    $totalCart = ($total + $envio + $cost - $descuento);
    return $totalCart;
    } else {
    return $this->redirect;
    }
    }*/

    /**
     * generate Order
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function neworderAddress(Request $request)
    {
        return $request->all();
        if ($request->ajax()) {
            try {
                $mensajes = "";
                $request->all();
                DB::beginTransaction();
                $validator = Validator::make($request->all(), [
                    'country'         => 'required|string',
                    'state'           => 'required|string',
                    'city'            => 'required|string',
                    'street'          => 'required|string',
                    'exterior_number' => 'required|integer|min:1',
                    'zipcode'         => 'required|integer',
                    'description'     => 'required|string',
                    'address_types'   => 'required|integer',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    foreach ($errors->all() as $key => $value) {
                        $mensajes = $mensajes . $value . "\n";
                    }
                    $data = [
                        'message' => $mensajes,
                        'status'  => 'warning',
                    ];
                    return response()->json($data, 200);
                } else {
                    if ($request->interior_number) {
                        $validator_interior_number = Validator::make($request->all(), [
                            'interior_number' => 'integer|min:1',
                        ]);
                        if ($validator_interior_number->fails()) {
                            $errors = $validator_interior_number->errors();
                            foreach ($errors->all() as $key => $value) {
                                $mensajes = $mensajes . $value . "\n";
                            }
                            $data = [
                                'message' => $mensajes,
                                'status'  => 'warning',
                            ];
                            return response()->json($data, 200);
                        }
                    }
                    $user            = $this->getUser($request);
                    $customer        = $this->customer->where('users_id', $user->id)->first();
                    $address         = $this->address->create($request->all());
                    $customerAddress = $this->customerAddress->create([
                        'addresses_id'     => $address->id,
                        'customers_id'     => $customer->id,
                        'address_types_id' => $request->address_types,
                    ]);
                }
                DB::commit();
                $data = [
                    'message' => trans('lang.summary_alert_success_address_new'),
                    'status'  => 'success',
                ];
                return response()->json($data, 200);
            } catch (Exception $e) {
                DB::rollback();
                $data = [
                    'message' => trans('lang.summary_alert_error_address_new'),
                    'status'  => 'error',
                ];
                return response()->json($data, 200);
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * summary
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function summary(Request $request)
    {
        if ($request->ajax()) {

            $lang       = $this->getSessionLang($request);
            $tokenLogin = $this->getTokenLogin($request);
            $method     = "store";
            $currency   = $lang->currency_code;
            if ($request->is_billable == "true") {
                $is_billable = true;
            } else {
                $is_billable = false;
            }
            $payment_method_id = 3;
            $addresses_id      = $request->address;
            $description       = $request->detail;
            $origin            = "web";
            $codes_id          = $this->getSessionCode($request);
            $shipping_amount   = strval($this->getTotalSend($request));
            $products          = $this->getCart($request);
            $fees              = $this->getSessionFees($request);
            $gift_message      = $this->getSessionGiftmessages($request);
            if (!$codes_id) {
                if ($fees) {
                    if ($gift_message) {
                        config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'shipping_amount', 'products', 'fees', 'gift_message')]);
                    } else {
                        config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'shipping_amount', 'products', 'fees')]);
                    }
                } else {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'shipping_amount', 'products')]);
                }
            } else {
                if ($fees) {
                    if ($gift_message) {
                        config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'codes_id', 'shipping_amount', 'products', 'fees', 'gift_message')]);
                    } else {
                        config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'codes_id', 'shipping_amount', 'products', 'fees')]);
                    }
                } else {
                    config(['paymentopenpay' => compact('method', 'currency', 'is_billable', 'payment_method_id', 'addresses_id', 'origin', 'description', 'codes_id', 'shipping_amount', 'products')]);
                }
            }

            $json = config('paymentopenpay');
            \Log::notice(config('paymentopenpay'));
            $client = new Client([
            ]);
            $r = $client->request('POST', config('constants.BASE_URL') . config('constants.ORDERS'), [
                'headers'     => [
                    'Authorization' => 'Bearer ' . $tokenLogin,
                    'Accept'        => 'application/json',
                ],
                'json'        => config('paymentopenpay'),
                'http_errors' => false,
            ]);
            $data     = $r->getBody();
            $response = json_decode($data, true);
            if ($response['type'] == "success") {
                $order        = $this->getOrder($response);
                $deletCarrito = $this->deleteCart($products, $request);
                $data         = [
                    'status'  => "success",
                    'message' => trans('lang.alert_seccess_order'),
                    'order'   => $order,
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'status'  => "error",
                    'message' => trans('lang.alert_error_order'),
                ];
                return response()->json($data, 500);
            }

            try {
                $response = $client->send($request);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                echo 'Caught response: ' . $e->getResponse()->getStatusCode();
            }

        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the order.
     * @param      $response  The response
     * @return     The order.
     */
    public function getOrder($response)
    {
        $order_id = $response['data']['order_id'];
        $order    = Order::where('order_id', $order_id)->first();
        return $order->id;
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

    /**
     * Gets the session code.
     * @param      \Illuminate\Http\Request         $request  The request
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
     * @param      \Illuminate\Http\Request         $request  The request
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
     *
     * @param      \Illuminate\Http\Request        $request  The request
     *
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

    public function getCard(Request $request)
    {
        $tokenLogin = $this->getTokenLogin($request);
        $client     = new Client([
        ]);
        $r = $client->request('GET', config('constants.BASE_URL') . config('constants.PAYMENTS_CARDS'), [
            'headers'     => [
                'Authorization' => 'Bearer ' . $tokenLogin,
                'Accept'        => 'application/json',
            ],
            'json'        => config('paymentopenpay'),
            'http_errors' => false,
        ]);
        $data     = $r->getBody();
        $response = json_decode($data, true);
        return $response['data'];
    }

};
