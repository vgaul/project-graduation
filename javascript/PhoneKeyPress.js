//Version: 2011-11-17

//This function checks keys intercepted by a keypress press event in an Integer text box, 
//accepting only digits or commas.
//Commas are accepted in any position.  Be sure to remove them before parsing.
//To use this script in your page:
//	1. Include a reference to this file in the <head> tag
//     <script type="text/javascript" src="IntegerKeyPress.js"></script>
//                                     (set the path as appropriate)
//
//  2. Add an onkeypress event handler for the text box or text areas of your choice. 

//Know issues:
// 1. In FF and Opera arrow keys become disabled
//		Arrow keys return keycode 37-40 which are the same as % ' & (   (weird)
// 2. User can enter a -, then move to the left of it and enter
//      additional characters.  I can't seem to find a way to 
//      detect the cursor position using IE.
// 3. Be sure your JavaScript removes excess characters before parsing the value
// 4. In Opera, if type - after digits, doesn't move to beginning of field. Always type - first.


function PhoneKeyPress(e) {
	e = e || window.event; //FF uses parameter, this is for IE
	
	var key = e.keyCode || e.which; //FF uses keycode, IE uses which
	var el = e.srcElement? e.srcElement : e.target;  //FF : IE
	var selText = getSelectedText(el);	

	switch (key) {
		case 8: //backspace (for FF)  and Tab (for FF)
		case 9: 
		case 48: //digits
		case 49:
		case 50:
		case 51:
		case 52:
		case 53:
		case 54:
		case 55:
		case 56: 
		case 57: 		
		case 45: //minus sign 	 
				return true;
					break;
					
		default: return false;  //All other keys are not accepted/ignored
	}//end switch
}//end IntegerKeyPress
	
