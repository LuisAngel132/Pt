<?php

namespace App\Http\Controllers\Auth;

use App\Models\Code;
use App\Models\User;
use App\Models\Person;
use GuzzleHttp\Client;
use App\Mail\WelcomeUser;
use App\Models\CustomersCode;
use Illuminate\Support\Carbon;
use App\Models\CodesDiscountType;
use App\Models\CodesPromotionsType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    //protected $BASE_URL      = 'http://sandbox.api.phara.shop';
    //protected $AUTH_REGISTER = '/v1/auth/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'                 => 'required|string',
            'last_name'            => 'required|string',
            'gender'               => 'required',
            'phone_number'         => 'required|numeric',
            'terms_and_conditions' => 'required',
            'email'                => 'required|string|email|max:255|unique:users',
            'password'             => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        \Log::info($registerData = [
            'registerData' => $data['email'],
        ]);

        $client  = new Client([]);
        $request = $client->request('POST', config('constants.BASE_URL') . config('constants.AUTH_REGISTER'), [
            'json' => [
                'name'                  => $data['name'],
                'last_name'             => $data['last_name'],
                'email'                 => $data['email'],
                'phone_number'          => $data['phone_number'],
                'password'              => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
            ],
        ]);

        $data             = $request->getBody();
        $response         = json_decode($data, true);
        $token            = $response['data']['token'];
        $customerResponse = $response['data']['customer'];

        request()->session()->flash('_user_registered', $response['data']['customer']['id']);

        $person = Person::where('id', $response['data']['customer']['users']['people_id'])->get()->first();

        \Log::info($array = [
            'person_data' => $person,
        ]);

        \Log::info($array = [
            'response_data' => $response['data'],
        ]
        );

        \Log::info($array = [
            'token_register' => $token,
        ]);

        \Session::put('token', $token);

        \Log::info($array = [
            'customer_userid' => $customerResponse['users_id'],
        ]);

        $customerCode = CustomersCode::where('customers_id', $customerResponse['id'])->get()->first();
        $code         = Code::where('id', $customerCode->codes_id)->get()->first();

        \Log::info($array = [
            'new_customer' => json_encode($customerCode),
        ]);

        \Log::info($array = [
            'new_code' => json_encode($code),
        ]);

        // $data['email']
        Mail::to($customerResponse['users']['email'])->send(new WelcomeUser($person, $code));

        $user = User::find($customerResponse['users_id']);

        \Log::info($array = [
            'new_user' => $user,
        ]);

        return $user;
    }

    /*
    protected function create(array $data) {
    try {
    DB::beginTransaction();
    $person = Person::create([
    'name' => $data['name'],
    'last_name' => $data['last_name'],
    'gender' => $data['gender'],
    'full_name' => $data['name'] . " " . $data['last_name'],
    ]);
    $user = User::create([
    'people_id' => $person->id,
    'email' => $data['email'],
    'is_active' => true,
    'password' => Hash::make($data['password']),
    ]);

    $customer = Customer::create([
    'users_id' => $user->id,
    'phone_number' => $data['phone_number'],
    ]);

    $code = $this->generateCodigo($customer);
    Log::info($code);

    Mail::to($data['email'])->send(new WelcomeUser($person, $code));
    DB::commit();
    return $user;

    } catch (Exception $e) {
    DB::rollback();
    }

    }
     */

    public function generateCodigo($users_id)
    {
        $startDate     = Carbon::now(env('APP_TIMEZONE'));
        $discountType  = 3;
        $promotionType = 2;
        $code_String   = str_random(8);
        $code          = Code::create([
            'code'       => $code_String,
            'start_date' => $startDate,
            'end_date'   => $startDate->addMonths(3),
            'is_active'  => true,
        ]);

        $codesDiscountType = CodesDiscountType::create([
            'codes_id'          => $code->id,
            'discount_types_id' => $discountType,
            'available_redeems' => 0,
        ]);

        $codesPromotionsType = CodesPromotionsType::create([
            'codes_id'            => $code->id,
            'promotions_types_id' => $promotionType,
        ]);

        $customersCode = CustomersCode::create([
            'codes_id'     => $code->id,
            'customers_id' => $users_id,
        ]);

        return $code;
    }
}
