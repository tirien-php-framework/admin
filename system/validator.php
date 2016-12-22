<?php 

class Validator
{

	protected static $errorMessage = " is ";

	/**
	 * VALIDATE CLASS
	 * Array $data
	 * Array $condition
	 *
	 * return error message or bool(true)
	 */
	public static function validate(array $data, array $condition)
	{
		foreach ($condition as $key => $value) {

			if (strpos($value, '|') !== false) {
				$multy_values = explode('|', $value);

				foreach ($multy_values as $multy_value) {

					if (self::check($key, $multy_value, $data) == false) {
						return ucfirst($key) . self::$errorMessage . $multy_value;
						break;
					}
				}
				
			} else {
				if (self::check($key, $value, $data) == false) {
					return ucfirst($key) . self::$errorMessage . $value;
					break;
				}
			}
		}

		return true;
	}

	/**
	 * CHECK statement
	 */
	public static function check($key, $value, $data)
	{
		switch ($value) {
			case 'required':
				return !empty($data[$key]);
				break;
			
			case (strpos($value, 'min:')):
				$lenght = explode(":", $value);

				self::$errorMessage = " required lenght is ";

				return strlen($data[$key]) < $lenght[count($lenght) - 1] ? false : true;
				break;
			
			default:
				return false;
				break;
		}
	}

}