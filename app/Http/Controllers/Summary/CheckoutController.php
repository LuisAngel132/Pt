<?php

namespace App\Http\Controllers\Summary;

use Redirect;
use App\Models\Fee;
use App\Models\Cart;
use App\Models\Lang;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AddressTypeTranslation;
use App\Models\PaymentMethodTranslation;

/**
 * Controls the data flow into a checkout object and updates the view whenever data changes.
 */
class CheckoutController extends Controller
{
    protected $fee;
    protected $user;
    protected $cart;
    protected $lang;
    protected $address;
    protected $customer;
    protected $productsColor;
    protected $customerAddress;
    protected $addressTypeTranslation;
    protected $paymentMethodTranslation;

    public function __construct(User $user, Cart $cart, Lang $lang, Fee $fee, Customer $customer, AddressTypeTranslation $addressTypeTranslation, ProductsColor $productsColor, CustomerAddress $customerAddress, Address $address, PaymentMethodTranslation $paymentMethodTranslation)
    {
        $this->fee                      = $fee;
        $this->user                     = $user;
        $this->cart                     = $cart;
        $this->lang                     = $lang;
        $this->address                  = $address;
        $this->customer                 = $customer;
        $this->productsColor            = $productsColor;
        $this->customerAddress          = $customerAddress;
        $this->addressTypeTranslation   = $addressTypeTranslation;
        $this->paymentMethodTranslation = $paymentMethodTranslation;
        $this->redirect                 = Redirect::to('cart');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        if ($cart > 0) {
            $request->session()->all();
            $request->session()->forget('cupon');
            $request->session()->forget('cuponVal');
            $request->session()->forget('cost');
            $request->session()->forget('cost_id');
            $request->session()->forget('descuento');
            $request->session()->forget('gift_messages');
            return view('ecommerce.checkout');
        } else {
            return $this->redirect;
        }

    }

    /**
     * Gets the cart.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     string                    The cart.
     */
    public function getCart($request)
    {
        $customer    = $this->customer->where('users_id', Auth::id())->first();
        return $cart = $this->cart->where('customers_id', $customer->id)->count();
    }

    /**
     * Gets the address type.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The address type.
     */
    public function getAddressType(Request $request)
    {
        if ($request->ajax()) {
            $lang = $this->getSessionLang($request);
            return $this->addressTypeTranslation->where('langs_id', $lang->id)->get();
        } else {
            return $this->redirect;
        }

    }

    /**
     * Gets the payment type.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The payment type.
     */
    public function getPaymentType(Request $request)
    {
        if ($request->ajax()) {
            $lang = $this->getSessionLang($request);
            return $this->paymentMethodTranslation->where('langs_id', $lang->id)->get();
        } else {
            return $this->redirect;
        }
    }

    /**
     * Gets the address.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The address.
     */
    public function getAddress(Request $request)
    {
        if ($request->ajax()) {
            $lang                   = $this->getSessionLang($request);
            $user                   = $this->getUser($request);
            $customer               = $this->customer->where('users_id', $user->id)->first();
            return $customerAddress = $this->customerAddress->with(['addresses',
                'addressTypes.addressTypeTranslations' => function ($query) use ($lang) {
                    $query->where('langs_id', $lang->id);
                },
            ])
                ->where('customers_id', $customer->id)
                ->where('is_active', true)
                ->get();
        } else {
            return $this->redirect;
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
     * Gets the fees.
     * @param      \Illuminate\Http\Request  $request  The request
     * @return     The fees.
     */
    public function getFees(Request $request)
    {
        if ($request->ajax()) {
            $lang       = $this->getSessionLang($request);
            return $fee = $this->fee->with(['feeTranslations' => function ($query) use ($lang) {
                $query->where('langs_id', $lang->id);
            }, 'feeTranslations.langs',
            ])->where('is_active', true)
                ->get();
        } else {
            return $this->redirect;
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
}
