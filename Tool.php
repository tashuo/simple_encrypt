<?php

class Tool
{
	const secret = 'this is secret';

	// base64及签名
	public static function encrypt(string $data): string
	{
		return base64_encode(base64_encode($data) . strtoupper(md5($data . self::secret)));
	}

	// 解码及验签
	public static function decrypt(string $encryptedData): string
	{
		$data = base64_decode($encryptedData);
		if (strlen($data) <= 32) {
			throw new \Exception("Invalid input");
		}

		$origin = base64_decode(substr($data, 0, -32));
		if (strtoupper(md5($origin . self::secret)) !== substr($data, -32)) {
			throw new \Exception("Invalid input");
		}

		return $origin;
	}
}

