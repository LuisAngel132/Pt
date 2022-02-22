<?php

namespace App;

use GuzzleHttp\Client;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {

	/**
	 * Creates an or get user.
	 * @param      ProviderUser  $providerUser  The provider user

	 */
	public function createOrGetUser(ProviderUser $providerUser) {

		$client = new Client([
		]);
		$r = $client->request('POST', 'http://sandbox.api.phara.shop/v1/auth/register/social', [

			'json' => [
				'name' => $providerUser->getName(),
				'last_name' => $providerUser->getLastName(),
				'email' => $providerUser->getEmail(),
				'provider' => 'facebook',
				'client_id' => $providerUser->getId(),
			],
			'http_errors' => false,
		]);
		$data = $r->getBody();
		$response = json_decode($data, true);
		\Log::info($response);
		return $user;

	}

}