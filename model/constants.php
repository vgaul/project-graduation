<?php
	/*This function will get the contact footer from the database.
	 *
	*/
	function getContactFooter() {
		global $db;
		$query = "select value from tblconstants where setting ='contactFooter'";
		$statement = $db->prepare($query);
		$statement->execute();
		$results = $statement->fetch();
		$statement->closeCursor();
	
		return $results[0];
	
	}
	
	/*This function will get all the e-mail settings from the database.
	 *
	*/
	function getEmailSettings(){
			
		Global $db;
	
		$query = "select * from tblconstants where setting like 'email%';";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$statement->closeCursor();
	
		$settings = array();
		foreach($result as $row){
			$settings[$row['setting']] = $row['value'];
	
		}//end for
	
		return $settings;
	}//end for
	
	/*This function will get the message for when there are no jobs.
	 *
	*/
	function getNoJobsMessage(){
			
		global $db;
		$query = "select value from tblconstants where setting ='noJobsAvailableMessage'";
		$statement = $db->prepare($query);
		$statement->execute();
		$results = $statement->fetch();
		$statement->closeCursor();
	
		return $results[0];
	
	}//end getNoJobsMessage

?>