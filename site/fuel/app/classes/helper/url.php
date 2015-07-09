<?php

namespace Helper;

class Url
{
	public function __construct()
	{
		// Constructor
	}

	public static function create_link($name, $params = array())
	{
		return \Fuel\Core\Router::get($name . '_' . \Fuel\Core\Lang::get_lang(), $params) . '/';
	}

	public static function switch_language($other_lang)
	{
		$url 			= \Fuel\Core\Router::get('home_en') . '/';
		$switch_page 	= '';
		$params 		= array();
		$current_lang 	= \Fuel\Core\Lang::get_lang();

		// Loop through routes
		foreach(\Fuel\Core\Router::$routes as $key => $route)
		{
			// If there's segments in route (weird, but that tells us that it's the current route...!)
			if(count($route->segments) > 0)
			{
				if(strpos($key, ('_' . $current_lang), strlen($key) - strlen('_' . $current_lang)) !== false)
				{
					$switch_page 	= str_replace('_' . $current_lang, '_' . $other_lang, $key);
					$params			= $route->method_params;
				}

				$url = rtrim(\Fuel\Core\Router::get($switch_page, $route->named_params), "/") . "/";

				foreach($params as $param)
				{
					if ($param != $current_lang && $param != $other_lang)
					{
						$url .= $param . '/';
					}
				}
			}
		};

		return $url;
	}
}

?>