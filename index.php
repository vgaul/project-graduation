<?php 
    require("model/nightofjob.php");
    require("model/prepjob.php");
    require("model/shift.php");
    require("model/timerange.php");
    require("model/volunteer.php");
    require("model/utilities.php");
    require("model/email.php");
    require("model/class.phpmailer.php");
    require("model/class.smtp.php");
    require("model/constants.php");
    require('model/connectprojectgraduation.php');

	

 $contactFooter = getContactFooter();
    if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
    else $action = "signUp";      
		switch($action) {
			case 'signUp':
				   $errors = '';
				   $maxFieldSizes=getVolunteerFieldSizes("tblvolunteers");
				   $shifts = makeShiftsArray();
				   $shifts = removeMaxShifts($shifts);
				   include("views/signUpEdit.php");
				   break;
			case 'signUpResults':
				extract($_REQUEST);
				$errors = validateVolunteerData();
				if(count($errors)==0)    {
					insertVolunteer();
					$maxVolunteerID = getMaxVolunteer();
					$prepJobIDS = array();
					$prepJobIDS = getPrepJobIDArray();
					if(count($prepJobIDS)> 0)    {
						insertPrepVolunteers($prepJobIDS,$maxVolunteerID);
					}//end if
					
					 if(!isset($_REQUEST['fullAvailability'])){
						$selectedShifts = extractSelectedShifts($_REQUEST);
						insertVolunteerAvailabilities($selectedShifts, $maxVolunteerID);
					}//end if
					
					$volunteerShiftInfo = getVolunteerShiftInfo($maxVolunteerID);
					$prepJobs = getVolunteerPrepJobs($maxVolunteerID);
					$mailSettings = array();
					$mailSettings = getEmailSettings();
					
					//Send Volunteer Confirmation
					$didEmailSend = sendEmail($emailAddress,'signUpConfirmation',$mailSettings);
					
					//Send the admin confirmation.  Uncomment line below when going live.
					//sendEmail($mailSettings['emailAdmin'], 'adminConfirmation', $mailSettings);
					
					include("views/signUpResults.php");
				} else {
					$details = $_REQUEST;
					$maxFieldSizes=getVolunteerFieldSizes("tblvolunteers");
					$shifts = makeShiftsArray();
					$shifts = removeMaxShifts($shifts);
					include("views/signUpEdit.php");
				}//end if
				break;
			case 'email':
				$errors = "";
				include("views/email.php");
				break;
			case 'contactEmailSend':
				$errors = validateContactEmail();
				if(count($errors)==0)    {
					$mailSettings = array();
					$mailSettings = getEmailSettings();
					//Uncomment line below when going live.
					//$didEmailSend=sendEmail($mailSettings['emailAdmin'],'contactForm',$mailSettings);
					include("views/contactEmailResults.php");
				} else {
					$details = $_REQUEST;
					include("views/email.php");
				}//end if
				break;
        default:
            "Unknown action : $action";
		}//end switch
?>