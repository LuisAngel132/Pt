<?php
namespace App\Http\Controllers\Cart;

use DB;
use Redirect;
use Validator;
use App\Models\Cart;
use App\Models\Code;
use App\Models\Lang;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomersCode;
use App\Models\ProductsColor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Controls the data flow into a coupon object and updates the view whenever data changes.
 */
class CouponController extends Controller
{
    protected $lang;
    protected $user;
    protected $cart;
    protected $code;
    protected $customers;
    protected $customersCode;

    /**
     * __construct
     *
     * @param      \App\Models\User           $user           The user
     * @param      \App\Models\Cart           $cart           The cartesian
     * @param      \App\Models\Lang           $lang           The language
     * @param      \App\Models\Code           $code           The code
     * @param      \App\Models\Customer       $customer       The customer
     * @param      \App\Models\CustomersCode  $customersCode  The customers code
     */
    public function __construct(User $user, Cart $cart, Lang $lang, Code $code, Customer $customers, CustomersCode $customersCode, ProductsColor $productsColor)
    {
        $this->user          = $user;
        $this->cart          = $cart;
        $this->lang          = $lang;
        $this->code          = $code;
        $this->productsColor = $productsColor;
        $this->customersCode = $customersCode;
        $this->customers     = $customers;
        $this->redirect      = Redirect::to('cart');
    }

