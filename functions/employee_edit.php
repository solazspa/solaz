<?php
session_start();

include("db.php");

if($_POST)
{


	if(isset($_POST['first_name_tb'])&& isset($_POST['middle_name_tb'])&& isset($_POST['last_name_tb']) && isset($_POST['id_tb']))
	{

		$ok = true;





		$_POST['first_name_tb'] = str_replace("'", "''", $_POST['first_name_tb']);
		$_POST['middle_name_tb'] = str_replace("'", "''", $_POST['middle_name_tb']);
		$_POST['last_name_tb'] = str_replace("'", "''", $_POST['last_name_tb']);

		




		if($ok == true)
		{



			
				MYSQL_UPDATE("update employee set f_name='".$_POST['first_name_tb']."',m_name='".$_POST['middle_name_tb']."',l_name='".$_POST['last_name_tb']."' where e_id=".$_POST['id_tb']);
			
			

			$_SESSION['success'] = "Employee updated.";
			header("location:../employee.php");

		}

	}
	else
	{
		$_SESSION['error'] = "Please fill up all fields.";
		header("location:../driver_edit.php?id=".$_POST['id_tb']);
	}
}
else
{
	header("location:../index.php");
}



?>