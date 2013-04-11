<form class='formStyle' id='frmVolunteer' method="post" action="">
     <?php $errors = ""; ?>
     <input type="hidden" name="action" value="volunteerDetails">
     
     <?php $firstName = (isset($details["firstName"]))?$details["firstName"]:""; ?>
     <label class="textlabel" for="txtFirstName">First Name:</label>
     <input type="text" name="firstName" id="txtFirstName" value="<?php echo $firstName; ?>" autoFocus>
     <img src="images/Error.gif" id="errFirstName" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "firstName")?>
     >
     <br>
     
     <?php $lastName = (isset($details["lastName"]))?$details["lastName"]:""; ?>
     <label class="textlabel" for="txtLastName">Last Name:</label>
     <input type="text" name="lastName" id="txtLastName" value="<?php echo $lastName; ?>">
     <img src="images/Error.gif" id="errLastName" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "lastName")?>
     >
     <br>
     
     <?php $street = (isset($details["street"]))?$details["street"]:""; ?>
     <label class="textlabel" for="txtStreet">Address:</label>
     <input type="text" name="street" id="txtStreet" value="<?php echo $street; ?>">
     <img src="images/Error.gif" id="errStreet" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "street")?>
     >
     <br>
     
     <?php $street2 = (isset($details["street2"]))?$details["street2"]:""; ?>
     <label class="textlabel" for="txtStreet2">Address Line 2:</label>
     <input type="text" name="street2" id="txtStreet2" value="<?php echo $street2; ?>">
     <img src="images/Error.gif" id="errStreet2" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "street2")?>
     >
     <br>
     
     <?php $city = (isset($details["city"]))?$details["city"]:""; ?>
     <label class="textlabel" for="txtCity">City:</label>
     <input type="text" name="city" id="txtCity" value="<?php echo $city; ?>">
     <img src="images/Error.gif" id="errCity" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "city")?>
     >
     <br>
     
     <?php $zipCode = (isset($details["zipCode"]))?$details["zipCode"]:""; ?>
     <label class="textlabel" for="txtZipCode">Zip Code:</label>
     <input type="text" name="zipCode" id="txtZipCode" value="<?php echo $zipCode; ?>">
     <img src="images/Error.gif" id="errZipCode" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "zipCode")?>
     >
     <br>
     
     <?php $homePhone = (isset($details["homePhone"]))?$details["homePhone"]:""; ?>
     <label class="textlabel" for="txtHomePhone">Home Phone:</label>
     <input type="text" name="homePhone" id="txtHomePhone" value="<?php echo $homePhone; ?>">
     <img src="images/Error.gif" id="errHomePhone" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "homePhone")?>
     >
     <br>
     
     <?php $cellPhone = (isset($details["cellPhone"]))?$details["cellPhone"]:""; ?>
     <label class="textlabel" for="txtCellPhone">Cell Phone:</label>
     <input type="text" name="cellPhone" id="txtCellPhone" value="<?php echo $cellPhone; ?>">
     <img src="images/Error.gif" id="errCellPhone" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "cellPhone")?>
     >
     <br>
     
     <?php $emailAddress = (isset($details["emailAddress"]))?$details["emailAddress"]:""; ?>
     <label class="textlabel" for="txtEmailAddress">Email Address:</label>
     <input type="text" name="emailAddress" id="txtEmailAddress" value="<?php echo $emailAddress; ?>">
     <img src="images/Error.gif" id="errEmailAddress" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "emailAddress")?>
     >
     <br>
     
     <?php $fullAvailability = (isset($details["fullAvailability"]))?$details["fullAvailability"]:""; ?>
     <input type="checkbox" name="fullAvailability" id="txtFullAvailability" value="<?php echo $fullAvailability; ?>">
     <label class="flow flowLabel" for="chkFullAvailability">Full Availability</label>
     <img src="images/Error.gif" id="errFullAvailability" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "fullAvailability")?>
     >
     <br>
     
     <?php $volunteerComments = (isset($details["volunteerComments"]))?$details["volunteerComments"]:""; ?>
     <label class="textlabel" for="txtVolunteerComments">Volunteer Comments:</label>
     <input type="text" name="volunteerComments" id="txtVolunteerComments" value="<?php echo $volunteerComments; ?>">
     <img src="images/Error.gif" id="errVolunteerComments" width="14" height="14" alt="Error icon"
     <?php echo createErrorVisibilityTitle($errors, "volunteerComments")?>
     >
     <br>
     
     <?php foreach ($nightOfJobList as $j) : ?>
          <label><?php echo $j['jobName']; ?></label>
          <br>
          <?php $shiftDetails = getShiftDetails($j['jobId']); ?>
          <?php foreach ($shiftDetails as $key=>$s) : ?>
               <input type="checkbox" id="chkShift" name="shift <?php echo $s['shiftId']; ?>" value="<?php echo $s['shiftId']; ?>" 
                     />
               <label class='flowlabel' for='chkUnion'><?php echo $s['timeRange'] ?></label>
               <br>
          <?php endforeach; //$shiftDetails as shiftDetail ?>
     <?php endforeach; //$nightOfJobList as job ?>
   
     <label>&nbsp;</label>    
     <button id="btnSubmit" name="btnSubmit" type="submit">
          Test My Form
     </button>
       
     <button id="btnReset" name="btnReset" type="reset">Reset</button>
 
</form>
