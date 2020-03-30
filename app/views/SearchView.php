<?php


namespace app\views;


class SearchView extends View
{
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);

		foreach ([
					 '_file' => ROOT . '/app/views/static/search_view.php',
					 'title' => 'Search News',
					 'languages' => ['ua', 'ru']
				 ] as $key => $value) {
			$this->$key = $value;
		}
	}
}
