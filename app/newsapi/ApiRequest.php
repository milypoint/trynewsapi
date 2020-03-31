<?php


namespace app\newsapi;

use app\tools\ClassWithAttributes;

abstract class ApiRequest extends ClassWithAttributes
{
    protected $apiKey;
    protected $apiUrl = 'http://newsapi.org';

    public $errors = [];

    abstract function rules();

    public function __set($key, $value) //extends parent::__set()
	{
		foreach ($this->rules() as $k => $fn) {
			if ($key == $k) {
				if (!$fn($value)) {
					$this->errors[$key] = 'The value does not comply with the rules';
					return;
				}
			}
		}
		parent::__set($key, $value);
	}

	public function __construct(array $params)
    {
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
        $this->apiUrl .= $this->_endpoint;
        $this->apiKey = Config::token();
    }

    public function request()
    {
    	//TODO: Add validation $_GET data.
        $string_parameters = [];
        foreach ($this->_attributes as $key => $value) {
        	if (in_array($key, $this->_request_parameters)) {
				$string_parameters[] = $key.'='.urlencode($value);
			}
        }
        // add parameters into url:
        $url = $this->apiUrl . '?'.implode('&', $string_parameters);
        $headers = ['X-Api-Key: '.$this->apiKey];
        $ch = curl_init();
        try {
			if (!$ch) {
				throw new \Exception('Curl did not init.');
			}
		} catch (\Exception $e) {
        	echo $e->getMessage();
        	return [];
		}

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

		$result = curl_exec($ch);
		curl_close($ch);

		try {
			if (!$result) {
				$result = [];
				throw new \Exception('Request failed.');
			} else {
				// filter required data:
				$result = json_decode($result);
				if ($result->status == 'ok') {
					//TODO:  replace $articles to variable of variable witch declared in child class
					//TODO:  for example: $request_key = 'articles';
					//TODO:  $$request_key = ['title', 'description', 'url'];
					$articles = [];
					foreach ($result->articles as $article) {
						$_art = [];
						foreach (array('title', 'description', 'url') as $key) {
							$_art[$key] = $article->$key;
						}
						$articles[] = $_art;
					}
					$result = ['articles' => $articles];
				} else {
					$err_code = $result->code;
					$err_message = $result->message;
					$result = [];
					throw new \Exception(
						'Request return error with code: ' . $err_code . PHP_EOL .
						'Message: ' . $err_message
					);
				}
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
		return $result;
    }

}