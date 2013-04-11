<?php
     /* This function compares the names of the overlapping jobs.
      * This function is used when sorting the overlapping jobs info array
      */ 
     function compareJobNames($a, $b) {
               
          return strnatcmp($a['jobName'], $b['jobName']);
     }//end compareJobNames

     /* This function gets a list of the night of jobs from the database
      */
     function getNightOfJobList() {
               global $db;
               
               $query = "Select jobId, jobName, jobDescription
                         From tblnightofjobs
                         Order By jobName"; 
               $statement = $db->prepare($query);
               $statement->execute();
               $results = $statement->fetchAll();
               $statement->closeCursor();
               
               return $results;
     }//end getNightOfJobList
         
     /* This function gets builds an array of shiftIds, job names, job descriptions, start times, end times, and maxVolunteers from the database.
      */
     function makeShiftsArray() {
          global $db;
          
          $query = "Select shiftId, jobName, jobDescription, startTime, endTime,maxVolunteers
                    From tblshifts s
                    Inner Join tblnightofjobs j On s.jobId = j.jobId
                    Inner Join tbltimeranges t On s.rangeId = t.rangeId
                    Where jobName <> 'floater'
                    Order By jobName";
          $statement = $db->prepare($query);
          $statement->execute();
          $results = $statement->fetchAll();
          $statement->closeCursor();
          
          return $results;          
     }//end makeShiftsArray
?>