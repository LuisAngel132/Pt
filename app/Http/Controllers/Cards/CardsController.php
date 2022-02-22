<?php

namespace App\Http\Controllers\Cards;

use GuzzleHttp\Client;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CardsController extends Controller
{
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
     * @return     <type>                    The session language.
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $token    = $this->getToken($request);
            $iso_code = $this->getLang($request);
            $client = new Client([]);
            $query  = $client->request('POST', config('constants.BASE_URL') . config('constants.PAYMENTS_CARDS'), [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $iso_code,
                ],
                'json'    => [
                    'method'            => $request->method,
                    'token'             => $request->token_id,
                    'device_session_id' => $request->device_session_id,
                    'is_default'        => true,
                ],
            ]);
            $data = $query->getBody();
            return $response = json_decode($data, true);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getCards(Request $request)
    {
        try {
            $token    = $this->getToken($request);
            $iso_code = $this->getLang($request);

            $client = new Client([]);
            $query  = $client->request('GET', config('constants.BASE_URL') . config('constants.PAYMENTS_CARDS'), [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $iso_code,
                ],
            ]);

            $data            = $query->getBody();
            return $response = json_decode($data, true);

        } catch (Exception $e) {
            return $e;
        }
    }

    public function deleteCard(Request $request)
    {
        try {
            $token    = $this->getToken($request);
            $iso_code = $this->getLang($request);
            $client = new Client([]);
            $query  = $client->request('DELETE', config('constants.BASE_URL') . config('constants.PAYMENTS_CARDS') . '/' . $request->id, [
                'headers' => [
                    'Authorization'   => 'Bearer ' . $token,
                    'Accept-Language' => $iso_code,
                ],
            ]);
            $data = $query->getBody();
            return $response = json_decode($data, true);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
