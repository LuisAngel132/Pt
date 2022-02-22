<?php

namespace App\Http\Controllers\About;

use GuzzleHttp\Client;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AboutController extends Controller
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
        return view('about.about');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFaqs()
    {
        return view('about.faqs');
    }

    /**
     * Gets the company.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function getCompany(Request $request)
    {
        $token    = $this->getToken($request);
        $iso_code = $this->getLang($request);
        $client   = new Client([]);
        $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.RESOURCES_COMPANY'), [
            'headers' => [
                'Authorization'   => 'Bearer ' . $token,
                'Accept-Language' => $iso_code,
            ],
        ]);

        $data            = $query->getBody();
        return $response = json_decode($data, true);
    }

    /**
     * Gets the faqs.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function getFaqs(Request $request)
    {
        $token    = $this->getToken($request);
        $iso_code = $this->getLang($request);
        $client   = new Client([]);
        $query    = $client->request('GET', config('constants.BASE_URL') . config('constants.RESOURCES_FAQS'), [
            'headers' => [
                'Authorization'   => 'Bearer ' . $token,
                'Accept-Language' => $iso_code,
            ],
        ]);

        $data            = $query->getBody();
        return $response = json_decode($data, true);
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
        //
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
