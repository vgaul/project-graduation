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

function ValidateFirstName()
{
	var ptr = $("txtFirstName");
	var err = $("errFirstName");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
		DisplayValidity(ptr,err,"",true);
	}
	else
	{
		DisplayValidity(ptr,err,"Enter your first name, this is required.",false);
	}
	return CheckError(err);
}

function ValidateLastName()
{
	var ptr = $("txtLastName");
	var err = $("errLastName");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
		DisplayValidity(ptr,err,"",true);
	}
	else
	{
		DisplayValidity(ptr,err,"Enter your last name, this is required.",false);
	}
	return CheckError(err);
}

function ValidateStreet()
{
	var ptr = $("txtStreet");
	var err = $("errStreet");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
	}
	return CheckError(err);
}

function ValidateStreet2()
{
	var ptr = $("txtStreet2");
	var err = $("errStreet2");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
	}
	return CheckError(err);
}

function ValidateCity()
{
	var ptr = $("txtCity");
	var err = $("errCity");
	if (ptr.value !== "")
	{
		ptr.value = ptr.value.toTitleCase();
	}
	return CheckError(err);
}

function ValidateZipCode()
{
	var ptr = $("txtZipCode");
	var err = $("errZipCode");
	var zipPattern = /^\d{5}$/;
	
	if (ptr.value != "")
	{
		if (!ptr.value.match(zipPattern))
		{
			DisplayValidity(ptr,err,"Enter a five digit zip code.",false);
		}
		else
		{
			DisplayValidity(ptr,err,"",true);
		}
	}
	else
	{
		DisplayValidity(ptr,err,"",true);
	}
	return CheckError(err);
}

function PhoneBlur(e)
{
	e = e || window.event;
	var el = e.srcElement? e.srcElement : e.target;
	
	switch (el.id)
	{
		case "txtCellPhone":
			$cellBlurred = true;
			break;
		
		case "txtHomePhone":
			$homeBlurred = true;
			break;
			
		case "btnSubmit":
			$homeBlurred = true;
			$cellBlurred = true;
			break;
	}
}

function ValidatePhone(e)
{
	PhoneBlur(e);
	
	var txtCellPhone = $("txtCellPhone");
	var txtHomePhone = $("txtHomePhone");
	var errCellPhone = $("errCellPhone");
	var errHomePhone = $("errHomePhone");
	var returnValue = false;
	
	//Clear errors
	DisplayValidity(txtCellPhone, errCellPhone,"",true);
	DisplayValidity(txtHomePhone, errHomePhone,"",true);
	
	if (txtCellPhone.value === "" && txtHomePhone.value === "" && $cellBlurred && $homeBlurred)
	{
		DisplayValidity(txtCellPhone, errCellPhone,"At least one 10 digit phone number is required.",false);
		DisplayValidity(txtHomePhone, errHomePhone,"At least one 10 digit phone number is required.",false);
	}
	else
	{
		if (txtCellPhone.value !== "")
		{
			txtCellPhone.value = formatPhone(txtCellPhone.value, "G");
			
			if (!txtCellPhone.value.match(/^\d{10}$/))
			{
				DisplayValidity(txtCellPhone, errCellPhone,"Enter a 10 digit phone number",false);
			}
			else
			{
				DisplayValidity(txtCellPhone, errCellPhone,"",true);
				txtCellPhone.value = formatPhone(txtCellPhone.value);
			}
		}
		
		if (txtHomePhone.value !== "")
		{
			txtHomePhone.value = formatPhone(txtHomePhone.value, "G");
		
			if (!txtHomePhone.value.match(/^\d{10}$/))
			{
				DisplayValidity(txtHomePhone, errHomePhone,"Enter a 10 digit phone number",false);
			}
			else
			{
				DisplayValidity(txtHomePhone, errHomePhone,"",true);
				txtHomePhone.value = formatPhone(txtHomePhone.value);
			}
		}
	}
	
	if (CheckError(errCellPhone) && CheckError(errHomePhone))
	{
		returnValue = true;
	}
	return returnValue;
}

function ValidateEmailAddress()
{
	var ptr = $("txtEmailAddress");
	var err = $("errEmailAddress");
	var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	
	if (ptr.value !== "")
	{
		if (!ptr.value.match(emailPattern))
		{
			DisplayValidity(ptr, err,"Enter an email, this is required.",false);
		}
		else
		{
			DisplayValidity(ptr, err,"",true);
		}
	}
	else
	{
		DisplayValidity(ptr, err,"Enter an email, this is required,\nenter in the format of: jane123@gmail.com.",false);
	}
	return CheckError(err);
}

