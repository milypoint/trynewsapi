<?php

namespace app\views;

class View
{
	private $_attributes = [];

	public function __set($name, $value)
	{
		$this->_attributes[$name] = $value;
	}

	public function __get($name)
	{
		if (isset($name, $this->_attributes)) {
			return $this->_attributes[$name];
		}
		return null;
	}

	public function __construct($attributes=null)
	{
		if ($attributes !== null) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public function render()
	{
		foreach ($this->_attributes as $key => $value) {
			$a = $key;
			$$a = $value;
		}
		ob_start();
		include $this->_static;
		echo ob_get_clean();
	}

	public function get_view()
	{
		foreach ($this->_attributes as $key => $value) {
			$a = $key;
			$$a = $value;
		}
		ob_start();
		include $this->_static;
		return ob_get_clean();
	}

	public function set_static($_static)
	{
		$this->_static = $_static;
	}

	public function get_static()
	{
		return $this->_static;
	}
}