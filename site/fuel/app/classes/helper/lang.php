<?php

namespace Helper;

class Lang
{
	public static function get_other_language()
	{
		$other_language = ENGLISH_STRING;

		if(\Fuel\Core\Lang::get_lang() == ENGLISH_STRING)
		{
			$other_language = FRENCH_STRING;
		}

		return $other_language;
	}
}

?>