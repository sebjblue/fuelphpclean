<?php

class Controller_WS extends \Controller {
	public function __construct($request){
		parent::__construct($request);

		session_start();
	}

	public function jsonSuccess( $msg = '', $args = array(), $httpCode = 200 ) {
		$resultArray['error'] = FALSE;
		$resultArray['msg']   = $msg;

		http_response_code((int)$httpCode);

		foreach( $args as $key => $arg ){
			$resultArray[$key] = $arg;
		}

		echo json_encode( $resultArray );
		exit;
	}

	public function jsonError( $msg = '', $args = array(), $httpCode = 200 ) {
		$resultArray['error'] = TRUE;
		$resultArray['msg']   = $msg;

		http_response_code((int)$httpCode);

		foreach( $args as $key => $arg ){
			$resultArray[$key] = $arg;
		}

		echo json_encode( $resultArray );
		exit;
	}
}