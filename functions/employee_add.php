<?php
session_start();

include("db.php");

if($_POST)
{


	if( isset($_POST['first_name_tb'])&& isset($_POST['middle_name_tb'])&& isset($_POST['last_name_tb']))
	{

		$ok = true;





		$_POST['first_name_tb'] = str_replace("'", "''", $_POST['first_name_tb']);
		$_POST['middle_name_tb'] = str_replace("'", "''", $_POST['middle_name_tb']);
		$_POST['last_name_tb'] = str_replace("'", "''", $_POST['last_name_tb']);

		



		if($ok == true)
		{



		
				MYSQL_INSERT("employee","f_name,m_name,l_name","'".$_POST['first_name_tb']."','".$_POST['middle_name_tb']."','".$_POST['last_name_tb']."'");
			
			

			$_SESSION['success'] = "Employee added.";
			header("location:../employee.php");

		}

	}
	else
	{
		$_SESSION['error'] = "Please fill up all fields.";
		header("location:../employee_add.php");
	}
}
else
{
	header("location:../index.php");
}



?>