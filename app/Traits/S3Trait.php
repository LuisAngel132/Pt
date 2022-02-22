<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;
trait S3Trait {
	/**
	 * Get the S3 access url.
	 *
	 * @param  string   $key
	 * @return string
	 */
	protected function temporaryUrl($key) {
		$s3 = Storage::disk('s3');
		$client = $s3->getDriver()->getAdapter()->getClient();
		$command = $client->getCommand('GetObject', [
			'Bucket' => config('filesystems.disks.s3.bucket'),
			'Key' => $key,
		]);
		return (string) $client->createPresignedRequest($command, '+240 minutes')->getUri();
	}
}