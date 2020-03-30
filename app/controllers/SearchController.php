<?php


namespace app\controllers;

use app\newsapi\ApiRequestEverything;
use app\views\SearchView;

class SearchController extends Controller
{
	public function action()
	{
		// make request:
		if (!empty($_GET)) {
			$request = new ApiRequestEverything($_GET);
			$result = $request->request();

		} else {
			$result = [];
		}
		// make view:
		$view = new SearchView(array_merge($_GET, $result));
		$view->render();
	}
}