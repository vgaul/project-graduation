<?php
     /* This function formats a time so it can be validated
      */
     function createDateTime($time) {
          if ( $time < '12:00' ) {
               $string = 'tomorrow' . $time;
               $result = new DateTime($string);
          } else {
               $string = 'today' . $time;
               $result = new DateTime($string);
          }//end if $time < 12:00pm
                   
          return $result;
     }//end formatTime
     
     /* This method defines an error markers visibility and title based
      * on whether an error for this field exists.
      */
     function createErrorVisibilityTitle($errors, $fieldName) {
     	if(isset($errors[$fieldName])) 
     		return "style='visibility:visible' title='$errors[$fieldName]'"; 
     	else
     		return "style='visibility:hidden'";
     	//end if
     		
     }//end createVisibilityTitle
     
     /* This method defines the fieldShifts error marker's visibility based
      * on whether an error for fieldShifts exists.
      */
     function createFieldSetError($errors, $fieldName) {
               if(isset($errors[$fieldName])) {
                    if(is_array($errors[$fieldName])) {
                         $errorTitle = 'The following shifts overlap:' . '&#13;';
                         foreach ($errors[$fieldName] as $key=>$shiftId) {
                              $shiftInfo = getShiftInfo($shiftId);
                              $errorTitle .= '   ' . $shiftInfo['jobName'] . ': ' . formatTime($shiftInfo['startTime']) . '-' . formatTime($shiftInfo['endTime']) . '&#13;';
                              }//end foreach $overlapInfo
                    } else {
                         $errorTitle = $errors[$fieldName];
                    }//end if $errors[$fieldName] is an array
                    return "style='visibility:visible' title='$errorTitle'";
               } else {
                    return "style='visibility:hidden'";
               }//end if $errors[$fieldName] is set

          
          return $errors;
     }//end createFieldShiftsError
          
     /* This function formats a phone number
      */
     function formatPhone($phone, $delimiter='-') {
          //Remove the ( ) - . that may already be there
          $phone = preg_replace('/\D/', '', $phone);
          
          switch(strtoupper($delimiter)) {
               case "(":
                    //Format (xxx) xxx-xxxx
                    //Add the last dash
                    $phone = preg_replace('/\d{4}$/','-$0',$phone);
                    //Add ( ) if there's an area code
                    if(strlen($phone)>8) $phone = preg_replace('/^\d{3}/','($0) ',$phone);
                    break;
               case "G":
                    //do nothing, just remove characters
                    break;
               default:
                    //Use the character the user sent in
                    $phone = preg_replace('/\d{3}/','$0'.$delimiter,$phone,2);  //max twice
                    break;
          }//end switch
          
          return $phone;
     }//end formatPhone
     
     /* This function formats a time.
      */
     function formatTime($time) {
          $time = new DateTime($time);
          $time = $time->format('g:ia');
          
          return $time;         
     }//end formatTime
     
     /* This function removes special formatting values from strings that represent numbers ($ and comma).
      */
     function unformatValue($value) {
     	$value = str_replace('$','',$value);
     	$value = str_replace(',','',$value);
     	
     	if (is_numeric($value)) $value *= 1; //Convert to a number
     	
     	return $value;  
     }//end unformatValue
     
     /* This function accepts a string and determines if it is a valid date.
      */
     function isDate($date)
     {
     	try
     	{
     		$d = new DateTime($date);
     		return true;
     	}
     	catch (Exception $e)
     	{
     		return false;
     	}
     }
     
     /* This function capitalizes the first letter of every word in the original string
        EXCEPT it leaves letters that are not the first letter alone (capitalization not changed)
        AND it does not capitalize prepositions (unless they were  originally capitalized by the user.
     
          Original source: http://blogs.sitepoint.com/2005/03/15/title-case-in-php/  slightly modified
          
     */
     function toTitleCase($orgText) {
          if($orgText!="") {
               // Our array of 'small words' which shouldn't be capitalized if
               // they aren't the first word. Add your own words to taste.
               $smallwordsarray = array(
                    "and","the","for","to","in","a","at","from","by","an","or","if","of","up","nor","but","is",
                    "then","else","when","on","off","out","over","into","with");
               $special = array("Mac", "Mc", "O'");
               
               // Split the string into separate words using space or - as delimiter
               $words = preg_split('/([ -]+)/', $orgText, -1, PREG_SPLIT_DELIM_CAPTURE);  //Split and remember what the delimiters were
               foreach ($words as $key => $word) {
                    // If this word is the first, or it's not one of our small words, capitalize the first letter.
                    if (($key == 0) or (!in_array($word, $smallwordsarray))) {
                         //Capitalize only the first letter
                         $word = strtoupper(substr($word,0,1)) . substr($word,1);
                    }// end if
     
                    //Capitalize the letters after those special starters
                    foreach($special as $item) {
                         $len = strlen($item);
                         if (strlen($word)>$len && substr($word,0, $len)=== $item) {  //Starts with item?
                              //Capitalize the letter after the special item
                              $word = substr($word, 0, $len) . strtoupper(substr($word,$len,1)) . substr($word,$len+1);
                         }//end if
                    }//end foreach
                    $words[$key]=$word;  //Save the changes
                    
               }// end foreach
     
               // Join the words back into a string (implode can't be used. Always uses sample delimiter)
               $newText = "";
               foreach($words as $item) $newText = $newText . $item;
               
               return $newText;
          } else
               return $orgText;
          //endif
     }// end function
?>