function ValidateComments()
{
	ptr = $("txtVolunteerComments");
	err = $("errVolunteerComments");
	return CheckError(err);
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
	var functionsValidated = false;
	var checkboxesValidated = false;
	var returnValue = false;
	var shiftCount = 0;
	var committeeCount = 0;

	//Make sure all validation functions run
	if(noShortCircuitAnd(ValidateFirstName(), ValidateLastName(), ValidateStreet(),
	ValidateStreet2(), ValidateCity(), ValidateZipCode(),ValidatePhone(e), ValidateEmailAddress(), ValidateComments()))
	{
		functionsValidated = true;
	}
	
	//See if they have selected a shift
	if ($("chkFullAvailability").checked)
	{
		shiftCount += 1;
	}
	else
	{
		for (var i = 0; i < shifts["id"].length; i++)
		{
			if ($("chk" + shifts["id"][i]).checked)
			{
				shiftCount += 1;
			}
		
			if (shiftCount > 0)
			{
				break;
			}
		}
	}
	
	//See if they have selected a committee
	for (var i = 0; i < prepJobs["name"].length; i++)
	{
		if ($("chk" + prepJobs["name"][i]).checked)
		{
			committeeCount += 1;
		}
		
		if (committeeCount > 0)
		{
			break;
		}
	}
	
	//If they have selected at least one shift or committee, checkboxes are valid
	if (shiftCount > 0 || committeeCount > 0)
	{
		checkboxesValidated = true;
	}
	else
	{
		DisplayCheckboxValidity(false);
	}	
	
	if (functionsValidated && checkboxesValidated)
	{
		returnValue = true;
	}
	else
	{
		alert("Correct all errors before the form can be submitted.");	
	}
	return returnValue;	
}

function CheckTimeRanges()
{
	var selectedShifts = ["id", "startTime", "endTime"];
	selectedShifts["id"]=[];
	selectedShifts["startTime"]=[];
	selectedShifts["endTime"]=[];	

	//Remove form validation error highlighting
	DisplayCheckboxValidity(true);
	
	for (var i = 0; i < shifts["id"].length; i++)
	{
		var id = "chk" + shifts["id"][i];
		
		//Enable all of the shift checkboxes
		$(id).disabled = false;
		
		if ($(id).checked)
		{//Load the selectedShifts array with ids of checked checkboxes
		
			selectedShifts["id"].push(id.substring(3));
		}
	}

	//Load the selectedShifts array with start and end times
	for (var s = 0; s < shifts["id"].length; s++)
	{
		for (var ss = 0; ss < selectedShifts["id"].length; ss++)
		{
			if (selectedShifts["id"][ss] == shifts["id"][s])//keep as double equals
			{
				//Create pointer to start and end times
				selectedShifts["startTime"][ss] = shifts["startTime"][s];
				selectedShifts["endTime"][ss] = shifts["endTime"][s];
			}
		}
	}
	
	//Compare the selected shifts against all of the shifts and disable the checkboxes with conflicting times
	for (var s = 0; s < shifts["id"].length; s++) 
	{
		for (var ss = 0; ss < selectedShifts["id"].length; ss++) 
		{
			if (selectedShifts["id"][ss] != shifts["id"][s])//keep as double equals
			{//If we are not comparing the same shift
			
				if (((GetDay(selectedShifts["startTime"][ss]) < GetDay(shifts["endTime"][s])) && (GetDay(selectedShifts["endTime"][ss]) > GetDay(shifts["startTime"][s]))))
				{//If a shift is occurring within the same timeframe, disable it
				
					$("chk" + shifts["id"][s]).disabled = true;
					$("chk" + shifts["id"][s]).checked = false;
					
					//Change a conflicting shift's label to grey
					$(shifts["id"][s]).style.color = "#808080";
				}
			}
		}
	}
}

//Add '02:' or '01:' as a day for comparison
function GetDay(t)
{
	var d;

	//If it is before noon, it is tomorrow
	if (t < '12:00:00')
	{
		d = '02:' + t;
	}
	else
	{
		d = '01:' + t;
	}
	return d;
}

