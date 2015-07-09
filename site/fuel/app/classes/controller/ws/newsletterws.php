<?php

class Controller_Ws_NewsletterWS extends Controller_WS{
	public function post_subscribe(){

		\Fuel\Core\Lang::load("global");

		$email = Input::json("email");

		if($email !== null && preg_match("/^[a-zA-Z0-9.!#$%&\"*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/", $email) === 1){
			// Call API
				$api = new \Libraries\Api();

				$return = $api->executeAPIMethod("POST", "newsletters", array("email" => $email));

			// Success/error
				if($return["code"] == 200){
					// Success
						$this->jsonSuccess(\Fuel\Core\Lang::get("subscribe_to_newsletter.success"), array("apiReturn" => $return));
				}
				else if($return["code"] == 412){
					$this->jsonSuccess(\Fuel\Core\Lang::get("subscribe_to_newsletter.already_subscribed"));
				}
				else{
					// Error...
						$this->jsonError(\Fuel\Core\Lang::get("subscribe_to_newsletter.error"));
				}
		}
		else{
			// Error, not valid...
				$this->jsonError(\Fuel\Core\Lang::get("subscribe_to_newsletter.error"));
		}
	}
}