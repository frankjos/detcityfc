<?php
require_once( '../../../wp-load.php' );

	// Do not edit this if you are not familiar with php
	error_reporting (E_ALL ^ E_NOTICE);
	$post = (!empty($_POST)) ? true : false;
	$error="";
	
	/* do validation */
	if(is_numeric($_POST['numberofpeople'])){
		$numberofpeople=$_POST['numberofpeople'];
	}else{
		$error.='<p>Enter number of people</p>';
	}
	
	if(is_numeric($_POST['contactphone'])){
		$contactphone=$_POST['contactphone'];
	}else{
		$error.='<p>Enter your contact number</p>';
	}

	if($_POST['contactname'] !=""){
		$contactname=$_POST['contactname'];
	}else{
			$error.='<p>Enter your Name</p>';
	}
		
	if($_POST['dateselect']!=""){
	$dateselect=$_POST['dateselect'];
	}else{
		$error.='<p>Select Reservation Date</p>';
	}
	if($_POST['reservationtime']!=""){
		$reservationtime=$_POST['reservationtime'];
	}else{
		$error.='<p>Select Reservation Time</p>';
	}

	if (filter_var($_POST['contactemail'], FILTER_VALIDATE_EMAIL)) {
		$contactemail=$_POST['contactemail'];
	}else {
		$error.='<p>Enter a valid  E-mail ID</p>';
	}
	/* end validation */

	//if error occurs display it, otherwise send the email 
	if(!$error){	

		//prepare and store reservation post data and update its meta data
		$reservationdata = array(
								'post_title' => $_POST['contactname'], 
								'post_type' => 'reservations', 
								'post_status' => 'publish'
								);
		$booking_id = wp_insert_post($reservationdata);
		$reservation_fields = array( 'numberofpeople', 'dateselect','reservationtime', 'reservationinstructions', 'contactphone', 'contactemail', 'status');

		foreach($reservation_fields as $reservationfields){
			update_post_meta($booking_id,$reservationfields,$_POST[$reservationfields]);
		}

		/** Prepare confirmation email to send **/
		$confirmation_message = get_option('atp_confirm'); //get email message
		$placeholders = array('[contact_name]','[number_of_people]','[reservation_date]','[reservation_time]','[restaurant_name]');
		$values = array("$contactname","$numberofpeople","$dateselect","$reservationtime",get_bloginfo('name'));
		$confirm_email_msg = str_replace($placeholders,$values,$confirmation_message); //replace the placeholders
		// admin Notification message
		$adminconfirmation_message = get_option('atp_notification_msg'); //get email message
		$placeholders = array('[contact_name]','[contact_email]','[number_of_people]','[reservation_date]','[reservation_time]','[restaurant_name]');
		$values = array("$contactname","$contactemail","$numberofpeople","$dateselect","$reservationtime",get_bloginfo('name'));
		$adminconfirm_email_msg = str_replace($placeholders,$values,$adminconfirmation_message); //replace the placeholders
	
		//subject
		$confirmation_subject = get_option('atp_confirmsubject');
		$placeholders = array('[restaurant_name]','[booking_id]');
		$values = array(get_bloginfo('name'),$booking_id);
		$confirm_email_subject = str_replace($placeholders,$values,$confirmation_subject); //replace the placeholders

			
		/** send email **/
		$client_email = $_POST['contactemail'];
		$admin_email = get_option('admin_email');
		$headers = 'From: ' . get_option('blogname') . ' Reservations <' .get_option('admin_email'). '>' . "\r\n\\";
		$adminheaders = 'From: ' . get_option('blogname') . ' Reservations <' .$client_email. '>' . "\r\n\\";
		// send to user mail
		wp_mail($client_email,$confirm_email_subject, $confirm_email_msg,$headers);
		// send to admin mail
		wp_mail($admin_email,$confirm_email_subject, $adminconfirm_email_msg,$adminheaders);
		
		
		$response = '<div class="messagebox success"><div class="messagebox_content">'.get_option('atp_booking_thankyou_msg').'</div></div>';

	}else{ //if error occurs in validation
		$response = '<div class="messagebox error"><div class="messagebox_content">'.$error.'</div></div>';
	}

echo $response
?>