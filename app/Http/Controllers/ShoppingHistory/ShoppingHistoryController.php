<?php

namespace App\Http\Controllers\ShoppingHistory;

use DB;
use Auth;
use Mail;
use Redirect;
use App\Models\Lang;
use App\Models\Order;
use App\Models\Design;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Models\Session;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Models\ProductsDesign;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ShoppingHistoryController extends Controller
{

    protected $customer;
    protected $order;
    protected $lang;
    protected $productColor;
    protected $design;
    protected $product;
    protected $productsDesign;
    protected $productTranslation;

    public function __construct(Customer $customer, Order $order, Lang $lang, ProductsColor $productColor, ProductTranslation $productTranslation, Product $product, Design $design, ProductsDesign $productsDesign)
    {
        $this->customer           = $customer;
        $this->order              = $order;
        $this->lang               = $lang;
        $this->productColor       = $productColor;
        $this->design             = $design;
        $this->product            = $product;
        $this->productsDesign     = $productsDesign;
        $this->productTranslation = $productTranslation;
        $this->redirect           = Redirect::to('shopping-history');
    }

    /**
     * Gets the token login.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     <type>                    The token login.
     */
    public function getToken(Request $request)
    {
        return $request->session()->get('token');
    }

    /**
     * Gets the session language.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The session language.
     */
    public function getLang(Request $request)
    {

        if ($request->session()->has('lang')) {
            return $request->session()->get('lang');
        } else {
            return 'es';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->all();
        $id       = Auth::id();
        $iso_code = $this->getLang($request);
        $lang     = $this->lang->where('iso_code', $iso_code)->first();
        $customer = $this->customer->where('users_id', $id)->first();
        $currency = $lang->currency_code;

        if ($request->id) {
            $orders = $this->order->with(
                ['orderStatus.orderStatusTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                    'giftMessages',
                    'invoices',
                    'shipments',
                    'orderProducts',
                ])
                ->where('customers_id', $customer->id)
                ->where('order_status_id', $request->id)
                ->orderByRaw('created_at DESC')
                ->paginate(6);
        } else {
            $orders = $this->order->with(
                ['orderStatus.orderStatusTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
                    'giftMessages',
                    'invoices',
                    'shipments',
                    'orderProducts',
                ])
                ->where('customers_id', $customer->id)
                ->orderByRaw('created_at DESC')
                ->paginate(6);
        }

        $productsColor = $this->productColor->with('resources.galleries')->get();

        $token  = $this->getToken($request);
        $client = new Client([]);
        $query  = $client->request('GET', config('constants.BASE_URL') . config('constants.RESOURCES_ORDER_STATUS'), [
            'headers' => [
                'Authorization'   => 'Bearer ' . $token,
                'Accept-Language' => $iso_code,
            ],
        ]);
        $data         = $query->getBody();
        $order_status = json_decode($data, true);

        return view('shoppinghistory.shopping-history', ['orders' => $orders, 'currency' => $currency, 'productsColor' => $productsColor, 'order_status' => $order_status]);
    }

    public function getData(Request $request)
    {
        $token    = $this->getToken($request);
        $iso_code = $this->getLang($request);
        $client   = new Client([]);
        $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS'), [
            'headers' => [
                'Authorization'   => 'Bearer ' . $token,
                'Accept-Language' => $iso_code,
            ],
        ]);

        $data            = $query->getBody();
        return $response = json_decode($data, true);
    }

    /**
     * Posts a cancel.
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function postCancel(Request $request)
    {

        $token = \Session::get('token');
        \Log::info($array = [
            'shopping_history_token' => $token,
        ]);

        try {
            DB::beginTransaction();
            $request->all();
            $iso_code = $this->getLang($request);
            $email    = Auth::user()->email;

            $date = date("Y-m-d");
            $data = [
                'order_id' => $request->id_order,
                'reason'   => $request->reason,
                'email'    => $email,
                'date'     => $date,
            ];

            Mail::send('mailview.cancel', $data, function ($mail) use ($data) {
                $mail->from('cliente@mail.com');
                $mail->to('arizbeth.ibarra@sgti.com.mx');
                $mail->subject('Cancelación de la orden: ' . $data['order_id']);
            });

            // $token = $this->getToken($request);
            //
            \Log::info($array = [
                'shopping_history_reason' => $request->reason,
            ]);

            $client = new Client([]);
            $query  = $client->request('POST', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->id . '/cancel', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json'    => [
                    'reason' => $request->reason,
                ],
            ]);

            $data     = $query->getBody();
            $status   = $query->getStatusCode();
            $response = json_decode($data, true);

            DB::commit();
            if ($status == 200 && $iso_code == 'es') {
                return back()->with('success', '¡El proceso de cancelación ha sido iniciado con éxito!');
            } else if ($status == 200 && $iso_code == 'en') {
                return back()->with('success', '¡The cancellation process has been initiated successfully!');
            } else if ($status != 200 && $iso_code == 'es') {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            } else if ($status != 200 && $iso_code == 'en') {
                return back()->with('error', '¡Something went wrong, try again!');
            } else {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            }

        } catch (Exception $e) {
            DB::rollback();
            if ($iso_code == 'es') {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            } else if ($iso_code == 'en') {
                return back()->with('error', '¡Something went wrong, try again!');
            }

        }

    }

    /**
     * Posts a devolution.
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function postDevolution(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->all();
            $iso_code       = $this->getLang($request);
            $email          = Auth::user()->email;
            $products_ids[] = $request->products;

            $date = date("Y-m-d");
            $data = [
                'order_id' => $request->id_order,
                'reason'   => $request->reason,
                'email'    => $email,
                'date'     => $date,
            ];

            Mail::send('mailview.devolution', $data, function ($mail) use ($data) {
                $mail->from('cliente@mail.com');
                $mail->to('arizbeth.ibarra@sgti.com.mx');
                $mail->subject('Devolución de la orden: ' . $data['order_id']);
            });

            $token  = $this->getToken($request);
            $client = new Client([]);
            $query  = $client->request('POST', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->id . '/refund', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'json'    => [
                    'reason'       => $request->reason,
                    'products_ids' => $products_ids,
                ],
            ]);

            $data     = $query->getBody();
            $status   = $query->getStatusCode();
            $response = json_decode($data, true);
            DB::commit();
            if ($status == 200 && $iso_code == 'es') {
                return back()->with('success', '¡El proceso de devolución ha sido iniciado con éxito!');
            } else if ($status == 200 && $iso_code == 'en') {
                return back()->with('success', '¡The return process has been successfully initiated!');
            } else if ($status != 200 && $iso_code == 'es') {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            } else if ($status != 200 && $iso_code == 'en') {
                return back()->with('error', '¡Something went wrong, try again!');
            } else {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            }

        } catch (Exception $e) {
            DB::rollback();
            if ($iso_code == 'es') {
                return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
            } else if ($iso_code == 'en') {
                return back()->with('error', '¡Something went wrong, try again!');
            }
        }
    }

    /**
     * Gets the products.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The products.
     */
    public function getProducts(Request $request)
    {
        try {
            $token    = $this->getToken($request);
            $iso_code = $this->getLang($request);
            $client   = new Client([]);
            $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->id . '', [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $iso_code,
                ],
            ]);

            $data     = $query->getBody();
            $response = json_decode($data, true);
            \Log::notice($response['data']);
            return $response;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Gets the reference.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The reference.
     */
    public function getReference(Request $request)
    {
        if ($request->ajax()) {
            try {
                $token    = $this->getToken($request);
                $iso_code = $this->getLang($request);
                $client   = new Client([]);
                $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->id . '', [
                    'headers' => [
                        'Authorization'   => 'Bearer ' . $token,
                        'Accept-Language' => $iso_code,
                    ],
                ]);

                $data      = $query->getBody();
                $response  = json_decode($data, true);
                $reference = $response['data']['voucher_url'];
                return view('shoppinghistory.view-reference', ['reference' => $reference]);
            } catch (Exception $e) {
                return $e;
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the detail.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The detail.
     */
    public function getDetail(Request $request)
    {
        try {
            $request->all();
            $id       = Auth::id();
            $customer = $this->customer->where('users_id', $id)->first();
            $order    = $this->order->where('id', $request->reference)->where('customers_id', $customer->id)->first();
            if ($order) {
                $quantity = 0;
                $token    = $this->getToken($request);
                $iso_code = $this->getLang($request);
                $client   = new Client([]);
                $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->reference . '', [
                    'headers' => [
                        'Authorization'   => 'Bearer ' . $token,
                        'Accept-Language' => $iso_code,
                    ],
                ]);
                $data     = $query->getBody();
                $response = json_decode($data, true);
                //\Log::notice($response);
                if ($response['type'] == 'success') {
                    \Log::notice($response);
                    $order_id = $response['data']['order_id'];
                    $method   = $response['data']['order_payments']['translations'][0]['pivot']['method'];
                    $order    = $response['data']['products'];
                    foreach ($order as $key => $value) {
                        $quantity += $value['qty'];
                    }
                    $address = $response['data']['shipments'][0];

                    $lang     = $this->lang->where('iso_code', $iso_code)->first();
                    $currency = $lang->currency_code;
                    return view('shoppinghistory.view-detail', ['method' => $method, 'order' => $order, 'address' => $address, 'response' => $response, 'currency' => $currency, 'quantity' => $quantity, 'order_id' => $order_id]);
                } else {
                    return $this->redirect;
                }
            } else {
                return $this->redirect;
            }
        } catch (Exception $e) {
            return $this->redirect;
        }

    }

    /**
     * Gets the resource.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The resource.
     */
    public function getResource(Request $request)
    {
        try {
            $request->all();
            $token    = $this->getToken($request);
            $iso_code = $this->getLang($request);
            $client   = new Client([]);
            $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $request->order_id . '', [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $iso_code,
                ],
            ]);

            $data     = $query->getBody();
            $response = json_decode($data, true);
            $products = $response['data']['products'];
            foreach ($products as $key => $product) {
                if ($request->product_id == $product['id']) {
                    return $product;
                }
            }

        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Gets the session language.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The session language.
     */
    public function getSessionLang(Request $request)
    {
        $data = $request->session()->all();
        if ($request->session()->has('lang')) {
            $iso_code = $request->session()->get('lang'); // si existe imprime el valor de la variable mensaje
            return $this->lang->where('iso_code', $iso_code)->first();
        } else {
            return $this->lang->where('iso_code', 'es')->first();
        }
    }

    /**
     * detailProduct
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function detailProduct(Request $request)
    {

        $lang = $this->getSessionLang($request);
        $id   = Auth::id();
        if ($id == "") {
            $products = $this->productsDesign->with([
                'products.productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                }, 'products.productsColors.colors',
            ])
                ->where('designs_id', $request->id)
                ->whereHas('products.productsColors.resources', function ($query) use ($request) {
                    $query->where('is_active', true);
                })->get();
            /**
             * return View
             */
            return view('shoppinghistory.view-detail-product', compact('products', 'id'));
        } else {
            $customer = $this->customer->where('users_id', $id)->first();
            $products = $this->productsDesign->with([
                'products.productTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                }, 'products.productsColors.colors',
                'products.customerLikes'       => function ($query) use ($customer) {
                    $query->where('customers_id', $customer->id);
                },
            ])
                ->where('designs_id', $request->id)
                ->whereHas('products.productsColors.resources', function ($query) use ($request) {
                    $query->where('is_active', true);
                })->get();
            /**
             * return View
             */
            return view('shoppinghistory.view-detail-product', compact('products', 'id'));
        }

    }

    /**
     * Gets the traking.
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function getTraking(Request $request)
    {
        try {
            $request->all();
            $id       = Auth::id();
            $customer = $this->customer->where('users_id', $id)->first();
            $order    = $this->order->where('id', $request->reference)->where('customers_id', $customer->id)->first();
            if ($order) {
                $token    = $this->getToken($request);
                $iso_code = $this->getLang($request);
                $id       = $request->reference;

                $client = new Client([]);
                $query  = $client->request('GET', config('constants.BASE_URL') . config('constants.ORDERS') . '/' . $id . '', [
                    'headers' => [
                        'Authorization'   => 'Bearer ' . $token,
                        'Accept-Language' => $iso_code,
                    ],
                ]);
                $data        = $query->getBody();
                $response    = json_decode($data, true);
                $tracking_id = $response['data']['shipments'][0]['tracking_id'];

                $request_traking  = new Client([]);
                $query_traking    = $request_traking->request('GET', 'https://www.logistics.dhl/shipmentTracking?AWB=' . $tracking_id . '&countryCode=MX&languageCode=es');
                $data_traking     = $query_traking->getBody();
                $response_traking = json_decode($data_traking, true);
                info($data_traking);
                //$reference = $reponse['data']['tracking']['reference'];

                /*$dataTraking = '{
                "results" : [ {
                "id" : "7480379325",
                "label" : "Guía Aérea",
                "type" : "airwaybill",
                "duplicate" : false,
                "delivery" : {
                "code" : "101",
                "status" : "delivered"
                },
                "origin" : {
                "value" : "TORREON - TORREON - MEXICO",
                "label" : "Área de Servicio de Origen",
                "url" : "http://www.dhl.com.mx/en/country_profile.html"
                },
                "destination" : {
                "value" : "TORREON - GOMEZ PALACIO - MEXICO",
                "label" : "Área de Servicio de Destino",
                "url" : "http://www.dhl.com.mx/en/country_profile.html"
                },
                "description" : "Firmado por: VERONICA RUELAS Miércoles, Octubre 24, 2018  EN 11:52",
                "hasDuplicateShipment" : false,
                "signature" : {
                "link" : {
                "url" : "https://webpod.dhl.com/webPOD/DHLePODRequest?hwb=6sFfJukhUV7vDgwI2atuFg%3D%3D&pudate=X59legyu5YNi8CxEtcRD%2Bg%3D%3D&appuid=A3huFuQzEiEqGGUibegV7w%3D%3D&language=es&country=MX",
                "label" : "Obtener Prueba de entrega con firma"
                },
                "type" : "epod",
                "description" : "Miércoles, Octubre 24, 2018  EN 11:52",
                "signatory" : "VERONICA RUELAS",
                "label" : "Firmado por",
                "help" : "help"
                },
                "pieces" : {
                "value" : 1,
                "label" : "Pieza",
                "showSummary" : true,
                "pIds" : [ "JD014600006109724480" ]
                },
                "checkpoints" : [ {
                "counter" : 7,
                "description" : "Envío entregado - Firmado por: VERONICA RUELAS",
                "time" : "11:52",
                "date" : "Miércoles, Octubre 24, 2018 ",
                "location" : "GOMEZ PALACIO                      ",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 6,
                "description" : "Envío en ruta de entrega.",
                "time" : "09:15",
                "date" : "Miércoles, Octubre 24, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 5,
                "description" : "Destinatario ausente.",
                "time" : "17:32",
                "date" : "Martes, Octubre 23, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 4,
                "description" : "Envío en ruta de entrega.",
                "time" : "15:13",
                "date" : "Martes, Octubre 23, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 3,
                "description" : "Dirección de entrega incorrecta. Por favor contacte a DHL.",
                "time" : "16:53",
                "date" : "Viernes, Octubre 19, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 2,
                "description" : "Envío en ruta de entrega.",
                "time" : "15:18",
                "date" : "Viernes, Octubre 19, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                }, {
                "counter" : 1,
                "description" : "Envío retirado/recolectado.",
                "time" : "16:55",
                "date" : "Jueves, Octubre 18, 2018 ",
                "location" : "TORREON - MEXICO",
                "totalPieces" : 1,
                "pIds" : [ "JD014600006109724480" ]
                } ],
                "checkpointLocationLabel" : "Ubicación",
                "checkpointTimeLabel" : "Hora"
                } ]
                }';*/

                $responseTraking = json_decode($dataTraking, true);
                $reference       = $responseTraking['results'][0]['id'];
                $traking         = $responseTraking['results'][0]['checkpoints'];

                return view('shoppinghistory.view-traking', compact('reference', 'traking'));
            } else {
                return $this->redirect;
            }
        } catch (Exception $e) {
            return $this->redirect;
        }
    }
}
