<?php

namespace Model\Filters;

class Fl
{

	public $from       = 0;
	public $returnSize = 40;
	public $isRelation = NULL;
	public $fullLoad   = NULL;
	public $selectors  = NULL;

	protected $invalidFilters = array();
	protected $unknownFilters = array();
	protected $attrTypes      = array();

	public function init()
	{
		$currentAttr     = array(
			'from'       => 'int',
			'returnSize' => 'int',
			'isRelation' => 'bool',
			'fullLoad'   => 'bool',
			'selectors'  => 'special'
		);
		$this->attrTypes = array_merge($this->attrTypes, $currentAttr);
	}

	public function getFormatedMessage()
	{
		$response = array();
		if(count($this->invalidFilters) > 0){
			$response['Invalid Filters Value'] = $this->invalidFilters;
		}
		if(count($this->unknownFilters) > 0){
			$response['Unknown Filters'] = $this->unknownFilters;
		}

		return $response;
	}

	public function setFromPosted($postedFilters)
	{
		unset($postedFilters['isRelation']); // Security to avoid returning more results
		if(isset($postedFilters['returnSize']) && $postedFilters['returnSize'] > 40){
			$postedFilters['returnSize'] = 40;
		}

		$result = TRUE;

		foreach($postedFilters as $key => $filterValue){
			if(isset($filterValue[0]) && $filterValue[0] == '['){
				$trimmed     = rtrim(ltrim($filterValue, '['), ']');
				$filterValue = explode(',', $trimmed);
			}

			if(property_exists($this, $key)){

				$type = $this->attrTypes[$key];

				if($this->validateType($filterValue, $type)){
					$this->{$key} = $filterValue;
				}
				else{
					$result = FALSE;
					array_push($this->invalidFilters, $key);
				}
			}
			else{
				$result = FALSE;
				array_push($this->unknownFilters, $key);
			}

		}

		return $result;

	}

	private function validateType($value, $type)
	{

		switch($type){
			case 'int':
				return \Helper\Helper::validateNumeric($value);
				break;

			case 'smallint':
				if((int)$value < 65535){
					return \Helper\Helper::validateNumeric($value);
				}
				break;

			case 'text':
				return TRUE;
				break;

			case 'string':
				return (strlen($value) <= 255);
				break;

			case 'datetime':
				return \Helper\Helper::validateDate($value);
				break;

			case 'double':
				return \Helper\Helper::validateNumeric($value);
				break;

			case 'float':
				return \Helper\Helper::validateNumeric($value);
				break;

			case 'bool':
			case 'relation':
				return \Helper\Helper::validateBool($value);
				break;

			case 'listInt':
				return \Helper\Helper::validateListInt($value);
				break;

			case 'listFloat':
				return \Helper\Helper::validateListFloat($value);
				break;

			case 'special':
				return TRUE;
				break;

			default:
				break;
		}

		return FALSE;

	}
}