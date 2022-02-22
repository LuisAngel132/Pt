<?php

namespace App\Http\Controllers\Cart;

use DB;
use Auth;
use Redirect;
use App\Models\Cart;
use App\Models\Lang;
use App\Models\Size;
use App\Models\Session;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    /**
     * The user repository instance.
     */
    protected $size;
    protected $cart;
    protected $lang;
    protected $session;
    protected $customer;
    protected $productsColor;

    /**
     *
     *
     * @param      \App\Models\Session  $session  The session
     */
    public function __construct(ProductsColor $productsColor, Customer $customer, Session $session, Lang $lang, Cart $cart, Size $size)
    {
        $this->size          = $size;
        $this->cart          = $cart;
        $this->lang          = $lang;
        $this->session       = $session;
        $this->customer      = $customer;
        $this->productsColor = $productsColor;

        $this->redirect = Redirect::to('cart');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('ecommerce.cart');
    }

    /**
     * Gets the cart.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     string                    The cart.
     */
    public function getCart(Request $request)
    {
        if ($request->ajax()) {
            $request->all();
            if (Auth::check()) {
                $customer    = $this->customer->where('users_id', Auth::id())->first();
                return $cart = $this->cart->where('customers_id', $customer->id)->count();

            } else {
                $token        = $this->getToken($request);
                return $exist = $this->session->where('token', $token)->count();
            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the cart shop.
     *
     * @return     string  The cart shop.
     */
    public function getCartShop(Request $request)
    {
        if ($request->ajax()) {
            $lang     = $this->getSessionLang($request);
            $products = [];
            if (Auth::check()) {
                $customer = $this->customer->where('users_id', Auth::id())->first();
                $carts    = $this->cart->where('customers_id', $customer->id)->get();

                foreach ($carts as $clave => $valor) {

                    $product = $this->productsColor->with([
                        'products.productTranslations' => function ($query) use ($lang) {
                            $query->where('langs_id', $lang->id);
                        }, 'resources', 'products.productTranslations.langs'])
                        ->where('colors_id', $valor->colors_id)
                        ->where('products_id', $valor->products_id)->first();
                    $size       = $this->size->find($valor->sizes_id);
                    $products[] = [
                        'product' => $product,
                        'qty'     => $valor->qty,
                        'sizes'   => $size->size,
                        'id'      => $valor->id,
                    ];

                }
                $this->valSession($products);
                return $products;
            } else {
                $token = $this->getToken($request);
                $carts = $this->session->where('token', $token)->get();
                foreach ($carts as $clave => $valor) {
                    $product = $this->productsColor->with([
                        'products.productTranslations' => function ($query) use ($lang) {
                            $query->where('langs_id', $lang->id);
                        }, 'resources', 'products.productTranslations.langs'])
                        ->where('colors_id', $valor->colors_id)
                        ->where('products_id', $valor->products_id)->first();

                    $size       = $this->size->find($valor->sizes_id);
                    $products[] = [
                        'product' => $product,
                        'qty'     => $valor->qty,
                        'sizes'   => $size->size,
                        'id'      => $valor->id,
                    ];
                }
                $this->valSession($products);
                return $products;

            }
        } else {
            return $this->redirect;
        }
    }

    public function valSession($products)
    {
        $cantidad = 0;
        $envio;
        $subtotal = 0;
        foreach ($products as $key => $value) {
            $cantidad += $value['qty'];
            $subtotal += $value['product']['products']['productTranslations'][0]['price'] * $value['qty'];
        }
        if ($cantidad >= 3) {
            \Session::put('envio', 0.00);
        } else {
            \Session::put('envio', trans('lang.amount_envio'));
        }
        \Session::put('subtotal', $subtotal);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //-- This function is not working 09-10-2018 --//
    // --  if (Auth::check()){} else { this part is not working } --//
    public function store(Request $request)
    {

        $request->all();
        if ($request->ajax()) {
            $request->all();
            if (Auth::check()) {
                $customer      = $this->customer->where('users_id', Auth::id())->first();
                $productsColor = $this->productsColor->find($request->product);

                if ($request->quantity > 0) {
                    $existe = $this->cart->where('customers_id', $customer->id)
                        ->where('products_id', $productsColor->products_id)
                        ->where('sizes_id', $request->size)
                        ->where('colors_id', $productsColor->colors_id)
                        ->first();

                    if ($existe) {
                        $exist->qty += $request->quantity;
                        $exist->save();
                    } else {
                        $this->cart->create([
                            'customers_id' => $customer->id,
                            'products_id'  => $productsColor->products_id,
                            'sizes_id'     => $request->size,
                            'colors_id'    => $productsColor->colors_id,
                            'qty'          => $request->quantity,
                        ]);
                    }
                    $exist       = $this->cart->where('customers_id', $customer->id)->count();
                    return $data = [
                        'status' => 'success',
                        'cant'   => $exist,
                    ];
                } else {
                    $exist       = $this->cart->where('customers_id', $customer->id)->count();
                    return $data = [
                        'status' => 'warning',
                        'cant'   => $exist,
                    ];
                }

            } else {
                $token = $this->getToken($request);
                //return $session;
                if ($request->quantity > 0) {
                    $productsColor = $this->productsColor->find($request->product);
                    $exist         = $this->session->where('token', $token)
                        ->where('products_id', $productsColor->products_id)
                        ->where('sizes_id', $request->size)
                        ->where('colors_id', $productsColor->colors_id)
                        ->first();
                    if ($exist) {
                        $exist->quantity += $request->quantity;
                        $exist->save();
                    } else {
                        $this->session->create([
                            'token'       => $token,
                            'products_id' => $productsColor->products_id,
                            'sizes_id'    => $request->size,
                            'colors_id'   => $productsColor->colors_id,
                            'qty'         => $request->quantity,
                        ]);
                    }
                    $exist       = $this->session->where('token', $token)->count();
                    return $data = [
                        'status' => 'success',
                        'cant'   => $exist,
                    ];
                } else {
                    $exist       = $this->session->where('token', $token)->count();
                    return $data = [
                        'status' => 'warning',
                        'cant'   => $exist,
                    ];
                }

            }
        } else {
            return $this->redirect;
        }
    }

    /**
     * cart Update
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function cartUpdate(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $request->inptCant;
                if (Auth::check()) {
                    $customer = $this->customer->where('users_id', Auth::id())->first();
                    foreach ($data as $clave => $valor) {
                        $carts = $this->cart->where('customers_id', $customer->id)
                            ->where('id', $valor['id'])
                            ->first();
                        $carts->qty = $valor['cant'];
                        $carts->save();
                    }
                } else {
                    $token = $this->getToken($request);
                    foreach ($data as $clave => $valor) {
                        $carts = $this->session->where('token', $token)
                            ->where('id', $valor['id'])
                            ->first();
                        $carts->qty = $valor['cant'];
                        $carts->save();
                    }
                }
            } else {
                return $this->redirect;
            }
        } catch (Exception $e) {

        }
    }

    public function verifyStock(Request $request, $products_id, $colors_id, $sizes_id, $qty)
    {
        $lang          = $this->getSessionLang($request);
        $product_color = $this->productsColor::where([
            ['products_id', $products_id],
            ['colors_id', $colors_id],
            ['sizes_id', $sizes_id],
        ])->with(['products.productTranslations' => function ($query) use ($lang) {
            $query->where('langs_id', $lang->id);
        }])->first();
        if ($qty > $product_color->quantity) {
            return response()->json(['fail' => true, 'data' => $product_color]);
        } else {
            return response()->json(['fail' => false, 'data' => $product_color]);
        }
    }

    /**
     * Gets the session language.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     \Illuminate\Http\Request  The session language.
     */
    public function getToken(Request $request)
    {
        return $request->session()->get('_token');
    }

    /**
     * Gets the session language.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     \Illuminate\Http\Request  The session language.
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $request->all();
                if (Auth::check()) {
                    $customer = $this->customer->where('users_id', Auth::id())->first();
                    $cart     = $this->cart->where('customers_id', $customer->id)
                        ->where('id', $id)
                        ->delete();

                } else {
                    $token = $this->getToken($request);
                    $exist = $this->session->where('token', $token)
                        ->where('id', $id)
                        ->delete();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                return $e;
            }

        } else {
            return $this->redirect;
        }
    }

}
