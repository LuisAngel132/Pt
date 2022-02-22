<?php

namespace App\Http\Controllers\MyAccount;

use DB;
use Validator;
use GuzzleHttp\Client;
use App\Models\Code;
use App\Models\Lang;
use App\Models\User;
use App\Models\Person;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomersCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Controls the data flow into a profile object and updates the view whenever data changes.
 */
class ProfileController extends Controller {

	const S3_PATH = 'media/avatars';
	protected $user;
	protected $person;
	protected $customersCode;
	protected $customer;
	protected $code;
	protected $lang;

	/**
	 * __construct
	 * @param User          $user
	 * @param Person        $person
	 * @param CustomersCode $customersCode
	 * @param Customer      $customer
	 * @param Code          $code
	 */
	public function __construct(User $user, Lang $lang, Person $person, CustomersCode $customersCode, Customer $customer, Code $code) {
		$this->user = $user;
		$this->lang = $lang;
		$this->person = $person;
		$this->customersCode = $customersCode;
		$this->customer = $customer;
		$this->code = $code;
		$this->s3 = Storage::disk('s3');
		//$this->middleware('guest');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('myaccount.profile');
	}

	/**
	 * Gets the user.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The user.
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
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
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
	 * Gets the customer.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The customer.
	 */
	public function getCustomer(Request $request)
	{
		$token    = $this->getToken($request);
		$iso_code = $this->getSessionLang($request);
		$client = new Client([]);
		$query  = $client->request('GET', config('constants.BASE_URL') . '/v1/customers', [
		    'headers' => [
		        'Authorization'   => 'Bearer ' . $token,
		    ],
		]);
		$data = $query->getBody();
		return $response = json_decode($data, true);
	}

	/**
	 * Update account.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function updateInfo(Request $request) {
		$token    = $this->getToken($request);
		$iso_code = $this->getSessionLang($request);
		$client = new Client([]);
		$query  = $client->request('PUT', config('constants.BASE_URL') . '/v1/customers', [
		    'headers' => [
		        'Authorization'   => 'Bearer ' . $token,
		    ],
		    'json'    => [
		        "name" => $request->name,
		        "last_name" => $request->last_name,
		        "email" => $request->email,
		        "phone_number" => $request->phone_number,
		        "rfc" => $request->rfc,
		    ],
		]);
		$data = $query->getBody();
		return $response = json_decode($data, true);
	}

	/**
	 * Update image profile.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateImg(Request $request) {
		try {
			DB::beginTransaction();
			$request->all();
			$validator = Validator::make($request->all(), [
				'avatar' => 'required|image|mimes:jpeg,jpg,png',
			]);
			if ($validator->fails()) {
				return response()->json(['errors' => true, 'data' => $validator->errors()]);
			} else {
				$user = $this->getUser($request);
				if ($user->image_url) {
					$this->s3->delete($user->image_url);
				}
				$file = $request->file('avatar');
				$string = str_random(10);
				$name = $string . $file->getClientOriginalName();
				$this->s3->put(static::S3_PATH . $name, \File::get($file), 'public');
				$avatarPath = static::S3_PATH . $name;
				$user->image_url = $avatarPath;
				$user->save();
			}
			DB::commit();
			return response()->json(['errors' => false, 'data' => $user]);
		} catch (Exception $e) {
			DB::rollback();
			return $e;
		}
	}

}
