<?php require_once( '../../../../../wp-load.php' ); ?>
<?php
$your_email=$_POST['contact_widgetemail'];
$success_message=trim($_POST['contact_success']);
if(isset($_POST['contact_name'])) {
	if(trim($_POST['contact_name']) === '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	if(trim($_POST['contact_email']) === '')  {
		$hasError = true;
	} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", trim($_POST['contact_email']))) {
		$hasError = true;
		$errorMessage =  'Please enter a valid email address!';
	} else {
		$email = trim($_POST['contact_email']);
	}

	if(trim($_POST['contactcomment']) === '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['contactcomment']));
		} else {
			$comments = trim($_POST['contactcomment']);
		}
	}

// send email
	if(!isset($hasError)) {
		$emailTo = $your_email;
		$subject = 'Contact Form Submission from '.$name;
		// message bid====
		$body  ="Name: $name \n\n";
		$body .="Email: $email \n\n";
        $body .="Message: $comments";
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
} 
?>
<?php if(isset($emailSent) == true) { ?>
<div class="messagebox success">
<?php if($success_message){ echo '<div class="messagebox_content s">'.$success_message.'</div>'; }else{ ?>
	<div class="messagebox_content s1"><?php _e('Thank you', 'victoria_front'); ?> <strong><?php echo $name;?></strong>.<br> <?php _e('Your message was successfully sent.', 'victoria_front'); ?></div><?php } ?>
</div>
<?php } ?>
<?php if(isset($hasError) ) { ?>
<div class="messagebox error">
	<div class="messagebox_content"><?php echo $errorMessage;?></div>
</div>
<?php } ?>