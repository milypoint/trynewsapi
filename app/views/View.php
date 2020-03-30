<?php

namespace app\views;

use app\tools\ClassWithAttributes;

class View extends ClassWithAttributes
{
	public function __construct(array $attributes=[])
	{
		foreach ($attributes as $key => $value) {
			$this->$key = $value;
		}
	}

	public function render()
	{
		echo $this->get_view();
	}

	public function get_view()
	{
		foreach ($this->_attributes as $key => $value) {
			$a = $key;
			$$a = $value;
		}
		ob_start();
		include $this->_file;
		return ob_get_clean();
	}
}