//Disable or enable shift checkboxes if chkFullAvailability is checked or unchecked
function ChkFullAvailabilityOnChange()
{
	//Remove form validation error highlighting
	DisplayCheckboxValidity(true);
	
	//Change all shift labels to black or grey
	for (var i = 0; i < shifts["id"].length; i++)
	{
		var id = "chk" + shifts["id"][i];
		
		if ($("chkFullAvailability").checked)
		{	
			//Change shift labels to grey
			$(shifts["id"][i]).style.color = "#808080";
			
			//Disable shift checkboxes
			$(id).disabled = true;
			$(id).checked = false;
		}
		else
		{
			//Change shift labels to black
			$(shifts["id"][i]).style.color = "#000000";
			
			//Enable shift checkboxes
			$(id).disabled = false;
		}
	}
}	

function PrepJobsOnChange()
{
	//Remove form validation error highlighting
	DisplayCheckboxValidity(true);
}	

function DisplayCheckboxValidity(validity)
{
	if (!validity)
	{
		$("fieldPrepJobs").style["boxShadow"] = $errorShadow;
		$("fieldPrepJobs").style.backgroundColor = "#DCDCDC";
		$("fieldPrepJobs").style.border = $errorBorder;
		$("fieldShifts").style["boxShadow"] = $errorShadow;
		$("fieldShifts").style.backgroundColor = "#DCDCDC";
		$("fieldShifts").style.border = $errorBorder;
	}
	else
	{
		$("fieldPrepJobs").style["boxShadow"] = "";
		$("fieldPrepJobs").style.backgroundColor = "";
		$("fieldPrepJobs").style.border = "";
		$("fieldShifts").style["boxShadow"] = "";
		$("fieldShifts").style.backgroundColor = "";
		$("fieldShifts").style.border = "";
	}
	
	//Change the shift checkbox labels to black
	for (var i = 0; i < shifts["id"].length; i++)
	{
		$(shifts["id"][i]).style.color = "#000000";
	}
}

function ResetForm()
{
	//Change all shift labels to black and enable all shift checkboxes
	for (var i = 0; i < shifts["id"].length; i++)
	{
		$(shifts["id"][i]).style.color = "#000000";
		$("chk" + shifts["id"][i]).disabled = false;
	}
	
	//Remove error highlighting from textboxes
	var controls = document.getElementsByTagName("input");
	
	for (var i = 0; i < controls.length; i++)
	{
		if (controls[i].type === "text")
		{
			DisplayValidity($(controls[i].id), $("err" + controls[i].id.substring(3)), "", true);
		}
	}

	//Remove error highlighting from textareas
	controls = document.getElementsByTagName("textarea");
	
	for (var i = 0; i < controls.length; i++)
	{
		DisplayValidity($(controls[i].id), $("err" + controls[i].id.substring(3)), "", true);
	}
	
	//Move to the top of the page
	window.scrollTo(0,0);
	$("txtFirstName").focus();
}

window.onload = function()
{
	//Reset the form and checkboxes
	$("signUp").reset();
	ResetForm();

	$("txtZipCode").onkeypress = IntegerKeyPress;
	$("txtHomePhone").onkeypress = PhoneKeyPress;
	$("txtCellPhone").onkeypress = PhoneKeyPress;

	$("txtFirstName").onblur = ValidateFirstName;
	$("txtLastName").onblur = ValidateLastName;
	$("txtStreet").onblur = ValidateStreet;
	$("txtStreet2").onblur = ValidateStreet2;
	$("txtCity").onblur = ValidateCity;
	$("txtZipCode").onblur = ValidateZipCode;
	
	$("txtHomePhone").onblur = ValidatePhone;
	$("txtCellPhone").onblur = ValidatePhone;
	
	$("txtEmailAddress").onblur = ValidateEmailAddress;
	$("txtVolunteerComments").onblur = ValidateComments;
	
	$("chkFullAvailability").onchange = ChkFullAvailabilityOnChange;
	
	//Dynamically add event handlers for shift checkboxes
	for (var i = 0; i < shifts["id"].length; i++)
	{
		$("chk" + shifts["id"][i]).onchange = CheckTimeRanges;
	}
	
	//Dynamically add event handlers for prep job checkboxes
	for (var i = 0; i < prepJobs["name"].length; i++)
	{
		$("chk" + prepJobs["name"][i]).onchange = PrepJobsOnChange;
	}
	
	$("btnSubmit").onclick = ValidateForm;
	$("btnReset").onclick = ResetForm;
	
	$("isJavascriptOn").value = "true";
	
	ChkFullAvailabilityOnChange();
	CheckTimeRanges();
}