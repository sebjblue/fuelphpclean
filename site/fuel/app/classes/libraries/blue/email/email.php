<?php

namespace Libraries\Blue\Email;

use Fuel\Core\Lang;

class Email{
	public static function sendEmail(EmailOptions $emailOptions){
		// Load FuelPHP Email Package
			\Package::load("email");

		// Create an Email instance
			$email = \Email\Email::forge();

		// Set the "email to"
			foreach($emailOptions->to as $to){
				$email->to($to);
			}

		// Set the subject
			$email->subject($emailOptions->subject);

		// And set the body.
			$view = \View::forge('emails/' . $emailOptions->emailTypeName, $emailOptions->vars);

			$email->html_body($view);

		// Try sending the email
			try{
				$response = $email->send();
			}
			catch(\EmailValidationFailedException $e){
				$response = false;
			}
			catch(\EmailSendingFailedException $e){
				$response = false;
			}
			catch(\Exception $e){
				$response = false;
			}

		return $response;
	}
}
