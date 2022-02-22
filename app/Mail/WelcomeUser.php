<?php

namespace App\Mail;

use App\Models\Code;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUser extends Mailable {
	use Queueable, SerializesModels;

	public $person;
	public $code;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Person $person, Code $code) {
		$this->person = $person;
		$this->code = $code;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->view('emails.welcome')->with([
			'name' => $this->person->full_name,
			'code' => $this->code,
		]);
	}
}
