<?php
		/*This function will set the e-mail body for the contact emails.
		 *
		*/
		function contactForm() {
			$message = '<html><body>';
			$message .= '<p>From: '.$_REQUEST['name'].'</p>';
			$message .= '<p>Email: '.$_REQUEST['email'].'</p>';
			$message .= '<p>'.$_REQUEST['message'].'</p>';
			$message .= "</body></html>";
			return $message;
		} //end function

		/*This function will set the e-mail body for the administrator each time a new person signs up.
		*
		*/
		function htmlAdminConfirmation(){
			Global $volunteerShiftInfo;
			Global $prepJobs;
			
			$message = '<html><body>';
			$message .= '<p>There is a new person that signed up.  Here are their details:</p>';
			$message .= '<table style="cellpadding="10">';
			$message .= "<tr><td><strong>First Name:</strong> </td><td>" . strip_tags($_REQUEST['firstName']) . "</td></tr>";
			$message .= "<tr><td><strong>Last Name:</strong> </td><td>" . strip_tags($_REQUEST['lastName']) . "</td></tr>";
			$message .= "<tr><td><strong>Street Address:</strong> </td><td>" . strip_tags($_REQUEST['street']) . "</td></tr>";
			$message .= "<tr><td><strong>Street Address 2:</strong> </td><td>" . strip_tags($_REQUEST['street2']) . "</td></tr>";
			$message .= "<tr><td><strong>City</strong> </td><td>" . strip_tags($_REQUEST['city']) . "</td></tr>";
			$message .= "<tr><td><strong>Zip Code:</strong> </td><td>" . strip_tags($_REQUEST['zipCode']) . "</td></tr>";
			$message .= "<tr><td><strong>Home Phone:</strong> </td><td>" . strip_tags($_REQUEST['homePhone']) . "</td></tr>";
			$message .= "<tr><td><strong>Cell Phone:</strong> </td><td>" . strip_tags($_REQUEST['cellPhone']) . "</td></tr>";
			$message .= "<tr><td><strong>E-mail:</strong> </td><td>" . strip_tags($_REQUEST['emailAddress']) . "</td></tr>";
	
			//Get Shift Info
			if(isset($_REQUEST['fullAvailability'])){
			 	$message .= "<tr><td><strong>Available All Night:</strong> </td><td>Will be assigned shifts where needed.</td></tr>";
			 }else {
			 	foreach ($volunteerShiftInfo as $shiftDetail) {
			 	$message.= "<tr><td><strong>".$shiftDetail['jobName'].":</strong> </td><td>". $shiftDetail['startTime']. " - " .$shiftDetail['endTime'] ."</td></tr>";
			 	}//end for each
			 }//end if				
			$message .= "<tr><td><strong>Comments:</strong> </td><td>" . strip_tags($_REQUEST['volunteerComments']) . "</td></tr>";
			$message .= "</table>";
			
			//Get Prep Volunteer Data
			
			if(count($prepJobs)> 0){
				$message .= '<table style="cellpadding="10">';
				$message .= "<tr><td>Volunteer signed up for the following committees:</td></tr>";
				foreach ($prepJobs as $job) {
					$message .= "<tr><td>". $job['prepJobName']. "</td></tr>";
					} //end for each
				$message .= "</table>";
			}//end if
			
			$message .= "</body></html>";
			
			return $message;
			}
		
		
		/*This function sets the e-mail body for person signing up for project graduation.
		* 
		*/
		function htmlSignUpConfirmation(){
			Global $volunteerShiftInfo;
			Global $prepJobs;
			Global $mailSettings;
			
			
			$message = '<html><body>';
			$message .= '<img src="'.$mailSettings['emailHeaderImageUrl'].'"/><br>';
			$message .= '<p>Thank you for volunteering at Project Graduation.</p>';
			$message .= '<p>The following is your sign up details- </p>';
			$message .= '<table style="cellpadding="10">';
			$message .= "<tr><td><strong>First Name:</strong> </td><td>" . strip_tags($_REQUEST['firstName']) . "</td></tr>";
			$message .= "<tr><td><strong>Last Name:</strong> </td><td>" . strip_tags($_REQUEST['lastName']) . "</td></tr>";
			
			//Get Shift Info
			 if(isset($_REQUEST['fullAvailability'])){
			 	$message .= "<tr><td><strong>Available All Night:</strong> </td><td>You will be assigned shifts where needed.</td></tr>";
			 }else {
			 	foreach ($volunteerShiftInfo as $shiftDetail) {
			 	$message.= "<tr><td><strong>".$shiftDetail['jobName'].":</strong> </td><td>". $shiftDetail['startTime']. " - " .$shiftDetail['endTime'] ."</td></tr>";
			 	}//end for each
			 }//end if				
			$message .= "</table>";
			
			//Get Prep Volunteer Data
			if(count($prepJobs)> 0){
				$message .= '<br><table style="cellpadding="10">';
				$message .= "<tr><td>Someone will be contacting you regarding:</td></tr>";
				foreach ($prepJobs as $job) {
					$message .= "<tr><td>". $job['prepJobName']. "</td></tr>";
					} //end for each
				$message .= "</table>";
			}//end if
			
			$message .= '<p>'.$mailSettings['emailFooter'].'</p>';
			
			$message .= "</body></html>";

			return $message;
		}//end htmlSignUpConfirmation
		
		
		/*This function will send an e-mail.  It requires a to address, the type of e-mail body you want to send,and e-mail settings.
		 *
		*/
		function sendEmail($toEmail,$typeOfEmail,$mailSettings){	
			$mail = new PHPMailer();
				
			$mail->IsSMTP();                 								// set mailer to use SMTP
			$mail->Host = $mailSettings['emailHost'];  						// specify main and backup server
			$mail->Port = $mailSettings['emailPort'];						//SMTP Port
			$mail->SMTPSecure = $mailSettings['emailSmtpSecure'];			//SMTP Secure Method
			$mail->SMTPAuth = $mailSettings['emailSmtpAuth'];    			// turn on SMTP authentication
			$mail->Username = $mailSettings['emailUsername']; 				// SMTP username
			$mail->Password = $mailSettings['emailPassword']; 				// SMTP password
				
			$mail->From = $mailSettings['emailFrom'];						//From E-mail Address
			$mail->FromName = $mailSettings['emailFromName'];				//From Name
			$mail->AddAddress($toEmail); 	     							//To Address
			//$mail->AddAddBCC("something@email.com"); 	     			    //BCC Address
			//$mail->AddAddCC ("something@email.com"); 	     				//CC Address
			//$mail->AddReplyTo("info@example.com");   						// Optional, Changes the reply to address if someone clicks reply
				
			//$mail->Subject = "Here is the subject";							//Subject
			$mail->IsHTML(True);                                 		  	// set email format to HTML
			//$mail->Body    = "<h1>Hello World!<h1>";  					//HTML of message
			
			//Switch statement determines which e-mail body to use.
			switch ($typeOfEmail) {
				case 'signUpConfirmation':
					$mail->Subject = "Project Graduation Sign Up Details";
					$mail->Body = htmlSignUpConfirmation();
					break;
				case 'adminConfirmation':
					$mail->Subject = "New volunteer for project graduation";
					$mail->Body = htmlAdminConfirmation();
					break;
				case'contactForm':
					$mail->AddReplyTo($_REQUEST['email']);
					$mail->Subject = 'Someone has contacted you about Project Graduation';
					$mail->Body = contactForm();
					break;
			}//end switch
						
			$mail->AltBody = strip_tags($mail->Body);						// In case html formatting can't be viewed
			
			//$mail->WordWrap = 50;                                 		// set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz");         		// add attachments
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    		// optional name for attachment
			//"This is the message body <b>in bold!</b>";

			
			if(!$mail->Send()) {
				//couldn't send
				//echo "<br>There was an error sending your e-mail message";
				return false;
			} else {
				//successfully sent
				//echo "Your message was succesfully sent.";
				return true;
			}//end if
		}//end sendEmail
		
		/*This function will validate the details the user entered on the contact e-mail form.
		 *
		*/
		function validateContactEmail() {
			extract($_REQUEST);
			$errors= array();	//All the error messages;

			if($isJavascriptOn=='false'){
				//Validate if message body is blank.
				if($name==""){
					$errors['name']="Name is a required field.";
				}//end if
			
				//Validate E-mail (Make sure it is not blank and a valid E-mail Address.)
				if($email==""){
					$errors['email']= "E-mail Address is a required field.";
				}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					$errors['email']= "Please enter an email address using the following format:&#13;   johnsmith@sample.com";
				}//end if
				
				//Validate if message body is blank.
				if($message==""){
					$errors['message']="Message is a required field.";
				}//end if
			}//end if
			
			
			
			return $errors;
		
		} //end function
?>