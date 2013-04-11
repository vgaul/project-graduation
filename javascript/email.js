var $errorShadow = "0px 0px 7px 1px #B22222";
var $errorBorder = "2px solid #000000";
var $homeBlurred = false;
var $cellBlurred = false;

var $ = function(id) 
{
	return document.getElementById(id); 
}

function DisplayValidity(control, marker, message, validity)
{
	if (!validity)
	{
		marker.title = message;
		marker.style.visibility = "visible";		
		control.style["boxShadow"] = $errorShadow;
		control.style.backgroundColor = "#DCDCDC";
		control.style.border = $errorBorder;
	}
	else
	{
		marker.title = message;
		marker.style.visibility = "hidden";
		control.style["boxShadow"] = "";
		control.style.backgroundColor = "";
		control.style.border = "";
	}
}

function ValidateEmailAddress()
{
	var ptr = $("txtEmail");
	var err = $("errEmail");
	var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	
	if (ptr.value !== "")
	{
		if (!ptr.value.match(emailPattern))
		{
			DisplayValidity(ptr, err,"Please enter an email address using the following format: johnsmith@sample.com",false);
		}
		else
		{
			DisplayValidity(ptr, err,"",true);
		}
	}
	else
	{
		DisplayValidity(ptr, err,"E-mail Address is a required field.",false);
	}
	return CheckError(err);
}

function ValidateName()
{
	var ptr = $("txtName");
	var err = $("errName");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
		DisplayValidity(ptr,err,"",true);
	}
	else
	{
		DisplayValidity(ptr,err,"Name is a required field.",false);
	}
	return CheckError(err);
}

function ValidateMessage()
{
	var ptr = $("txtMessage");
	var err = $("errMessage");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
		DisplayValidity(ptr,err,"",true);
	}
	else
	{
		DisplayValidity(ptr,err,"Message is a required field..",false);
	}
	return CheckError(err);
}

//This function accepts any number of parameters. Most are designated as conditions
//but they can also be flags. All parameters should evaluate to true/false.
function noShortCircuitAnd() 
{
	var result = true;

	for (var i=0; i<arguments.length; i++) 
	{
		result = result && arguments[i];    //go through each argument and AND it with the previous
	}
	return result;
}

//This function calls all validation functions on the form and if valid passes control to php validation
function ValidateForm(e)
{
	var returnValue = false;


	//Make sure all validation functions run
	if(noShortCircuitAnd(ValidateName(), ValidateMessage(), ValidateEmailAddress()))
	{
		returnValue = true;
	}
	
	else
	{
		alert("Correct all errors before the form can be submitted.");	
	}
	return returnValue;	
}

function CheckError(marker)
{
	var returnValue = false;
	
	if (marker.style.visibility == "hidden")
	{
		returnValue = true;
	}

	return returnValue;
}

window.onload = function()
{
	//Reset the form and checkboxes

	$("txtName").onblur = ValidateName;
	$("txtEmail").onblur = ValidateEmailAddress;
	
	$("txtMessage").onblur = ValidateMessage;
		
	$("btnSubmit").onclick = ValidateForm;
	
	$("isJavascriptOn").value = "true";
	
}