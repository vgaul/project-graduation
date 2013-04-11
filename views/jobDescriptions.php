<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Sheila Banovetz">
	<meta name="description" content="Project Graduation Header">
	<meta name="keywords" content="SPASH Logo">
	<title>SPASH Project Graduation</title>
	
	<link href="../css/projGrad.css" rel="stylesheet" type="text/css">
	<link href="../css/forms.css" rel="stylesheet" type="text/css">	
	
</head>

<body>
	
	<div id='header'>
		<img src='../images/spashlogo.jpg' width='955' height='110' alt='SPASH image' style='float:center'><br>
		<h1 style='margin-top:50px'><img src='../images/volunteerBanner.png'></h1>
	</div>

	<?php
		require('../model/connectprojectgraduation.php');
		require("../model/nightofjob.php");
		$shifts = makeShiftsArray();
		$hldName = ""
	?>
	
	<div id="main">
	<fieldset name='fieldShifts'>
		
		<?php foreach($shifts as $shift): ?>
			<?php if ($hldName != $shift['jobName']) : ?>
				<label><strong> <?php echo $shift['jobName']; ?>:</strong></label>
				<label><?php echo $shift['jobDescription']; ?></label>
				<?php $hldName =  $shift['jobName']; ?>
				<br>
				<br>
			<?php endif; ?>

	<?php endforeach; ?>
	
	</fieldset>
	
	</div>


</body>

</html>










