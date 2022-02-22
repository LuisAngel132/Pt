<?php

namespace App\Http\Controllers\MyAccount;

use DB;
use Redirect;
use Validator;
use App\Models\Lang;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AddressTypeTranslation;

/**
 * Controls the data flow into an address object and updates the view whenever data changes.
 */
class AddressController extends Controller {

	protected $user;
	protected $lang;
	protected $address;
	protected $customer;
	protected $customerAddress;
	protected $addressTypeTranslation;

	/**
	 * __construct
	 *
	 * @param      \App\Models\User                    $user                    The user
	 * @param      \App\Models\Lang                    $lang                    The language
	 * @param      \App\Models\Customer                $customer                The customer
	 * @param      \App\Models\AddressTypeTranslation  $addressTypeTranslation  The address type translation
	 */
	public function __construct(User $user, Lang $lang, Customer $customer, AddressTypeTranslation $addressTypeTranslation, CustomerAddress $customerAddress, Address $address) {
		$this->user = $user;
		$this->lang = $lang;
		$this->address = $address;
		$this->customer = $customer;
		$this->customerAddress = $customerAddress;
		$this->addressTypeTranslation = $addressTypeTranslation;
		$this->redirect = Redirect::to('profile');
		//$this->middleware('guest');
	}

	/**
	 * Gets the address type.
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     The address type.
	 */
	public function getAddressType(Request $request) {
		if ($request->ajax()) {
			$lang = $this->getSessionLang($request);
			return $this->addressTypeTranslation->where('langs_id', $lang->id)->get();
		} else {
			return $this->redirect;
		}
	}

	/**
	 * Gets the address.
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @return     The address.
	 */
	public function getAddress(Request $request) {

		if ($request->ajax()) {
			$lang = $this->getSessionLang($request);
			$user = $this->getUser($request);
			$customer = $this->customer->where('users_id', $user->id)->first();

			return $customerAddress = $this->customerAddress->with([
				'addresses',
				'addressTypes.addressTypeTranslations' => function ($query) use ($lang) {
					$query->where('langs_id', $lang->id);
				},
			])
				->where('customers_id', $customer->id)
				->where('is_active', 1)
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		try {
			DB::beginTransaction();
			$user = $this->getUser($request);
			$customer = $this->customer->where('users_id', $user->id)->first();
			$address = $this->address->create($request->all());
			$customerAddress = $this->customerAddress->create([
				'addresses_id' => $address->id,
				'customers_id' => $customer->id,
				'address_types_id' => $request->address_types,
				'payment_shipping_contact_id' => '',
			]);
			DB::commit();
			return response()->json(['errors' => false]);
		} catch (Exception $e) {
			DB::rollback();
			return $e;
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editAddress(Request $request) {
		try {
			DB::beginTransaction();
			$customerAddress = $this->customerAddress->where('addresses_id', $request->addres_id);
			$customerAddress->update([
				'address_types_id' => $request->address_types_edit,
			]);
			$address = $this->address->find($request->addres_id);
			$address->update($request->all());
		   DB::commit();
		   return response()->json(['errors' => false]);
		} catch (Exception $e) {
			DB::rollback();
			return $e;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id) {
		try {
			DB::beginTransaction();
			$customerAddress = $this->customerAddress->where('addresses_id', $id);
			$customerAddress->update([
				'is_active' => 0,
			]);
			DB::commit();
			return response()->json(['errors' => false]);
		} catch (Exception $e) {
			DB::rollback();
			return $e;
		}
	}
}
