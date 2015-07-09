<?php

namespace Libraries\Blue\Email;

class EmailOptions{

	public $emailTypeName;
	public $to;
	public $subject;
	public $vars;

	public function __construct(){
		$this->init();
	}

	public function addTo($to){
		if(is_array($to)){
			foreach($to as $t){
				array_push($this->to, $t);
			}
		}
		else{
			array_push($this->to, $to);
		}
	}

	public function addVars($vars = "", $value = ""){
		if(is_array($vars)){
			foreach($vars as $varKey => $varValue){
				$this->vars[$varKey] = $varValue;
			}
		}
		else{
			if($vars !== ""){
				$this->vars[$vars] = $value;
			}
		}
	}

	private function init(){
		$this->emailTypeName 	= "";
		$this->to 				= array();
		$this->subject 			= "";
		$this->vars 			= array();
	}
}
