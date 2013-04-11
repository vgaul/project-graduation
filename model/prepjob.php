<?php
     /* This function builds an array of preparation committees for use as display
     */
     function prepJobsArray(){
     global $db;
     
     $query = "Select *
               From tblprepjobs
               Order By prepJobName";
     $statement = $db->prepare($query);
     $statement->execute();
     $results = $statement->fetchAll();
     $statement->closeCursor();
     
     return $results;
    
     }//end prepJobsArray
     
    /* This function builds an array of preparation committee ids for use.
     */
	function getPrepJobIDArray() {
		$details = $_REQUEST;
		$selectedPrepID=  array();
		
		foreach ($details as $key=>$prepJobName) {
			if(substr($key, 0, 4) == "prep") {
				$selectedPrepID[] = getPrepJobID($prepJobName);
			}//end if $key starts with prep
		}//end for each $details as $key=>$values
		
		return $selectedPrepID;
	} //end function
  
	
	/* This function gets the committeeid from the database based upon the preb job name provided.
	 */
	function getPrepJobID($prepJobName) {
		global $db;
		$query = "select committeeId from tblprepjobs where prepJobName =:prepJobName ;";
		$statement = $db->prepare($query);
		$statement->bindValue(':prepJobName', $prepJobName);
		$statement->execute();
		$results = $statement->fetch();
		$statement->closeCursor();
		return $results[0];
	}//end getPrepJobID
	
	
	/* This function gets all the prepJobNames for a single volunteer from the database. 
	 */
	function getVolunteerPrepJobs($volunteerId) {
		global $db;
		 
		$query = "select prepJobName
					from tblprepvolunteers pv
					inner join tblprepjobs p on pv.committeeId = p.committeeId
					where volunteerID=:volunteerID";
		
		$statement = $db->prepare($query);
		$statement->bindValue(':volunteerID', $volunteerId);
		$statement->execute();
		$results = $statement->fetchAll();
		$statement->closeCursor();
		 
		return $results;
		
	}
	
	
?>