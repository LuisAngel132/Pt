<?php

namespace App\Http\Controllers\Contact;

use DB;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller {
	/**
	 * Gets the session language.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The session language.
	 */
	public function getLang(Request $request) {

		if ($request->session()->has('lang')) {
			return $request->session()->get('lang');
		} else {
			return 'es';
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
			$request->all();
			$iso_code = $this->getLang($request);

			$date = date("Y-m-d");
			$data = array(
				'name' => $request->name,
				'email' => $request->email,
				'subject' => $request->subject,
				'mensaje' => $request->message,
				'date' => $date,
			);

			Mail::send('mailview.contact', $data, function ($mail) use ($data) {
				$mail->from($data['email']);
				$mail->to('contacto@phara.shop');
				$mail->subject($data['subject']);
			});
			DB::commit();
			if ($iso_code == 'es') {
				return back()->with('success', '¡Gracias por contactarnos!');
			} else if ($iso_code == 'en') {
				return back()->with('success', '¡Thank you for contacting us!');
			} else {
				return back()->with('success', '¡Gracias por contactarnos!');
			}

		} catch (Exception $e) {
			DB::rollback();
			if ($iso_code == 'es') {
				return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
			} else if ($iso_code == 'en') {
				return back()->with('error', '¡Something went wrong, try again!');
			} else {
				return back()->with('error', '¡Algo salió mal, inténtalo nuevamente!');
			}
		}
	}
}
