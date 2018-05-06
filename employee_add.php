<?php


		session_start();

		include("includes/isloggedin.php");

		if(ISLOGGEDIN()==true)
		{
			if(ISADMIN()==true)
			{

			}
			else
			{
				header("location:index.php");
			}
		}
		else
		{
			header("location:index.php");
		}

?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Admin - Employee - Add</title>
	
<?php include("includes/head.php"); PRINT_HEAD(); ?>

<link rel='stylesheet' href='css_/admin.css'>


</head>


<body>
	
	<div id='header'>
		<?php
		echo $_SESSION['login_details_0_1'] . " " .  $_SESSION['login_details_0_2'] . " " . $_SESSION['login_details_0_3'] . ", " . $_SESSION['login_position_0_0'] . "&nbsp";
		?>

		<button style='color:black!important' onclick='window.location.href="logout.php"'>Logout</button>

	</div>

	<?php include("includes/admin_nav.php"); PRINT_NAV(); ?>


	<br>
	<br>
	<br>

	
	<div class='container'>

		

		<h4><b>Add New Employee</b></h4>

		<?php
			if(isset($_SESSION['error']))
			{
				echo "<br><p style='color:red'>".$_SESSION['error']."</p><br>";
				unset($_SESSION['error']);
			}

			if(isset($_SESSION['success']))
			{
				echo "<br><p style='color:green'>".$_SESSION['success']."</p><br>";
				unset($_SESSION['success']);
			}

		?>
		
		<form action='functions/employee_add.php' method='post' enctype="multipart/form-data">
					<div class='form-group'>
						<label>First Name</label>
						<input type='text' name='first_name_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<label>Middle Name</label>
						<input type='text' name='middle_name_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<label>Last Name</label>
						<input type='text' name='last_name_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<input type='submit' class='form-control' value='Add Employee'/>
					</div>
					
		</form>

		
	</div>


	




</body>


</html>