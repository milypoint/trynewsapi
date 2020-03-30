<?php


namespace app\controllers;

use app\newsapi\ApiRequestEverything as Request;
use app\views\View;

class IndexController
{
	private $_static = ROOT . '/app/views/static/index_view.php';

	private $_view_content = [];

	private $_get_flag = 'search';

	private $_GET_content = [];

	public function __construct()
	{
	}

	public function action()
	{
		// get GET data:
		if (isset($_GET[$this->_get_flag])) {
			//TEMP:
			$this->_GET_content['q'] = $_GET[$this->_get_flag];
			$this->_view_content[$this->_get_flag] = $_GET[$this->_get_flag];
		}

		// make request:
		if ($this->_GET_content) {
			$request = new Request();
			foreach ($this->_GET_content as $key => $value) {
				$request->$key = $value;
			}
			$result = json_decode($request->request());

			// get request content:
			if ($result->status === 'ok') {
				$articles = [];
				foreach ($result->articles as $article) {
					$_art = [];
					foreach (array('title', 'description', 'url') as $key) {
						$_art[] = $article->$key;
					}
					$articles[] = $_art;
				}
				$this->_view_content['articles'] = $articles;
			}
		}

		// make view:
		$view = new View(['title' => 'Search News']);
		$view->set_static($this->_static);
		// set content into view class
		foreach ($this->_view_content as $key => $value) {
			$view->$key = $value;
		}
		$render = $view->get_view();
		echo $render;
	}
}