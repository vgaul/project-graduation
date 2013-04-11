<?php
	include("views/header.php");
?>
	<link href="css/results.css" rel="stylesheet" type="text/css">
	<div id="main">
		<br>
		
		<h2>Your sign up information</h2>
		
		
			<br>
			<div class='resultStyle'>
				<label>Name:</label> <label class='volunteer'><?php echo $firstName . ' ' . $lastName ?></label> <br>
				
				<?php
					if ($street != '' && $street2 != ''):
						echo "<label>Address: </label> $street<br> 
							  <label>&nbsp</label> <label class='volunteer'>$street2</label> <br>" ;
					elseif ($street != ''):
						echo "<label> Address: </label><label class='volunteer'>$street</label>  <br>";
					endif;
				?>
				
				<?php if ($city != ''): ?>
						<label>City: </label> 
						<label class='volunteer'><?php echo $city ?></label> <br>
				<?php endif; ?>
				
				<?php if ($zipCode != ''): ?>
						<label>Zip: </label>
						<label class='volunteer'><?php echo $zipCode ?></label> <br>
				<?php endif; ?>
				
				<?php if ($homePhone != ''): ?>
						<label>Home Phone: </label> 
						<label class='volunteer'><?php echo $homePhone ?></label> <br>
				<?php endif; ?>
				
				<?php if ($cellPhone != ''): ?>
						<label>Cell Phone: </label> 
						<label class='volunteer'><?php echo $cellPhone ?></label> <br>
				<?php endif; ?>
				
				<?php if ($emailAddress != ''): ?>
						<label>Email: </label> 
						<label class='volunteer'><?php echo $emailAddress ?></label> <br>
				<?php endif; ?>
			
			
			<br>
			<?php
				$prepJobs = prepJobsArray();
				$lead = 0;
				 foreach($prepJobs as $job) {
                    $selectedJob = $job['prepJobName']; 
					if(isset($_REQUEST["prep".$selectedJob])):
						if ($lead == 0):
							echo "<h4>You have helped with</h4>";
							echo "$selectedJob <br>";
							$lead ++;
						else:
							echo "$selectedJob <br>";
						endif;
					endif;
				
				}//foreach
				
			?>
			
			<?php 
				$shifts = makeShiftsArray();
				echo "<h4>You have selected to work</h4>";
                    if (isset($_REQUEST['fullAvailability'])) {
                         echo "<label>&nbsp</label>Any shift available";
                    } else {
                         foreach ($shifts as $shift) {
                              $chkShift = 'chk' . $shift['shiftId'];
     				     if (isset($_REQUEST[$chkShift])) {?>
							<label><?php echo "$shift[jobName]"; ?>:</label>
							<label class='time'><?php echo formatTime($shift['startTime']); ?> </label>
							<label class='to'>to</label> 
							<label class='time'><?php echo formatTime($shift['endTime']);?> </label>
                           <?php echo "<br>";
							  }//end if 
                         }//foreach
                    }//end if
			?>
			
			<?php if ($volunteerComments != ''): ?>
					<h4>Your comments</h4> 
					<?php echo "$volunteerComments" ?>
			<?php endif; ?>
		</div>
		
		
		<br>

	</div>
	
<?php
	include("views/footer.php");
?>