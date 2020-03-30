<?php


namespace app\newsapi;

abstract class ApiRequest
{
    protected $apiKey = '15c40ce27080453cb27da1210c38c999';
    protected $apiUrl = 'http://newsapi.org';

    protected $_parameters = [];

    public function __construct()
    {
        $this->apiUrl .= $this->_endpoint;
    }

    public function __set($name, $value)
    {
        if (in_array($name,$this->_default_parameters)) {
            $this->_parameters[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (isset($name, $this->_parameters)) {
            return $this->_parameters[$name];
        }
        return null;
    }

    public function request()
    {
        $string_parameters = [];
        foreach ($this->_parameters as $key => $value) {
            $string_parameters[] = $key.'='.urlencode($value);
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
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}