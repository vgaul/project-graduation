<?php
     /* This function checks two time ranges to see if they overlap.
      */
     function doRangesOverlap($range1, $range2) {
          $st1 = createDateTime($range1['startTime']);            //Start time for the first time range
          $et1 = createDateTime($range1['endTime']);              //End time for the first time range
          
          $st2 = createDateTime($range2['startTime']);            //Start time for the second time range
          $et2 = createDateTime($range2['endTime']);              //End time for the second time range
          
          //Check to see if ranges overlap     
          if (($st1 < $et2) && ($et1 > $st2)) {
               return true;             //Yes the ranges overlap
          } else {
               return false;            //No the ranges do not overlap
          }//end if startTime1 < endTime2 and endTime1 > startTime2 
     }//end doRangesOverlap
     
     /* This function gets the details of the time range with the given rangeId.
      */
     function getTimeRange($shiftId) {
          global $db;
          
          $query = "Select startTime, endTime
                    From tblshifts s
                    Join tbltimeranges t on s.rangeId=t.rangeId
                    Where s.shiftId = :shiftId
                    Order By startTime, endTime";
          $statement = $db->prepare($query);
          $statement->bindValue("shiftId", $shiftId);
          $statement->execute();
          $results = $statement->fetch();
          $statement->closeCursor();
          
          return $results;          
     }//end getRangeDetails
    
     /* This function checks each of the select time ranges to make sure that none of the ranges overlap.
      */
     function validateRanges($selectedShifts) {
          $overlap = array();           //Array containing the shiftIds of any overlapping time ranges.
          $errors = "";

               //Compare every shift against every other shift
               foreach ($selectedShifts as $sra=>$keya) {
                    foreach ($selectedShifts as $srb=>$keyb) {
                         //Don't compare one shift against itself
                         if ($sra != $srb) {
                              if (doRangesOverlap($keya, $keyb)) {
                                   //Only add shiftId to the array one time
                                   if (!in_array($sra, $overlap)) {
                                        $overlap[] = $sra;
                                   }//end if $overlap contains $keya
                                   
                                   //Only add shiftId to the array one time
                                   if (!in_array($srb, $overlap)) {
                                        $overlap[] = $srb;
                                   }//end if $overlap contains $keyb
                              }//end if DoRangesOverlap                         
                         }//end if $shifts[$shiftIdA] != $shifts[$shiftIdB]
                    }//end foreach shifts as $shiftIdB=>$rangeB
               }//end foreach shifts as $shiftIdA=>$rangeA
                         
          return $overlap;
     }//end validateRanges

?>