<?php
session_start();
//Only allow a valid user access to this page
if ($_SESSION['validUser'] !== "yes") {
	header('Location: index.php');
}
		
	//Setup the variables used by the page
		//field data
		$presenter_first_name = "";
		$presenter_last_name = "";
		$presenter_city = "";
		$presenter_st = "";
		$presenter_zip = "";
		$presenter_email = "";
		//error messages
		$firstNameErrMsg = "";
		$lastNameErrMsg = "";
		$cityErrMsg = "";
		$stErrMsg = "";
		$zipErrMsg = "";
		$emailErrMsg = "";
		
		$validForm = false;
				
	if(isset($_POST["submit"]))
	{	
		//The form has been submitted and needs to be processed
		
		
		//Validate the form data here!
	
		//Get the name value pairs from the $_POST variable into PHP variables
		//This example uses PHP variables with the same name as the name atribute from the HTML form
		$presenter_first_name = $_POST['presenter_first_name'];
		$presenter_last_name = $_POST['presenter_last_name'];
		$presenter_city = $_POST['presenter_city'];
		$presenter_st = $_POST['presenter_st'];
		$presenter_zip = $_POST['presenter_zip'];
		$presenter_email = $_POST['presenter_email'];

		/*	FORM VALIDATION PLAN
		
			FIELD NAME		VALIDATION TESTS & VALID RESPONSES
			First Name		Required Field		May not be empty
			Last Name		Required Field		May not be empty
			
			City			Optional
			State			Optional
			
			Zip Code		Required Field		Format and Numeric 
			Email			Required Field		Format
		*/
		
		//VALIDATION FUNCTIONS		Use functions to contain the code for the field validations.  
			function validateFirstName($inName)
			{
				global $validForm, $firstNameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$firstNameErrMsg = "";
				
				if($inName == "")
				{
					$validForm = false;
					$firstNameErrMsg = "Name cannot be spaces";
				}
			}//end validateName()

			function validateLastName($inName)
			{
				global $validForm, $lastNameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$lastNameErrMsg = "";
				
				if($inName == "")
				{
					$validForm = false;
					$lastNameErrMsg = "Name cannot be spaces";
				}
			}//end validateName()			
			
			function validateZip($inZip)
			{
				global $validForm, $zipErrMsg;
				$zipErrMsg = "";
				
				if(empty($inZip))
				{
					$validForm = false;
					$zipErrMsg = "Zip Code required"; 					
				}
				else
				{
					 if(!preg_match('/^[0-9]{5}([- ]?[0-9]{4})?$/', $inZip))
					 {
						$validForm = false;
						$zipErrMsg = "Invalid Zip Code"; 
					 }
				}
			}//end validateZip()	
					
			function validateEmail($inEmail)
			{
				global $validForm, $emailErrMsg;			//Use the GLOBAL Version of these variables instead of making them local
				$emailErrMsg = "";							//Clear the error message. 
				
				// Remove all illegal characters from email
				$inEmail = filter_var($inEmail, FILTER_SANITIZE_EMAIL);

				// Validate e-mail
				$inEmail = filter_var($inEmail, FILTER_VALIDATE_EMAIL);

				if($inEmail === false)
				{
					$validForm = false;
					$emailErrMsg = "Invalid email"; 					
				}
			}//end validateEmail()		
		
		//VALIDATE FORM DATA  using functions defined above
		$validForm = true;		//switch for keeping track of any form validation errors
		
		validateFirstName($presenter_first_name);
		validateLastName($presenter_last_name);
		validateZip($presenter_zip);
		validateEmail($presenter_email);
		
		if($validForm)
		{
			$message = "All good";	
			
			try {
				
				require 'database/connectPDO.php';	//CONNECT to the database
				
				//mysql DATE stores data in a YYYY-MM-DD format
				$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
				
				//Create the SQL command string
				$sql = "INSERT INTO pit_presenters (";
				$sql .= "presenters_fName, ";
				$sql .= "presenters_lName, ";
				$sql .= "presenters_city, ";
				$sql .= "presenters_st, ";
				$sql .= "presenters_zip, ";
				$sql .= "presenters_email, ";
				$sql .= "presenters_dateAdded "; //Last column does NOT have a comma after it.
				$sql .= ") VALUES (:firstName, :lastName, :city, :st, :zip, :email, :dateAdded)";
				
				//PREPARE the SQL statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				$stmt->bindParam(':firstName', $presenter_first_name);
				$stmt->bindParam(':lastName', $presenter_last_name);		
				$stmt->bindParam(':city', $presenter_city);		
				$stmt->bindParam(':st', $presenter_st);		
				$stmt->bindParam(':zip', $presenter_zip);
				$stmt->bindParam(':email', $presenter_email);		
				$stmt->bindParam(':dateAdded', $todaysDate);	
				
				//EXECUTE the prepared statement
				$stmt->execute();	
				
				$message = "The Presenter has been registered.";
			}
			
			catch(PDOException $e)
			{
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
			}

		}
		else
		{
			$message = "Something went wrong";
		}//ends check for valid form		

	}
	else
	{
		//Form has not been seen by the user.  display the form
	}// ends if submit 
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Presenting Information Technology</title>

	<link rel="stylesheet" href="css/pit.css">

