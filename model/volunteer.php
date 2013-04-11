<?php
	
	/*This function will get the last volunteer from the database.
	 *
	*/
	function getMaxVolunteer() {
		global $db;
		$query = "select max(volunteerid) from tblvolunteers;";
		$statement = $db->prepare($query);
		$statement->execute();
		$results = $statement->fetch();
		$statement->closeCursor();
		return $results[0];
	}//end getMaxVolunteer
	
	
	/*This function will get the table column lengths out of the database
	 * 
	 */
	function getVolunteerFieldSizes($table) {
		Global $db;
		
		$query = "Show Columns From $table";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$statement->closeCursor();

		$columns = array();
		foreach($result as $row){
				if(stripos($row['Type'],'varchar')===0||(stripos($row['Type'],'char')===0)) {  //Note: triple = required. Not found is null ==0
						$columns[$row['Field']] = getSize($row['Type']);
				}//end if
		}//end for

		return $columns;
	}//end getFieldSizes
	
	/*This function will remove all values that are not a number.
	 *
	*/
	function getSize($type) {
		$size = preg_replace('/\D/',"",$type);

		return $size*1;
	}
	
	
	/*This function will insert a new volunteer into the database.
	 *
	*/
	function insertVolunteer() {
		global $db;
	
		extract($_REQUEST);
	
		$homePhone= formatPhone($homePhone, "G");  //Remove formatting
		$cellPhone= formatPhone($cellPhone, "G");  //Remove formatting
		
		//Title Case these fields if Javascript is off
		if($isJavascriptOn=="false"){
			$firstName= toTitleCase($firstName);
			$lastName = toTitleCase($lastName);
			$street = toTitleCase($street);
			$street2 = toTitleCase($street2);
			$city = toTitleCase($city);
		}//end if

		$dateSubmitted = new DateTime();

		$fullAvailability = (isset($fullAvailability))?true:false;  //Deal with a checkbox
	
		$query = "Insert Into tblvolunteers(firstName, lastName, street,street2, city, zipCode, homePhone, cellPhone,
					emailAddress,fullAvailability,dateSubmitted,volunteerComments)
					
					Values (:firstName,:lastName,:street,:street2,:city,:zipCode,:homePhone,:cellPhone,
					:emailAddress,:fullAvailability,:dateSubmitted,:volunteerComments)";
		
		$statement = $db->prepare($query);

		$statement->bindValue(':firstName', 		$firstName);
		$statement->bindValue(':lastName', 			$lastName);
		$statement->bindValue(':street', 			($street=="")?null:$street);
		$statement->bindValue(':street2', 			($street2=="")?null:$street2);
		$statement->bindValue(':city', 				($city=="")?null:$city);					
		$statement->bindValue(':zipCode', 			($zipCode=="")?null:$zipCode);					
		$statement->bindValue(':homePhone', 		($homePhone=="")?null:$homePhone);					
		$statement->bindValue(':cellPhone', 		($cellPhone=="")?null:$cellPhone);
		$statement->bindValue(':emailAddress', 		($emailAddress=="")?null:$emailAddress);
		$statement->bindValue(':fullAvailability', 	$fullAvailability);
		$statement->bindValue(':dateSubmitted', 	$dateSubmitted->format('Y-m-d h:i'));
		$statement->bindValue(':volunteerComments', ($volunteerComments=="")?null:$volunteerComments);

		$statement->execute();
		$statement->closeCursor();
	
		return $statement->rowCount();
	}
	
	
	/*This function will insert volunteers that have selected to be part of a committiee(prepjob)
	 *
	*/
	function insertPrepVolunteers($prepJobIDS,$volunteerId) {
		global $db;
		
		foreach ($prepJobIDS as $jobID) {
			$query = "Insert Into tblprepvolunteers(committeeId,volunteerId,coordinator)	  
					 Values(:committeeId,:volunteerId,:coordinator)";
			$statement = $db->prepare($query);
			$statement->bindValue(':committeeId', $jobID);
			$statement->bindValue(':volunteerId', $volunteerId);
			$statement->bindValue(':coordinator', false);
			$statement->execute();
			$statement->closeCursor();
		} //end for each
	}//insertPrepVolunteers
	
	/*This function will insert volunteers that have selected to be part of a committee(prepjob)
	 *
	*/
	function insertVolunteerAvailabilities($shiftIDS,$volunteerId) {
		global $db;
	
		foreach ($shiftIDS as $shiftId) {
			$query = "Insert Into tblavailabilities(volunteerId ,shiftId,shiftComments)
					 Values(:volunteerId,:shiftId,:shiftComments)";
			$statement = $db->prepare($query);
			$statement->bindValue(':volunteerId',	$volunteerId);
			$statement->bindValue(':shiftId', 		$shiftId);
			$statement->bindValue(':shiftComments',	null);
			$statement->execute();
			$statement->closeCursor();
		} //end for each
	}//insertVolunteerAvailabilities
	
	
	/* This function checks to see if the given volunteer name is
	 * already in the database.
	*/
	function isDuplicateName($firstName, $lastName) {
		global $db;
	
		$query = "Select count(*) from tblvolunteers where firstName=:firstName And
		                                                  lastName=:lastName";
		$statement = $db->prepare($query);
		$statement->bindValue(':firstName', $firstName);
		$statement->bindValue(':lastName', $lastName);
		$statement->execute();
		$results = $statement->fetch();
		$statement->closeCursor();
	
		return $results[0]>0;
	
	}
	
	
	/*This function will validate all of the form inputs.
	 *
	*/
	function validateVolunteerData() {  //Come up with a sample title case example,
	    $selectedPrepJobs = getPrepJobIDArray($_REQUEST);
	    $selectedShifts = getSelectedShifts($_REQUEST);
	
		extract($_REQUEST);
		$errors= array();	//All the error messages
	
		$maxColumnSizes = array();
		$maxColumnSizes = getVolunteerFieldSizes("tblvolunteers");
			
	
		if ($_REQUEST['isJavascriptOn'] == "false") {
			//Validate First Name (Make sure it is not blank.)
			if($firstName ==""){
				$errors['firstName']= "First Name is a required field.";
			}//end if
				
			//Validate Last Name (Make sure it is not blank.)
			if($lastName ==""){
				$errors['lastName']= "Last Name is a required field.";
			}//end if
			
			//Validate E-mail (Make sure it is not blank and a valid E-mail Address.)
			if($emailAddress==""){
				$errors['emailAddress']= "E-mail Address is a required field.";
			}elseif(!filter_var($emailAddress,FILTER_VALIDATE_EMAIL)){
				$errors['emailAddress']= "Please enter an email address using the following format:&#13;   johnsmith@sample.com";
			}//end if
		}//end if
	
	
		//Consistency Checks

		if(strlen($firstName) > $maxColumnSizes['firstName']){
			$errors['firstName']= "The maximum characters for First Name cannot be greater than " .$maxColumnSizes['firstName'];
		}//end if
	
		if(strlen($lastName) > $maxColumnSizes['lastName']){
			$errors['lastName']= "The maximum characters for Last Name cannot be greater than " .$maxColumnSizes['lastName'];
		}//end if
	
		if(strlen($street) > $maxColumnSizes['street']){
			$errors['street']= "The maximum characters for Street cannot be greater than " .$maxColumnSizes['street'];
		}//end if
	
		if(strlen($street2) > $maxColumnSizes['street2']){
			$errors['street2']= "The maximum characters for Street 2 cannot be greater than " .$maxColumnSizes['street2'];
		}//end if
	
		if(strlen($city) > $maxColumnSizes['city']){
			$errors['city']= "The maximum characters for city cannot be greater than " .$maxColumnSizes['city'];
		}//end if
	
		//Validate Zip Code (Make sure it is a number, Make sure it is a total of 5 digits.)
		if($zipCode<>""){
			if(!is_numeric($zipCode)){
			$errors['zipCode']= "Please enter a valid zip code.";
		}elseif (strlen($zipCode) <> $maxColumnSizes['zipCode']){
			$errors['zipCode']= "The zip code needs to be " . $maxColumnSizes['zipCode']. " digits in order to be valid.";
			}//end if
		}//end if
		
		//Validate if both Home and Cell Phone are both blank.
		if($homePhone == "" && $cellPhone ==""){
			$errors['homePhone']= "Either Home Phone or Cell Phone is required.&#13;Please enter a phone number using the following format:&#13;   715-555-5555";
			$errors['cellPhone']= "Either Home Phone or Cell Phone is required.&#13;Please enter a phone number using the following format:&#13;   715-555-5555";
		}//end if
	
		//Validate Home Phone (Make sure it is numeric and it is equal to 10 digits.)
		If($homePhone <> ""){
			$homePhone=formatPhone($homePhone,"G");
			if(!is_numeric($homePhone)){
				$errors['homePhone']= "Please enter a phone number using the following format:&#13;   715-555-5555";
			}elseif(strlen($homePhone) <> $maxColumnSizes['homePhone']){
				$errors['homePhone']= "Your phone number contains too many digits.&#13;Please enter a phone number using the following format:&#13;   715-555-5555";
			}//end if
		}//end if
	
	
		//Validate Cell Phone (Make sure it is numeric and it is equal to 10 digits.)
		If($cellPhone <> ""){
			$cellPhone=formatPhone($cellPhone,"G");
			if(!is_numeric($cellPhone)){
				$errors['cellPhone']= "Please enter a phone number using the following format:&#13;   715-555-5555";
			}elseif(strlen($cellPhone) <> $maxColumnSizes['cellPhone']){
				$errors['cellPhone']= "Your phone number contains too many digits.&#13;Please enter a phone number using the following format:&#13;   715-555-5555";
			}//end if
		}//end if
	
		//Validate E-mail(Make sure the e-mail isn't greater than the database column)
		if(strlen($emailAddress) > $maxColumnSizes['emailAddress']){
			$errors['emailAddress']= "The e-mail length cannot be greater than " . $maxColumnSizes['emailAddress'];
		}//end if

          
          if(!isset($fullAvailability)) {
                    $prepCount = count($selectedPrepJobs);
                    $shiftCount = count($selectedShifts);             //The number of shifts the user selected
                    //Did the user select 0 or more than 3 shifts
                    if ($prepCount < 1 && $shiftCount < 1) {
                         $errors['fieldShifts'] = 'You must select either a committee or a shift.';
                    } else {
          		   $overlap = validateRanges($selectedShifts);
                       if (!empty($overlap)) {
                            $errors['fieldShifts'] = $overlap;
                       }//end if $overlap is not blank
                    }//end if 1 < $shiftCount < 3
               }//end if $fullAvailability is not set
     		
          	 //Check for duplicate records
              if(count($errors)==0) {
               	if(isDuplicateName($firstName, $lastName)){
               		$errors['duplicate'] = "$firstName $lastName is already in the database.";
               	}//end if
               }//end if
          
		return $errors;
	} //end function
?>
