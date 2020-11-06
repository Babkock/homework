<?php

//Setup the variables used by the page
$nameErrMsg = "";
$quanErrMsg = "";
$emailErrMsg = "";
$shipErrMsg = "";

$validForm = false;

$inName = "";
$inQuantity = 0;
$inEmail = "";
$inShipping = "";



/*	FORM VALIDATION PLAN

	FIELD NAME	VALIDATION TESTS & VALID RESPONSES
	inName		Required Field		May not be empty
	
	inQuantity	Required Field		Must contain something
				Numeric Field		May ONLY contain numbers, no special characters
				Reasonable Check	Value must be between 1 and 1000
				
	inEmail		Required Field		May not be empty
				Format Validation	Must be a properly formatted email address

	inShipping	Required Field		Must have selected something other than the first option

*/

/*
	This form is self-posting in order to process the validations.   It will use the following algorithm or process
	in order to properly display and validate the form and its data.
	
	if the form has been submitted		(The user has filled out the form and hit the submit button)
		{
		then validate the form data		(The form data is ready to be validated)
		
		//Validation Algorithm				(The validation process will follow the following process or set of steps)
		set validForm = true					Set a flag or switch to true.  This assumes the form data is valid. 
			perform validateName()				This will validate the data from the Name field
			perform validateQuantity()			This will validate the data from the Quantity field
			perform validateEmail()				This will validate the data from the Email field
			perform validateShipping()			This will validate the data from the Shipping field
		if (validForm==true)				If the flag is still true no errors were found, the form is valid
			{
			move form data into database		The form data is good so it should be INSERTED into the database
			}
		else								The flag is false because errors were found in the data
			{
			load data back into the form		Put the data back into the form fiels so the user can see what was in the fields
			load the error messages				Place the appropriate error messages on the form so the user knows what to fix
			display the form					Display the form with its original data and error messages to the user.
			}
		}
	else
		{
		display the form				(The user needs to enter data on the form so it can be validated and processed)
		}
*/

/*
	field validation algorithm		This process is done for each field validation function.  The details change for each field but the
									same steps are processed in the same order for each validation.  

		clear the error messages for this validation.  Set to ""		(Cleans up from previous errors and assumes there will not be an error)
		check the variable for the field against the expected values
		if it meets those values 
			{
			the field is valid
			nothing else needs done
			}
		else
			{
			the field is invalid
			set the validForm=false			(A data validation error has been found.  The form is no longer valid)
			set the error message variable for this field to the appropriate message
			}
*/

//VALIDATION FUNCTIONS		Use functions to contain the code for the field validations.  
function validateName()
{
	global $inName, $validForm, $nameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
	$nameErrMsg = "";
	
	if($inName == "")
	{
		$validForm = false;
		$nameErrMsg = "Name cannot be spaces";
	}
}//end validateName()

function validateQuantity()
{
	global $inQuantity, $validForm, $quanErrMsg;			//Use the GLOBAL Version of these variables instead of making them local
	$quanErrMsg = "";										//Clear the error message. 

	if (!preg_match("/^[1-9][0-9]*$/",$inQuantity))			//Uses a Regular Expression to validate an integer 
  	{
		$validForm = false;
  		$quanErrMsg = "Invalid Quantity"; 
  	}
	else
	{
		if($inQuantity <1 || $inQuantity > 1000)		//REASONABLE VALIDATION TEST
		{
			$validForm = false;
			$quanErrMsg .= "Quantity should be between 1 and 1000.";		
		}					
	}
}//end validateQuantity

function validateEmail()
{
	global $inEmail, $validForm, $emailErrMsg;	//Use the GLOBAL Version of these variables instead of making them local
	$emailErrMsg = "";							//Clear the error message. 
	
	//Using a Regular Expression to FORMAT VALIDATION email address
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$inEmail))		//Copied straight from W3Schools.  Uses a Regular Expression
  	{
		$validForm = false;
  		$emailErrMsg = "Invalid email format"; 
  	}		
}//end validateEmail()