</head>

<body>

<div id="container">

	<header>
    	<h1>Presenting Information Technology</h1>
    </header>
    
	<?php require 'includes/navigation.php' ?>
    
    <main>
    
        <h1>Add a new Presenter</h1>
		<?php
            //If the form was submitted and valid and properly put into database display the INSERT result message
			if($validForm)
			{
        ?>
            <h1><?php echo $message ?></h1>
        
        <?php
			}
			else	//display form
			{
        ?>
        
        <p>Once the form is submitted and validated it will call the addPresenters.php page. That page will pull the form data into the PHP and <br>
		add a new record to the database.</p>
        <form id="presentersForm" name="presentersForm" method="post" action="addPresenter.php">
        	<fieldset>
              <legend>Add a Presenter</legend>
              <p>
                <label for="presenter_first_name">First Name: </label>
                <input type="text" name="presenter_first_name" id="presenter_first_name" value="<?php echo $presenter_first_name;  ?>" /> 
                <span class="errMsg"> <?php echo $firstNameErrMsg; ?></span>
              </p>
              <p>
                <label for="presenter_last_name">Last Name: </label>  
                <input type="text" name="presenter_last_name" id="presenter_last_name" value="<?php echo $presenter_last_name;  ?>" />
                <span class="errMsg"><?php echo $lastNameErrMsg; ?></span>                
              </p>
              <p>
                <label for="presenter_city">City: </label>
                <input type="text" name="presenter_city" id="presenter_city" value="<?php echo $presenter_city;  ?>" />
              </p>
              <p>
                <label for="presenter_st">State: </label> 
                <input type="text" name="presenter_st" id="presenter_st" value="<?php echo $presenter_st;  ?>"/>
              </p>
              <p>
                <label for="presenter_zip">Zip Code: </label> 
                <input type="text" name="presenter_zip" id="presenter_zip" value="<?php echo $presenter_zip;  ?>"/>
                <span class="errMsg"><?php echo $zipErrMsg; ?></span>                
              </p>
              <p>
                <label for="presenter_email">Email: </label> 
                <input type="text" name="presenter_email" id="presenter_email" value="<?php echo $presenter_email;  ?>"/>
                <span class="errMsg"><?php echo $emailErrMsg; ?></span>                
              </p>            
              
            </fieldset>
         	<p>
            	<input type="submit" name="submit" id="submit" value="Add Presenter" />
            	<input type="reset" name="button2" id="button2" value="Clear Form" onClick="clearForm()" />
        	</p>  
        </form>
        <?php
			}//end else
        ?>    	
        
	</main>
    
	<footer>
    	<p>Copyright &copy; <script> var d = new Date(); document.write (d.getFullYear());</script> All Rights Reserved</p>
    
    </footer>




</div>
</body>
</html>
