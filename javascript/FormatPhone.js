//Version: 2012-03-07

//This script formats phone numbers according to the calling program's
//specifications.

//The first parameter is the phone number (text) to be formatted.
//The phone number can include special characters--they are removed before formatting.
//The phone number can include 7 or 10 digits (with or without area code).

//The second parameter designates either a formatting code or the phone number delimiter.
//The acceptable formatting codes are ) and G.  These can be provided in either upper or lower case.
//      G:  General. All special, non-numeric characters are removed and no formatting is applied.
//      (:  Formats (###) ###-####

//If neither of the above are used in the second parameter, the character sent as the
//second parameter is used as the delimiter between phone number parts.
//If the second parameter is omitted, dashes are used as the delimiter.

//To include this script in your HTML, simply import it:
//    <script type="text/javascript" src="formatPhone.js"></script>
//                                        (include path here)

//Sample calls:
//	phone = formatPhone(phone, "G");        //Removes all characters except digits
//	phone = formatPhone(phone, "(");        //Result in this format (715) 342-3121
//	phone = formatPhone(phone, ".");        //Result in this format 715.342.3121
//	phone = formatPhone(phone);    		    //Result in this format 715-342-3121

function formatPhone(phone, delimiter) {
	if(arguments.length==1) delimiter='-';
	
	//Remove the ( ) - . that may already be there
	phone = phone.replace(/\D/g, '');
	
	switch(delimiter.toUpperCase()) {
		case "(":
			//Format (xxx) xxx-xxxx
			//Add the last dash
			phone = phone.replace(/(\d{4})$/,'-$1');
			//Add ( ) if there's an area code
			if(phone.length>8) phone = phone.replace(/^(\d{3})/,'($1) ');
			break;
		case "G":
			//do nothing, just remove characters
			break;
		default:
			//Use the character the user sent in
			phone = phone.replace(/(\d{4})$/,delimiter + '$1');
			if (phone.length==11) 
				phone = phone.replace(/(\d{3})/,"$1" + delimiter); 
			break;
	}//end switch
	
	return phone;
}//end formatPhone
