<?php
/*
Andy Le
000805099
PHP file for Stock class
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
class Stock implements JsonSerializable
{
	private $id;
	private $name;
	private $price;
	private $time;

	function __construct($id, $name, $price, $time)
	{
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->gtime = $time;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}
?>