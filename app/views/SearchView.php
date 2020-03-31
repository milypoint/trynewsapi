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
					 'languages' => ['ar', 'de', 'en', 'es', 'fr', 'he', 'it', 'nl', 'no', 'pt', 'ru', 'se', 'ud', 'zh']
				 ] as $key => $value) {
			$this->$key = $value;
		}
	}
}
