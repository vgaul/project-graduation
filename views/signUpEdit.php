<?php
     include("views/header.php");
?>
	<script type="text/javascript" src="javascript/IntegerKeyPress.js"></script>
	<script type="text/javascript" src="javascript/PhoneKeyPress.js"></script>
	<script type="text/javascript" src="javascript/toTitleCase.js"></script>
	<script type="text/javascript" src="javascript/FormatPhone.js"></script>
	<script type="text/javascript" src="javascript/index.js"></script>	
	<script type='text/javascript'>
	var shifts = [];		
	var prepJobs = [];

          <?php
			   $prepJobs = prepJobsArray();
               
               //Convert PHP array to JavaScript array of Shifts
               echo("\n");  //Align javaScript source (analness)
               echo "shifts = ['id', 'startTime', 'endTime'];\n  
               shifts['id'] =[];\n
               shifts['startTime']=[];\n
               shifts['endTime']=[];\n";
               
               foreach($shifts as $shift)
               {
                    echo "shifts['id'].push(" . "'" . $shift["shiftId"] . "'" . ");\n
                    shifts['startTime'].push(" . "'" . $shift["startTime"] . "'" . ");\n
                    shifts['endTime'].push(" . "'" . $shift["endTime"] . "'" . ");\n";
               }
			   
			   echo "prepJobs = ['name'];\n
			   prepJobs['name'] = [];\n";
			   
			   foreach($prepJobs as $job)
			   {
					echo "prepJobs['name'].push(" . "'" . $job["prepJobName"] . "'" . ");\n";
			   }
			   
			   
          ?>
     </script>
     <link href="css/forms.css" rel="stylesheet" type="text/css">
	
	<div id="main">
		<noscript>
			<br>
			<div class='noscript'>
				<span class='exclamation' style='padding-right: 150px;'>!</span>
				You currently have JavaScript turned off. 
				<span class='exclamation' style='padding-left: 150px;'>!</span>
				<br>
				It will be easier for you to volunteer with it enabled.
			</div>
		</noscript>
		<form id='signUp' name='signUp' class='formStyle' method ='post' action='.'>
			<input type="hidden" name="action" value="signUpResults">
			<input type="hidden" id="isJavascriptOn" name="isJavascriptOn" value="false">
			
			<img src="images/error.png" id="errDuplicate" width="20" height="20" alt="Error icon"
					<?php echo createErrorVisibilityTitle($errors, "duplicate")?>>
			
			<div class='volunteer'>
				
				<div class='left'>				
					<?php $firstName = (isset($details["firstName"]))?$details["firstName"]:""; ?>
					<label for='txtFirstName'>First Name:</label>
					<input type='text' name='firstName' tabindex='1' id='txtFirstName' size='15' maxlength='<?php echo $maxFieldSizes['firstName'];?>' value='<?php echo $firstName; ?>' >
					<img src="images/error.png" id="errFirstName" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "firstName")?>
					>
					<br>
					<?php $street = (isset($details["street"]))?$details["street"]:""; ?>
					<label for='txtStreet'>Street Address:</label>
					<input type='text' name='street' id='txtStreet' tabindex='3' size='25' maxlength='<?php echo $maxFieldSizes['street'];?>' value="<?php echo $street; ?>" >
					<img src="images/error.png" id="errStreet" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "street")?>
					>
					<br>
					<?php $city = (isset($details["city"]))?$details["city"]:""; ?>
					<label for='txtCity'>City:</label>
					<input type='text' name='city' id='txtCity' tabindex='5' size='25' maxlength='<?php echo $maxFieldSizes['city'];?>' value="<?php echo $city; ?>">
					<img src="images/error.png" id="errCity" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "city")?>
					>
					<br>
					<?php $homePhone = (isset($details["homePhone"]))?$details["homePhone"]:""; ?>		
					<label for='txtHomePhone'>Home Phone:</label>
					<input type='text' name='homePhone' id='txtHomePhone' tabindex='7' size='13' maxlength='<?php ?>' value="<?php echo $homePhone; ?>">
					<img src="images/error.png" id="errHomePhone" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "homePhone")?>
					>
					<br>
					<?php $emailAddress = (isset($details["emailAddress"]))?$details["emailAddress"]:""; ?>
					<label for='txtEmailAddress'>Email:</label>
					<input type='text' name='emailAddress' id='txtEmailAddress' tabindex='9' size='25' maxlength='<?php echo $maxFieldSizes['emailAddress'];?>' value="<?php echo $emailAddress; ?>">
					<img src="images/error.png" id="errEmailAddress" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "emailAddress")?>
					>
				
				</div>
			
				<div class='right'>
					<?php $lastName = (isset($details["lastName"]))?$details["lastName"]:""; ?>
					<label for='txtLastName'>Last Name:</label>
					<input type='text'  name='lastName' id='txtLastName' tabindex='2' size='15' maxlength='<?php echo $maxFieldSizes['lastName'];?>' value="<?php echo $lastName; ?>" >
					<img src="images/error.png" id="errLastName" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "lastName")?>
					>
					<br>
					<?php $street2 = (isset($details["street2"]))?$details["street2"]:""; ?>
					<label for='txtSreet2'>Address 2:</label>
					<input type='text' name='street2' id='txtStreet2' tabindex='4' size='25' maxlength='<?php echo $maxFieldSizes['street2'];?>' value="<?php echo $street2; ?>" >
					<img src="images/error.png" id="errStreet2" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "street2")?> 
					>
					<br>
					<?php $zipCode = (isset($details["zipCode"]))?$details["zipCode"]:""; ?>
					<label for='txtZipCode'>Zip Code:</label>
					<input type='text' name='zipCode' id='txtZipCode' tabindex='6' size='5'  maxlength='<?php echo $maxFieldSizes['zipCode'];?>' value="<?php echo $zipCode; ?>" >
					<img src="images/error.png" id="errZipCode" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "zipCode")?>
					>
					<br>
					<?php $cellPhone = (isset($details["cellPhone"]))?$details["cellPhone"]:""; ?>
					<label for='txtCellPhone'>Cell Phone:</label>
					<input type='text' name='cellPhone' id='txtCellPhone' tabindex='8' size='13' maxlength='<?php ?>' value="<?php echo $cellPhone; ?>" >
					<img src="images/error.png" id="errCellPhone" width="14" height="14" alt="Error icon" 
					<?php echo createErrorVisibilityTitle($errors, "cellPhone")?>  
					>
				
				</div>
			</div>
			<br>
			
			<div class='committees'>
			
				<fieldset id='fieldPrepJobs' name='fieldPrepJobs'>

					<h2>
						Committee work prior to the evening of project grad
					</h2>
			
					<?php
					$prepJobs = prepJobsArray();
					echo("\n");
					
					foreach($prepJobs as $job) :?>
					<?php $prepjob = "prep". str_replace(" ", "", $job['prepJobName']) ?>
					<?php $selectPrepJob = (isset($details[$prepjob]))?"checked":""; ?>	
						<input type ='checkbox' name='<?php echo $prepjob ;?>' id='<?php echo "chk".$job['prepJobName'];?>' value='<?php echo $job['prepJobName']; ?>' <?php echo $selectPrepJob; ?>>
						<label for='<?php echo $job['prepJobName'];?>' > <?php echo $job['prepJobName']; ?> </label>
				
					<?php endforeach;	?>
					<br>
					<br>
			
				</fieldset>	
			</div>

			<?php		

				$hldName = '';
			?>
			<br>
			
			<fieldset id='fieldShifts' name='fieldShifts'>
			
				<h2>
					Working The Night of Project Grad
				</h2>
			
						
				<div class='nightOfJobs'>		 
					<?php if(count($shifts)> 0): ?>		 
						<label for="chkFullAvailability"><strong>Available All Night</strong></label>
						<input type="checkbox" name="fullAvailability" id="chkFullAvailability" value="fullAvailability" <?php echo (isset($details["fullAvailability"]))?"checked":""; ?>>
						<img src="images/error.png" id="errFullAvailability" width="14" height="14" alt="Error icon"
						<?php echo createErrorVisibilityTitle($errors, "fullAvailability")?>>
						<br>
						
						<img src="images/error.png" id="errFieldShifts" width="14" height="14" alt="Error icon" 
						<?php echo createFieldSetError($errors, "fieldShifts")?>>
						<?php foreach($shifts as $shift): ?>
						 	<?php if ($hldName != $shift['jobName']) : ?>
							<br>
							<br>
								
							<label title='<?php echo $shift['jobDescription']; ?>'> <?php echo $shift['jobName']; ?>:</label> 
							<?php $hldName =  $shift['jobName']; ?>
						<?php endif; ?>
						
						<?php $chkShift = 'chk' . $shift['shiftId']; ?>
						<?php $selectShift = (isset($details[$chkShift]))?"checked":""; ?>    
						<input type ='checkbox'  name='<?php echo "chk".$shift['shiftId']; ?>' id='<?php echo $chkShift; ?>' value='<?php echo $shift['shiftId']; ?>' <?php echo $selectShift ?>>
						<label name='<?php echo $shift['shiftId'];?>' id='<?php echo $shift['shiftId'];?>' for='<?php echo $shift['shiftId']; ?>'> <?php echo formatTime($shift['startTime']); ?> to <?php echo formatTime($shift['endTime']); ?></label>
					
					
						<?php endforeach; ?>
					<?php else: ?>
						<p><?php echo getNoJobsMessage();?><p>
					<?php endif; ?>
					<br>
				</div>
				
				<div class="help">
				<img src="images/helpIcon.png" width="14" height="14" alt="Help icon" style='float:left'>
				<label><a href='views/jobDescriptions.php' target='_Blank'>Click Here</a> for job descriptions.</label>
				</div>
				
			</fieldset>
			<br>
			<br>
			
			<div class='comments'>
				<label for='txtVolunteerComments'>Comments:</label>
				<br>
				
				<?php $volunteerComments = (isset($details["volunteerComments"]))?$details["volunteerComments"]:""; ?>
				<textarea name='volunteerComments' id='txtVolunteerComments' size='' cols='55' rows='6' maxlength='<?php ?>' ><?php echo $volunteerComments; ?></textarea>
				
				<img src="images/error.png" id="errVolunteerComments" width="14" height="14" alt="Error icon" 
				<?php echo createErrorVisibilityTitle($errors, "volunteerComments")?>>
				<br>
				
				<button type='submit' class='buttonStyle' id='btnSubmit' name='btnSubmit'>Submit Form</button>
				<button type='reset' class='buttonStyle' id='btnReset' name='btnReset'>Start Over</button>
			
			</div>
			<br>
			
		</form>
	</div>
<?php
	include("views/footer.php");
?>