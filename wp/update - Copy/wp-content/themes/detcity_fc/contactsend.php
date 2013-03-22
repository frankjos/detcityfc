<?php
require_once( '../../../wp-load.php' );

// Please refrain from editing below
error_reporting (E_ALL ^ E_NOTICE);

//if form submitted or posted, then do validation and send email
if(!empty($_POST)) {

	function ValidateEmail($email) 	{
		$regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		$eregi = preg_replace($regex,'', trim($email));
		return empty($eregi) ? true : false;
	}

	$name = stripslashes($_POST['name']);
	$to = trim($_POST['to']);
	$email = trim($_POST['email']);
	$subject = stripslashes($_POST['subject']);
	$message = stripslashes($_POST['message']);
	$phone = stripslashes($_POST['phone']);
	$answer = trim($_POST['answer']);
	$verificationanswer="4"; // Please change the answer for the captcha
	$error = '';
	$Reply=$to;
	$from=$to;
	
	// Name Validation
	if(!$name) {
		$error .= __('Please enter your name.','victoria_front');
		$error .= '<br />';
	}

	// Email Field Validation
	if(!$email) {
		$error .= __('Please enter e-mail address','victoria_front');
		$error .= '<br />';
	}

	// Email Validation
	if($email && !ValidateEmail($email)) {
		$error .= __('Please enter a valid e-mail address.','victoria_front');
		$error .= '<br />';
	}

	// Phone Validation
	if(is_numeric($phone)) {
		if(!$phone || strlen($phone) < 8) {
		$error .= __('Please enter your Phone Number. It should have 10 digits.','victoria_front');
		$error .= '<br />';
		}
		} else {
		$error .= __('Please enter numeric characters in Phone Number field.','victoria_front');
		$error .= '<br />';
		}

	// Subject Validation
	if(!$subject) {
		$error .= __('Please enter your subject.','victoria_front');
		$error .= '<br />';
	}

	// Captcha Validation
	if( $answer <> $verificationanswer) {
		$error .= __('Please enter the Correct verification number.','victoria_front');
		$error .= '<br />';
	}

	// Message Validation
	if(!$message || strlen($message) < 5) {
		$error .= __('Please enter your message. It should have at least 5 characters.','victoria_front');
		$error .= '<br />';
	}
	
	// Message Output
	if(!$error) {
		$messages ="Name: $name <br>";
		$messages.="Email: $email <br>";
		$messages.="Phone: $phone <br>";
		$messages.="Message: $message <br>";
		$emailto=$to;
		$mail = mail($emailto,$subject,$messages,"from: $email <$email>\nReply-To: $email \nContent-type: text/html");	
		if($mail) {
			echo 'OK';
		}
	} else { 
		echo '<div class="messagebox error"><div class="messagebox_content"><a class="close_note" href="#">close</a>'.$error.'</div></div>'; 
	} 
} 
?>