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

<title>SPA System - Admin - Employee</title>
	
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


		<form action='employee.php' method ='get'>

			<div class='form-group'>
						<label>Search here</label>
						<input type='text' name='search' class='form-control' placeholder="Employee name" requried>
			</div>

		</form>

		<br>



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
		


		<h4><b>Add New Employee</b></h4>
		<button style='color:black!important' onclick='window.location.href="employee_add.php"'>Add New</button>
		<br>
		<br>

		<h4><b>List of Employee</b></h4>

		<table class='table table-striped'>

			<thead>
		      <tr>
		        <th>First Name</th>
		        <th>Middle Name</th>
		        <th>Last Name</th>
		        <th>Action</th>
		      </tr>
		    </thead>

		    <tbody>


		    	<?php 

		    	include("functions/db.php");
		    	include("includes/utils.php");

		    	$sess_name = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');


		    	if(isset($_GET['search']))
		    	{
		    		$search_this = str_replace("'", "''", $_GET['search']); 

		    		$row = MYSQL_SELECT("select * from employee where CONCAT(f_name,' ',m_name,' ',l_name) like '%".$_GET['search']."%'",$sess_name,3);
		    	}
		    	else
		    	{
		    		$row = MYSQL_SELECT("select * from employee",$sess_name,3);
		    	}


		    	

		    	for($x=0;$x<$row;$x++)
		    	{

		    		
		    		
		    		echo "
		    		<td>".$_SESSION[$sess_name.'_'.$x.'_1']."</td>
		    		<td>".$_SESSION[$sess_name.'_'.$x.'_2']."</td>
		    		<td>".$_SESSION[$sess_name.'_'.$x.'_3']."</td>";



		    		echo "
		    		<td><a href='employee_edit.php?id=".$_SESSION[$sess_name.'_'.$x.'_0']."'>Edit</a> | <a href='employee_details.php?id=".$_SESSION[$sess_name.'_'.$x.'_0']."'>Details</a></td>
		    		</tr>";
		    	}

		    	?>

		    	
		    </tbody>

		</table>

		
	</div>


	




</body>


</html>