<?php include("views/header.php");
 ?>
 	<script type="text/javascript" src="javascript/toTitleCase.js"></script>
	<script type="text/javascript" src="javascript/email.js"></script>

	<div id="emailDiv">
		<form id='signUp' name='signUp' class='emailStyle' method ='post' action='.'>
		<input type="hidden" name="action" value="contactEmailSend">
		<input type="hidden" id="isJavascriptOn" name="isJavascriptOn" value="false">
		<div class="email">
		<br>
		<?php $name= (isset($details['name']))?$details['name']:"" ?>
		<label title='Your Name.' for='txtName'>Your Name:</label>
		<input type='text'  name='name' id='txtName'  size='30' value="<?php echo $name; ?>">
		
		<img src="images/error.png" id="errName" width="14" height="14" alt="Error icon" 
		<?php echo createErrorVisibilityTitle($errors, "name")?>>
		
		<br>
		<br>
		<?php $email= (isset($details['email']))?$details['email']:"" ?>
		<label title='Your e-mail address here.' for='txtEmail'>Your E-mail:</label>
		<input type='text'  name='email' id='txtEmail'  size='30' value="<?php echo $email; ?>">
		
		<img src="images/error.png" id="errEmail" width="14" height="14" alt="Error icon" 
		<?php echo createErrorVisibilityTitle($errors, "email")?>>
		
		<br>

		<br>
		<?php $message= (isset($details['message']))?$details['message']:"" ?>
		<label title='Message' for='txtMessage'>Message:</label>
		<textarea name='message' id='txtMessage' size='' cols='40' rows='6'><?php echo $message; ?></textarea>
		
				
		<img src="images/error.png" id="errMessage" width="14" height="14" alt="Error icon" 
		<?php echo createErrorVisibilityTitle($errors, "message")?>>
		

		<button type='submit' class='buttonStyle' id='btnSubmit' name='btnSubmit'>Send</button>
		<br>
		</div>
		</form>
			<p style="text-align: center">
				<a href="JavaScript:window.close()">Cancel</a>
			</p>
	</div>
		

</body>

</html>