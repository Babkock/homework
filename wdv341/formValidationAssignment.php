<!DOCTYPE html>
<html lang="en">
<?php echo "<head>"; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP - Form Validation Example</title>
    <link rel="stylesheet" href="/homework/assets/css/style.css" />
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
    <h2>Form Validation Assignment


    </h2>
    <div id="orderArea">
      <form id="form1" name="form1" method="post" action="formValidationAssignment">
      <h3>Customer Registration Form</h3>
      <table width="587" border="0">
        <tr>
          <td width="117">Name:</td>
          <td width="246"><input type="text" name="inName" id="inName" size="40" value=""/></td>
          <td width="210" class="error"></td>
        </tr>
        <tr>
          <td>Social Security</td>
          <td><input type="text" name="inEmail" id="inEmail" size="40" value="" /></td>
          <td class="error"></td>
        </tr>
        <tr>
          <td>Choose a Response</td>
          <td><p>
            <label>
              <input type="radio" name="RadioGroup1" id="RadioGroup1_0">
              Phone</label>
            <br>
            <label>
              <input type="radio" name="RadioGroup1" id="RadioGroup1_1">
              Email</label>
            <br>
            <label>
              <input type="radio" name="RadioGroup1" id="RadioGroup1_2">
              US Mail</label>
            <br>
          </p></td>
          <td class="error"></td>
        </tr>
      </table>
      <p>
        <input type="submit" name="submit" id="button" value="Register" />
        <input type="reset" name="button2" id="button2" value="Clear Form" />
      </p>
    </form>
    </div>
    <footer>
        <p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a></p>
    </footer>
</body>
</html>