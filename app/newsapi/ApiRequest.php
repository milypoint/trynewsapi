<?php


namespace app\newsapi;

use app\tools\ClassWithAttributes;

abstract class ApiRequest extends ClassWithAttributes
{
    protected $apiKey;
    protected $apiUrl = 'http://newsapi.org';

    public $errors;

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
        if (!$ch) {
            die('Curl wont init.');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

		$result = curl_exec($ch);
		curl_close($ch);
		try {
			if (!$result) {
				throw new \Exception('Request failed.');
			} else {
				$result = json_decode($result);
				// filter required data:
				if ($result->status === 'ok') {
					$articles = [];
					foreach ($result->articles as $article) {
						$_art = [];
						foreach (array('title', 'description', 'url') as $key) {
							$_art[$key] = $article->$key;
						}
						$articles[] = $_art;
					}
					$articles = ['articles' => $articles];

					return $articles;
				} else {
					$this->errors = $result;
					return [];
				}

			}
		} catch (\Exception $e) {
			echo $e->getMessage();
			return $result;
		}
    }

}