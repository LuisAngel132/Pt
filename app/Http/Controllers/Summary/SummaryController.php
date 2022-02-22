<?php
namespace App\Http\Controllers\Summary;

use Redirect;
use App\Models\Fee;
use App\Models\Cart;
use App\Models\Lang;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductsColor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller {
	protected $fee;
	protected $user;
	protected $cart;
	protected $lang;
	protected $customer;
	protected $productsColor;

	public function __construct(User $user, Cart $cart, Lang $lang, Fee $fee, Customer $customer, ProductsColor $productsColor) {
		$this->fee = $fee;
		$this->user = $user;
		$this->cart = $cart;
		$this->lang = $lang;
		$this->customer = $customer;
		$this->productsColor = $productsColor;
		$this->redirect = Redirect::to('cart');
	}

	public function totalSummary(Request $request) {
		$envio = 0;
		$descuento = 0;
		$cost = 0;
		$subtotal = 0;
		$total = 0;
		$envio = $this->envio($request);
		$cost = $this->costo($request);
		$descuento = $this->descuento($request);
		$subtotal = $this->subtotal($request);

		$total = ($subtotal + $envio + $cost - $descuento);

		return $data = [
			'total' => $total,
			'subtotal' => $subtotal,
			'envio' => $envio,
			'cost' => $cost,
			'descuento' => $descuento,
		];

	}

	/**
	 * Gets the session language.
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     \Illuminate\Http\Request  The session language.
	 */
	public function getSessionLang(Request $request) {
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
	public function getUser(Request $request) {
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
	 * Gets the gift.
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     \Illuminate\Http\Request  The gift.
	 */
	public function costo(Request $request) {

		if ($request->session()->has('cost')) {
			return $cost = $request->session()->get('cost'); // si existe imprime el valor de la variable
		} else {
			\Session::put('cost', 0.00);
			return $cost = $request->session()->get('cost');
		}

	}

	/**
	 * Gets the descount.
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function descuento(Request $request) {
		if ($request->session()->has('descuento')) {
			return $descuento = $request->session()->get('descuento'); // si existe imprime el valor de la variable
		} else {
			\Session::put('descuento', 0.00);
			return $descuento = $request->session()->get('descuento');
		}
	}

	/**
	 * subtotal
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     \Illuminate\Http\Request  subtotal
	 */
	public function subtotal(Request $request) {
		return $subtotal = $request->session()->get('subtotal');
	}

	/**
	 * envio
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     \Illuminate\Http\Request  envio
	 */
	public function envio(Request $request) {
		return $envio = $request->session()->get('envio');
	}
}
