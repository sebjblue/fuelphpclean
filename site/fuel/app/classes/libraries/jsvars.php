<?php

namespace Libraries;

class JsVars{
	private $vars = array();

	public function __construct(){
		// Constructor
	}

	public function addVar($name, $value){
		$this->vars[$name] = $value;
	}

	public function generateOutput(){
		$output = "";

		if(count($this->vars) > 0){
			$output = "<script type=&quot;text/javascript&quot;>\n";
			$output .= "\t\tvar ";

			foreach ($this->vars as $var => $value) {
				$output .= $var . " = " . json_encode($value, JSON_UNESCAPED_SLASHES) . ",\n\t\t\t";
			}

			$output = substr($output, 0, -5) . ";\n";
			$output .= "\t</script>\n";
		}

		return $output;
	}
}

?>