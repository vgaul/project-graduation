<?php
     
	/* This function determines which shifts the user selected for inserting into the database.
	 */
	function extractSelectedShifts($details) {
		$selected= array();
		 
		foreach ($details as $key=>$shiftId) {
			if(substr($key, 0, 3) == "chk") {
				$selected[] = $shiftId;
			}//end if $key starts with chk
		}//end for each $details as $key=>$values
		 
		return $selected;
	}//end getShiftData
     
     
     /* This function determines which shifts the user selected for validation.
      */
     function getSelectedShifts($details) {
          $selectedRanges = array();
          
          foreach ($details as $key=>$shiftId) {
               if(substr($key, 0, 3) == "chk") {
                              $selectedRanges[$shiftId] = getTimeRange($shiftId);
               }//end if $key starts with chk
          }//end for each $details as $key=>$values
          
        return $selectedRanges;
    }//end getShiftData
    
    /* This function gets the total count for a particular shift.
     */
    function getShiftCount($shiftId){
    	global $db;
    	
    	$query = "select count(shiftId) from tblavailabilities
					where shiftId =:shiftId ;";
    	$statement = $db->prepare($query);
    	$statement->bindValue(':shiftId', $shiftId);
    	$statement->execute();
    	$results = $statement->fetch();
    	$statement->closeCursor();
    	
    	return $results[0];
    }//end getShiftCount

     /* This function gets the job name, start time, and end time from the database for any
      * shifts that overlap.
      */
     function getShiftInfo($shiftId) {
          global $db;
          
          $query = "Select s.shiftId, jobName, startTime, endTime
                    From tblshifts s
                    Inner Join tblnightofjobs j On s.JobId = j.JobId
                    Inner Join tbltimeranges t on s.RangeId = t.RangeId
                    Where shiftId = :shiftId;";
          $statement = $db->prepare($query);
          $statement->bindValue("shiftId", $shiftId);
          $statement->execute();
          $results = $statement->fetch();
          $statement->closeCursor();
          
          return $results;     
     }//end getOverLapInfo
     
     function getVolunteerShiftInfo($volunteerID){
     	global $db;
     	
     	$query = "Select jobName,  TIME_FORMAT(startTime,'%h:%i %p') as startTime, Time_Format(endTime,'%h:%i %p') as endTime
                    From tblshifts s
                    Inner Join tblnightofjobs j On s.JobId = j.JobId
                    Inner Join tbltimeranges t on s.RangeId = t.RangeId
					Inner Join tblavailabilities a on s.shiftId = a.shiftId
                     Where volunteerId = :volunteerId;";
     	$statement = $db->prepare($query);
     	$statement->bindValue("volunteerId", $volunteerID);
     	$statement->execute();
     	$results = $statement->fetchAll();
     	$statement->closeCursor();
     	
     	return $results;
     }
  
     /* This function removes all the shifts that have exceeded the max number of shifts for a particular shift.
      */
     function removeMaxShifts($shifts){
     	$noMaxShift = array();
     	
     	foreach ($shifts as $shift) {
     		if ($shift['maxVolunteers']>getShiftCount($shift['shiftId'])*1) {
     			$noMaxShift[]=$shift;
     		} //end if;
     	} //end for each
     	return $noMaxShift;
     	
     }
?>