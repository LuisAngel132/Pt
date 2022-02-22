<?php

namespace App\Http\Controllers\Auth;

use DB;
use Validator;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Session;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    // production "http://api.phara.shop/v1/cart";
    // sandbox "http://sandbox.api.phara.shop/v1/cart";
    //protected $BASE_URL;
    //protected $AUTH_LOGIN = '/v1/auth/login';
    //protected $CART_GET   = '/v1/cart';

    /**
     * Create a new controller instance.
     */
    public function __construct(User $user, Session $session, Customer $customer)
    {

        $this->user     = $user;
        $this->session  = $session;
        $this->customer = $customer;
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        ///  $BASE_URL = config('test.BASE_URL');
        try {
            $remember  = $request->remember;
            $validator = Validator::make($request->all(), [
                'email'    => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator->errors())
                    ->withInput($request->except('password'));
            } else {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
                    $user     = $this->user->where('email', $request->email)->first();
                    $customer = $this->customer->where('users_id', $user->id)->first();
                    if ($customer) {
                        $client = new Client([
                        ]);
                        $r = $client->request('POST', config('constants.BASE_URL') . config('constants.AUTH_LOGIN'), [
                            'json' => ['email' => $request->email, 'password' => $request->password],
                        ]);
                        $data     = $r->getBody();
                        $response = json_decode($data, true);
                        $user     = $response['data']['customer']['users'];
                        $token    = $response['data']['token'];

                        \Log::info($response['data']);

                        \Log::info($name = [
                            'token' => $token,
                        ]);
                        \Session::put('token', $token);
                        $cart = $this->cartSession($request);
                        $request->session()->flash('_user_authenticated', $response['data']['customer']['id']);
                        return redirect()->intended('/');
                    } else {
                        Auth::logout();
                        return redirect('login')->with("Nofound_customer", "error");
                    }
                } else {
                    return redirect('login')->with("Error", "error")
                        ->withInput($request->except('password'));
                }
            }
        } catch (Exception $e) {
            return redirect('login')->with("Error", "error");
        }
    }

/**
 * cart Session
 *
 * @param      \Illuminate\Http\Request  $request  The request
 */
    public function cartSession(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->session()->all();
            $products     = [];
            $tokenSession = $this->getToken($request);
            $tokenLogin   = $this->getTokenLogin($request);
            /*obtengo cart session*/
            $porduct_session = $this->session->where('token', $tokenSession)->get();
            foreach ($porduct_session as $key => $value) {
                $products[] = [
                    'products_id' => $value['products_id'],
                    'colors_id'   => $value['colors_id'],
                    'sizes_id'    => $value['sizes_id'],
                    'qty'         => $value['qty'],
                ];
            }
            //Log::notice(config('cart'));
            $client = new Client([
            ]);

            $r = $client->request('POST', config('constants.BASE_URL') . config('constants.CART_GET'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenLogin,
                ],
                'json'    => [
                    'products' => $products,
                ],
            ]);

            $data     = $r->getBody();
            $response = json_decode($data, true);
            Log::info($response['message']);

            foreach ($porduct_session as $key => $value) {
                $value->delete();
            }
            DB::commit();
        } catch (RequestException $e) {
            DB::rollback();
            if ($e->hasResponse()) {
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                //return new JsonResponse($exception, $e->getCode());
            } else {
                //return new JsonResponse($e->getMessage(), 503);
            }
        }

    }

/**
 * Gets the token.
 * @param      \Illuminate\Http\Request  $request  The request
 * @return     <type>                    The token.
 */

    public function getToken(Request $request)
    {
        return $request->session()->get('_token');
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
