<?php


namespace app\controllers;

use app\newsapi\ApiRequestEverything;
use app\views\SearchView;

class SearchController extends Controller
{
	public function action()
	{
		// make request:
		$result = [];
		if (!empty($_GET)) {
			$request = new ApiRequestEverything($_GET);
			$result = $request->request();
		}
		// make view:
		$view = new SearchView(array_merge($_GET, $result));
		$view->render();
	}
}