function validateShipping()
{
	global $inShipping, $validForm, $shipErrMsg;	//Use the GLOBAL Version of these variables instead of making them local
	$shipErrMsg = "";								//Clear the error message. 	
	
	if($inShipping == "")							//SHIPPING METHOD REQUIRED		Form passes a "" value if nothing is selected
	{
		$validForm = false;
  		$shipErrMsg = "Please select a shipping method"; 			
	}
}//end validateShipping()


//   ---  FORM VALIDATION BEGINS HERE!!!   --------

if( isset($_POST['submit']) )				//if the form has been submitted Validate the form data
{
	//pull data from the POST variables in order to validate their values
	$inName = $_POST['inName'];
	$inQuantity = $_POST['inQuantity'];
	$inEmail = $_POST['inEmail'];
	$inShipping = $_POST['inShipping'];
	
	$validForm = true;					//Set form flag/switch to true.  Assumes a valid form so far
	
	validateName();					//call the validateName() function
	validateQuantity();				//call the validateQuantity() function
	validateEmail();				//call the validateEmail() function
	validateShipping();				//call the validateShipping() function
	
	if($validForm)
	{
		//If the form is properly validated some or all of the following processes would be completed before displaying a confirmation message to the user
		//- Create and send an email confirmation to the user using the email address they entered on the form.  You would use the Email class for this process
		//- Use SQL to put the form data into a table in the database.  This is often done to record the registration/order/contact, etc.
		//- Perform additional processing of the form data depending upon the application requirements.	
	}

}//Completes the Form Validation process for this page.  

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Form Validation Code Example</title>
<style>

#orderArea	{
	width:600px;
	background-color:#CF9;
}

.error	{
	color:red;
	font-style:italic;	
}
</style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Form Validation - Code Example With Regular Expressions</h2>

<?php

if ($validForm)			//If the form has been entered and validated a confirmation page is displayed in the VIEW area.
{
?>
	<h3>Thank You!</h3>
    <p>Your order has been processed. An email has been sent to <?php echo $inEmail; ?> for your records.</p>

<?php
}	//end the true branch of the form view area
else
{	
?>

    <div id="orderArea">
    <form id="form1" name="form1" method="post" action="formValidationWorkingExampleRegularExpressions.php">
      <h3>Product Order Form</h3>
      <table width="587" border="0">
        <tr>
          <td width="117">Name:</td>
          <td width="246"><input type="text" name="inName" id="inName" size="40" value="<?php echo $inName; //place data back in field ?>"/></td>
          <td width="210" class="error"><?php echo "$nameErrMsg"; //place error message on form  ?></td>
        </tr>
        <tr>
          <td>Quantity:</td>
          <td><input type="text" name="inQuantity" id="inQuantity" size="4" value="<?php echo $inQuantity; //place data back in field ?>"/></td>
          <td class="error"><?php echo "$quanErrMsg"; //place error message on form  ?></td>
        </tr>
        <tr>
          <td>Email Address:</td>
          <td><input type="text" name="inEmail" id="inEmail" size="40" value="<?php echo $inEmail; //place data back in field ?>" /></td>
          <td class="error"><?php echo "$emailErrMsg"; //place error message on form  ?></td>
        </tr>
        <tr>
          <td>Shipping Method:</td>
          <td><select name="inShipping" id="inShipping">
            <option value="" <?php if($inShipping==""){echo "selected='selected'";}?>>Select Shipping</option>
            <option value="USPS" <?php if($inShipping=="USPS"){echo "selected='selected'";}?>>US Postal Service</option>
            <option value="FedEx" <?php if($inShipping=="FedEx"){echo "selected='selected'";}?>>Federal Express</option>
            <option value="UPS" <?php if($inShipping=="UPS"){echo "selected='selected'";}?>>UPS</option>
          </select></td>
          <td class="error"><?php echo "$shipErrMsg"; //place error message on form  ?></td>
        </tr>
      </table>
      <p>
        <input type="submit" name="submit" id="button" value="Process Order" />
        <input type="reset" name="button2" id="button2" value="Clear Form" />
      </p>
    </form>
    </div>

<?php
}	//end else branch for the View area
?>
</body>
</html>