    /**
     * cupon
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function cupon(Request $request)
    {
        /*
        \Log::info('running method: cupon');
        \Log::info([
        'request' => $request->input('cupon'),
        ]); */
        if ($request->ajax()) {

            try {

                $cantProduct = 0;
                $hoy         = date('Y-m-d');
                //    return $request->session()->all();
                DB::beginTransaction();
                $validator = Validator::make($request->all(), [
                    'cupon' => 'required',
                ]);
                if ($validator->fails()) {
                    /*  \Log::info('running method: cupon failed validation');
                $data = [
                'message' => trans('lang.checkout_alert_required_coupon'),
                'status'  => 'warning',
                ]; */
                } else {
                    //   \Log::info('running method: cupon succes validation');
                    if ($request->session()->has('cupon')) {
                        /*  \Log::info([
                        'running method' => 'cupon',
                        'message'        => 'Session has cupon',
                        ]);*/
                        $data = [
                            'message' => trans('lang.checkout_alert_used_coupon'),
                            'status'  => 'warning',
                        ];
                        return response()->json($data, 200);
                    } else {
                        /*   \Log::info([
                        'running method' => 'cupon',
                        'message'        => 'Session does not have cupon',
                        ]);*/
                        $cuponArray = [];
                        $code       = $this->code->where('code', $request->input('cupon'))
                            ->where('end_date', '>=', $hoy)
                            ->first();
                        /*   \Log::info([
                        'running method' => 'cupon',
                        'message'        => 'Searching cupon',
                        'exist'          => !empty($code),
                        ]); */

                        if ($code) {

                            $user      = $this->getUser($request);
                            $customers = $this->customers->where('users_id', $user->id)->first();
                            $cart      = $this->cart->where('customers_id', $customers->id)->get();
                            foreach ($cart as $value) {
                                $cantProduct += $value->qty;
                            }
                            $cantProduct;
                            $customersCode = $this->customersCode->where('customers_id', $customers->id)
                                ->where('codes_id', $code->id)->first();
                            if ($customersCode) {
                                $data = [
                                    'message' => trans('lang.checkout_alert_error_coupon_applied'),
                                    'status'  => 'warning',
                                ];
                                return response()->json($data, 200);
                            } else {
                                $stringcode = $request->input('cupon');
                                $tokenLogin = $this->getTokenLogin($request);
                                $total      = $this->getTotal($request);

                                $lang = $this->getSessionLang($request);
                                return $this->validateCupon($stringcode, $tokenLogin, $customers, $total, $cantProduct, $lang);

                            }

                        } else {
                            $data = [
                                'message' => trans('lang.checkout_alert_error_coupon_exist'),
                                'status'  => 'warning',
                            ];
                            return response()->json($data, 200);
                        }
                    }
                }
                DB::commit();
                $data = [
                    'message' => trans('lang.checkout_alert_applied_coupon'),
                    'status'  => 'success',
                ];
                return response()->json($data, 200);
            } catch (RequestException $e) {
                DB::rollback();
                if ($e->hasResponse()) {
                    $exception = (string) $e->getResponse()->getBody();
                    $exception = json_decode($exception);
                    $data      = [
                        'message' => trans('lang.checkout_alert_error_coupon_exist'),
                        'status'  => 'warning',
                    ];
                    return response()->json($data, 200);
                    return new JsonResponse($exception, $e->getCode());
                } else {
                    $data = [
                        'message' => trans('lang.checkout_alert_error_coupon_exist'),
                        'status'  => 'warning',
                    ];
                    return response()->json($data, 200);
                    return new JsonResponse($e->getMessage(), 503);
                }
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * validateCupon
     * @param      string   $stringcode   The stringcode
     * @param      <type>   $tokenLogin   The token login
     * @param      <type>   $customers    The customers
     * @param      integer  $total        The total
     * @param      integer  $cantProduct  The can't product
     * @param      <type>   $lang         The language
     */
    public function validateCupon($stringcode, $tokenLogin, $customers, $total, $cantProduct, $lang)
    {
        \Log::info('running validateCupon');
        $mensajes = "";
        $client   = new Client([
        ]);
        $r = $client->request('GET', config('constants.BASE_URL') . config('constants.COUPONS_VALIDATE') . $stringcode . '/validate', [
            'headers' => [
                'Authorization'   => 'Bearer ' . $tokenLogin,
                'Accept-Language' => $lang->iso_code,
            ],
        ]);
        $data     = $r->getBody();
        $response = json_decode($data, true);
        \Log::info($responseCoupon = [
            'response' => $response,
        ]);
        if ($response['errors'] == true) {
            \Log::info([
                'running method' => 'validateCupon',
                'message'        => 'cupon validation with errors',
            ]);
            foreach ($response['data'] as $value) {
                $mensajes = $mensajes . $value . "\n";
            }
            $data = [
                'message' => trans($mensajes),
                'status'  => 'error',
            ];
            return response()->json($data, 200);
        } else {
            \Log::info([
                'running method' => 'validateCupon',
                'message'        => 'cupon validation without errors',
            ]);
            $apply            = $response['data']['id'];
            $descount         = $response['data']['discount_types'];
            $envio_gratis     = $descount[0]['free_shipping'];
            $producto_gratis  = $descount[0]['free_tshirts'];
            $discount_percent = $descount[0]['discount_percent'];
            $codes_id         = $response['data']['id'];
            /**
             * Envio gratis
             */
            if ($envio_gratis) {
                if ($cantProduct >= 3) {
                    \Session::put('descuento', 0.00);
                    \Session::put('envio', 0.00);
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_envio_gratis_exist'),
                        'status'    => 'warning',
                        'descuento' => 0.00,
                        'envio'     => 0.00,
                    ];
                } else if ($cantProduct >= $descount[0]['max_products']) {
                    \Session::put('descuento', 0.00);
                    \Session::put('envio', 0.00);
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_envio_gratis'),
                        'status'    => 'success',
                        'descuento' => 0.00,
                        'envio'     => 0.00,
                    ];
                    \Session::put('cupon', $apply);
                } else {
                    \Session::put('descuento', 0.00);
                    \Session::put('envio', trans('lang.amount_envio'));
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_envio_gratis_validate'),
                        'status'    => 'warning',
                        'descuento' => 0.00,
                        'envio'     => trans('lang.amount_envio'),
                    ];
                }
            } else if ($producto_gratis) {
                /*Producto gratis*/
                //return $cantProduct;
                $descuentofinal = 0;
                if ($cantProduct >= $descount[0]['max_products']) {

                    $productDisponible = intval($cantProduct / 2);
                    $productTotal      = $cantProduct - $productDisponible;

                    $carts       = $this->cart->where('customers_id', $customers->id)->get();
                    $productCart = $this->productCart($carts, $lang, $productDisponible, $cantProduct);
                    foreach ($productCart as $value) {
                        $descuentofinal += $value;
                    }
                    $descuentofinal;
                    \Session::put('descuento', $descuentofinal);

                    if ($productTotal >= 3) {
                        \Session::put('envio', 0.00);
                        $envio = 0.00;
                    } else {
                        \Session::put('envio', trans('lang.amount_envio'));
                        $envio = trans('lang.amount_envio');
                    }
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_product_gratis'),
                        'status'    => 'success',
                        'descuento' => $descuentofinal,
                        'envio'     => $envio,
                    ];
                    \Session::put('cupon', $apply);
                } else {
                    \Session::put('descuento', $descuentofinal);
                    if ($productTotal >= 3) {
                        \Session::put('envio', 0.00);
                        $envio = 0.00;
                    } else {
                        \Session::put('envio', trans('lang.amount_envio'));
                        $envio = trans('lang.amount_envio');
                    }
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_product_gratis_validate'),
                        'status'    => 'warning',
                        'descuento' => $descuentofinal,
                        'envio'     => $envio,

                    ];
                }
            } else if ($discount_percent) {
                /*porcentaje de descxuento*/
                if ($cantProduct >= $descount[0]['max_products']) {
                    $descuentofinal = ($total * $descount[0]['discount_percent']) / 100;
                    \Session::put('descuento', $descuentofinal);
                    if ($cantProduct >= 3) {
                        \Session::put('envio', 0.00);
                        $envio = 0.00;
                    } else {
                        \Session::put('envio', trans('lang.amount_envio'));
                        $envio = trans('lang.amount_envio');
                    }
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_porcentaje'),
                        'status'    => 'success',
                        'descuento' => $descuentofinal,
                        'envio'     => $envio,
                        'codes_id'  => $codes_id,
                    ];
                    \Session::put('cupon', $apply);
                    \Session::put('cuponVal', true);
                } else {
                    \Session::put('descuento', 0.00);
                    if ($cantProduct >= 3) {
                        \Session::put('envio', 0.00);
                        $envio = 0.00;
                    } else {
                        \Session::put('envio', trans('lang.amount_envio'));
                        $envio = trans('lang.amount_envio');
                    }
                    $data = [
                        'message'   => trans('lang.checkout_alert_cupon_product_gratis_validate'),
                        'status'    => 'warning',
                        'descuento' => 0.00,
                        'envio'     => $envio,
                    ];
                }
            } else {
                if ($cantProduct >= 3) {
                    \Session::put('envio', 0.00);
                    $envio = 0.00;
                } else {
                    \Session::put('envio', trans('lang.amount_envio'));
                    $envio = trans('lang.amount_envio');
                }
                \Session::put('descuento', 0.00);
                $data = [
                    'message'   => trans('lang.checkout_alert_error_coupon_exist'),
                    'status'    => 'warning',
                    'descuento' => 0.00,
                    'envio'     => $envio,
                ];

            }
            \Log::info($response);

            return response()->json($data, 200);
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
     * product Cart
     * @param      <type>         $carts              The carts
     * @param      <type>         $lang               The language
     * @param      integer        $productDisponible  The product disponible
     * @param      integer        $cantProduct        The can't product
     * @return     array|integer  price
     */
    public function productCart($carts, $lang, $productDisponible, $cantProduct)
    {
        $price = [];
        foreach ($carts as $clave => $valor) {
            $product = $this->productsColor->with([
                'products.productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                }, 'resources', 'products.productTranslations.langs'])
                ->where('colors_id', $valor->colors_id)
                ->where('products_id', $valor->products_id)->first();
            for ($i = 0; $i < $valor->qty; $i++) {
                $products[] = $product;
            }

        }
        foreach ($products as $clave => $valor) {

            $price[] = $valor->products->productTranslations[0]->price;
        }
        for ($x = 0; $x < count($price); $x++) {
            for ($y = 0; $y < count($price) - $x - 1; $y++) {
                if ($price[$y] < $price[$y + 1]) {
                    $tmp           = $price[$y + 1];
                    $price[$y + 1] = $price[$y];
                    $price[$y]     = $tmp;
                }
            }
        }
        $deleteProduc = $cantProduct - $productDisponible;
        for ($i = 0; $i < $deleteProduc; $i++) {
            unset($price[$i]);
        }
        return $price;
        \Log::info($price);
    }

    /**
     * Gets the total.
     * @param      \Illuminate\Http\Request          $request  The request
     * @return     \Illuminate\Http\Request|integer  The total.
     */
    public function getTotal(Request $request)
    {

        $envio     = 0;
        $descuento = 0;
        $cost      = 0;
        $totalCart = 0;
        $total     = 0;
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

    }

    /**
     * cuponTrue
     * @return     boolean
     */
    public function cuponTrue(Request $request)
    {
        if ($request->session()->has('cuponVal')) {
            return "true";
        } else {
            return "false";
        }
    }
}
