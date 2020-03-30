<?php

namespace app\newsapi;

class Config
{
	private static $_file = ROOT .'/'. __NAMESPACE__ . '/config.json';

	public static function token()
	{
		if (file_exists(self::$_file)) {
			//try to read token from config
			$content = file_get_contents(self::$_file);
			$content = json_decode($content);
			if (isset($content->token)) {
				return $content->token;
			}
			throw new \Exception('Token not found in' . self::$_file);
		} else {
			// create config file
			$handle = fopen(self::$_file, 'w') or die('Cannot create file:  ' . self::$_file);
			$data = ['token' => 'Your news api token here.'];
			$data = json_encode($data);
			fwrite($handle, $data);
			fclose($handle);
			die('Put toke into  ' . self::$_file);
		}
	}
}