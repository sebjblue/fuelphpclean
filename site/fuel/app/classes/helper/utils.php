<?php

namespace Helper;

class Utils
{
	public function __construct()
	{
		// Constructor
	}

	public static function createFacebookShareUrl($url, $title)
	{
		return str_replace('{{_URL_}}', $url, str_replace('{{_TITLE_}}', $title, FACEBOOK_SHARE_URL));
	}

	public static function createTwitterTweetUrl($url, $title)
	{
		return str_replace('{{_TITLE_}}', $title, str_replace('{{_URL_}}', $url, TWITTER_TWEET_URL));
	}

	public static function formatDate($date, $format_type)
	{
		$date 			= strtotime($date);
		$date_formated 	= '';

		if ($date != '' && $date > strtotime(SYSTEM_DEFAULT_DATE))
		{
			if ($format_type == YEAR_MONTH_DAY_DIGITAL)
			{
				$date_formated = date("Y-m-d", $date);
			}
			else if ($format_type == NEWSFEED_FORMAT)
			{
				if (date("Ymd") == date('Ymd', $date))
				{
					$date_formated = \Fuel\Core\Lang::get('today') . ' | ' . date("g:iA", $date);
				}
				else
				{
					$date_formated = date("d.m.Y", $date) . ' | ' . date("g:iA", $date);
				}
			}
		}

		return $date_formated;
	}

	public static function formatPhoneNumber($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);

		if(strlen($phone) == 7)
		{
			$phone = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		}
		elseif(strlen($phone) == 10)
		{
			$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
		}
		elseif(strlen($phone) == 11 && $phone[0] == 1)
		{
			$phone = preg_replace("/1([0-9]{3})([0-9]{3})([0-9]{4})/", "1-$1-$2-$3", $phone);
		}

