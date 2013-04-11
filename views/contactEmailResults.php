<?php include("views/header.php");
 ?>

	<div id="emailDiv">
		<div class="email">
			<?php if ($didEmailSend == true) : ?>
				<p>&nbsp;Thank You.  Someone will be contacting you regarding your message.</p>
			<?php else: ?>
				<p>There was an issue sending your e-mail.  Please e-mail <a href="mailto:<?php echo $mailSettings['emailAdmin']?>">
				   <?php echo $mailSettings['emailAdmin']?></a> your message directly.
				<p>
			<?php endif; ?>
			<p style="text-align: center">
				<a href="JavaScript:window.close()">Close</a>
			</p>
		</div>
		
	</div>
		

</body>

</html>