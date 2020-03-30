<?php

namespace app\newsapi;

class Config
{
	private static $_file = ROOT .'/'. __NAMESPACE__ . '/config.json';
	private static $_default_token = 'Your news api token here.';

	public static function token()
	{
		if (file_exists(self::$_file)) {
			//try to read token from config
			$content = file_get_contents(self::$_file);
			$content = json_decode($content);
			try {
				if (isset($content->token) and $content->token !== self::$_default_token) {
					return $content->token;
				} else {
					throw new \Exception('Token not found in ' . self::$_file);
				}
			} catch (\Exception $e) {
				echo $e->getMessage();
			}


		} else {
			// create config file
			try {
				$handle = fopen(self::$_file, 'w');
				if (!$handle) {
					throw new \Exception('Cant create file '.self::$_file);
				} else {
					$data = ['token' => self::$_default_token];
					$data = json_encode($data);
					fwrite($handle, $data);
					fclose($handle);
				}
			} catch (\Exception $e) {
				echo $e->getMessage();
			}


			echo 'Put token into  ' . self::$_file;
			return null;
		}
	}
}