<?php
session_start();


		include("includes/isloggedin.php");


		if(ISLOGGEDIN()==true)
		{
			header("location:redirect.php");
		}

		include("functions/db.php");

		GET_CONNECTION();

?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Login</title>
	
<?php include("includes/head.php"); PRINT_HEAD(); ?>



</head>


<body>
	
	<br>
	<br>
	<br>

	<center>
		<h1>SPA SYSTEM</h1>
		<br>
		<br>
		<br>

		<?php
			if(isset($_SESSION['error']))
			{
				echo "<p style='color:red'>".$_SESSION['error']."</p>";
				unset($_SESSION['error']);
			}
		?>

		<div class='row'>

			<div class='col-sm-4'>
			</div>

			<div class='col-sm-4'>
			
				<form action='functions/login.php' method='post'>
					<div class='form-group'>
						<label>Username</label>
						<input type='text' name='username_tb' class='form-control'/>
					</div>

					<div class='form-group'>
						<label>Password</label>
						<input type='password' name='password_tb' class='form-control'/>
					</div>

					<div class='form-group'>
						<input type='submit' class='form-control' value='Login'/>
					</div>
					
				</form>

			</div>

			<div class='col-sm-4'>
			</div>
		
		</div>

	</center>

</body>


</html>