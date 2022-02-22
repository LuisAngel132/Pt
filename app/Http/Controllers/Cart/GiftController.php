<?php

namespace App\Http\Controllers\Cart;

use Redirect;
use Validator;
use App\Models\Lang;
use Illuminate\Http\Request;
use App\Models\FeeTranslations;
use App\Http\Controllers\Controller;

/**
 * Controls the data flow into a gift object and updates the view whenever data changes.
 */
class GiftController extends Controller {

	protected $lang;
	protected $feeTranslations;

	/**
	 * __construct
	 *
	 * @param      \App\Models\Lang             $lang             The language
	 * @param      \App\Models\FeeTranslations  $feeTranslations  The fee translations
	 */
	public function __construct(Lang $lang, FeeTranslations $feeTranslations) {
		$this->lang = $lang;
		$this->feeTranslations = $feeTranslations;
		$this->redirect = Redirect::to('cart');
	}

	/**
	 * Adds a gift.
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function addGift(Request $request) {
		if ($request->ajax()) {
			try {
				$lang = $this->getSessionLang($request);
				$card = $request->card;
				$checkbox_value = $request->checkbox_value;
				$cost = 0;
				$request->all();
				foreach ($checkbox_value as $clave => $valor) {
					$feeTranslations = $this->feeTranslations->where('fees_id', $valor)
						->where('langs_id', $lang->id)->first();
					$cost += $feeTranslations->price;
					if ($valor == 2) {
						$validator = Validator::make($card, [
							'title' => 'required',
							'to' => 'required',
							'message' => 'required',
						]);
						if ($validator->fails()) {
							$data = [
								'message' => trans('lang.checkout_alert_card_empty'),
								'status' => 'warning',
								'cost' => 0.00,
							];
							return response()->json($data, 200);
						} else {
							\Session::put('gift_messages', $card);
						}
					}
				}
				\Session::put('cost', $cost);
				\Session::put('cost_id', $checkbox_value);
				$data = [
					'message' => trans('lang.checkout_alert_card_select_success'),
					'status' => 'success',
					'cost' => $cost,
				];
				return response()->json($data, 200);
			} catch (Exception $e) {
				$data = [
					'message' => trans('lang.checkout_alert_card_select_error'),
					'status' => 'error',
					'cost' => 0.00,
				];
				return response()->json($data, 200);
			}
		} else {
			return $this->redirect;
		}
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
}