		return $phone;
	}

	public static function fprint($obj)
	{
		echo "<pre>";
        	print_r($obj);
    	echo "</pre>";
	}

	public static function our_http_build($params)
	{
		$string = '?';
	  	$i      = 0;

	  	foreach($params as $key => $value)
	  	{
	   		if($i > 0)
	   		{
				$string .= '&';
	   		}

	   		$string .= $key . '=';

	   		if(is_array($value))
	   		{
				$string .= '[' . implode(',', $value) . ']';
	   		}
	   		else
	   		{
				$string .= $value;
	   		}

		   	$i++;
		}

		return $string;
	 }

	public static function getAlias($value, $replaceSpace = true)
	{
		$value = trim(self::getUtf8StrToLower($value));

		$value = self::removeAllAccent($value);

		$unwanted_array = array('/' => '-',
								'\'' => '-',
								'"' => '-',
								"'" => '-');

		$value = strtr($value, $unwanted_array);


		if($replaceSpace == true)
		{
			//remove any '-' from the string they will be used as concatonater
			$value = str_replace('-', ' ', $value);

			// remove any duplicate whitespace, and ensure all characters are alphanumeric
			$value = preg_replace(array('/[^A-Za-z0-9\-\s]/', '/\s+/'), array('', '-'), $value);
		}
		else
		{
			//Ensure all characters are alphanumeric (but still accept - and whitespace)
			$value = preg_replace(array('/[^A-Za-z0-9\-\s]/', '/\s+/'), array('', ' '), $value);
		}


		//here we want to make sure the alias doesn't start or end by a '-'
		$value = ltrim($value, "-");
		$value = rtrim($value, "-");


		return $value;
	}

	public static function removeAllAccent($value, $toLower = true)
	{
		$value = trim(($toLower===true?self::getUtf8StrToLower($value):$value));

		$unwanted_array = array(
			'à' => 'a','â' => 'a','ä' => 'a','á' => 'a','å' => 'a','ā' => 'a','ã' => 'a',
			'é' => 'e','è' => 'e','ê' => 'e','ë' => 'e','ē' => 'e','ĕ' => 'e','ė' => 'e','ę' => 'e','ě' => 'e',
			'í' => 'i','î' => 'i','ì' => 'i','ï' => 'i','ĩ' => 'i','ī' => 'i','ĭ' => 'i','ǐ' => 'i','į' => 'i','ı' => 'i',
			'ó' => 'o','ô' => 'o','ò' => 'o','ø' => 'o','õ' => 'o','ö' => 'o','ō' => 'o','ŏ' => 'o','ǒ' => 'o','ő' => 'o','ơ' => 'o','ø' => 'o','ǿ' => 'o','º' => 'o',
			'ú' => 'u','û' => 'u','ù' => 'u','ü' => 'u','ú' => 'u','ũ' => 'u','ū' => 'u','ŭ' => 'u','ů' => 'u','ű' => 'u',
			'æ' => 'ea','ǽ' => 'ae',
			'ç' => 'c','ć' => 'c','ĉ' => 'c','ċ' => 'c','č' => 'c',
			'ð' => 'd','ď' => 'd','đ' => 'd',
			'ĝ' => 'g','ğ' => 'g','ġ' => 'g','ģ' => 'g',
			'ĥ' => 'h','ħ' => 'h',
			'ĵ' => 'j',
			'ķ' => 'k',
			'ñ' => 'n','ń' => 'n','ņ' => 'n','ň' => 'n',
			'ŕ' => 'r','ŗ' => 'r','ř' => 'r',
			'ś' => 's','ŝ' => 's','ş' => 's','š' => 's',
			'ý' => 'y','ÿ' => 'y','ŷ' => 'y',
			'ź' => 'z','ż' => 'z','ž' => 'z',
			'Œ' => 'oe',
			'ƒ' => 'f'
		);

		$unwanted_array_uppercase = array(
			'À' => 'A','Â' => 'A','Ä' => 'A','Á' => 'A','Å' => 'A','Ā' => 'A','Ã' => 'A',
			'É' => 'E','È' => 'E','Ê' => 'E','Ë' => 'E','Ē' => 'E','Ĕ' => 'E','Ė' => 'E','Ę' => 'E','Ě' => 'E',
			'Í' => 'I','Î' => 'I','Ì' => 'I','Ï' => 'I','Ĩ' => 'I','Ī' => 'I','Ĭ' => 'I','Ǐ' => 'I','Į' => 'I','I' => 'I',
			'Ó' => 'O','Ô' => 'O','Ò' => 'O','Ø' => 'O','Õ' => 'O','Ö' => 'O','Ō' => 'O','Ŏ' => 'O','Ǒ' => 'O','Ő' => 'O','Ơ' => 'O','Ø' => 'O','Ǿ' => 'O',
			'Ú' => 'U','Û' => 'U','Ù' => 'U','Ü' => 'U','Ú' => 'U','Ũ' => 'U','Ū' => 'U','Ŭ' => 'U','Ů' => 'U','Ű' => 'U',
			'Æ' => 'EA','Ǽ' => 'AE',
			'Ç' => 'C','Ć' => 'C','Ĉ' => 'C','Ċ' => 'C','Č' => 'C',
			'Ð' => 'D','Ď' => 'D','Đ' => 'D',
			'Ĝ' => 'G','Ğ' => 'G','Ġ' => 'G','Ģ' => 'G',
			'Ĥ' => 'H','Ħ' => 'H',
			'Ĵ' => 'J',
			'Ķ' => 'K',
			'Ñ' => 'N','Ń' => 'N','Ņ' => 'N','Ň' => 'N',
			'Ŕ' => 'R','Ŗ' => 'R','Ř' => 'R',
			'Ś' => 'S','Ŝ' => 'S','Ş' => 'S','Š' => 'S',
			'Ý' => 'Y','Ÿ' => 'Y','Ŷ' => 'Y',
			'Ź' => 'Z','Ż' => 'Z','Ž' => 'Z',
			'Œ' => 'OE',
			'Ƒ' => 'F'
		);

		if($toLower === false){
			$unwanted_array = array_merge($unwanted_array, $unwanted_array_uppercase);
		}

		return strtr($value, $unwanted_array);
	}

	public static function getUtf8StrToLower($value)
	{
		return mb_strtolower($value, 'UTF-8');
	}
}

?>