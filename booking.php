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




		include("functions/db.php");


		if(isset($_GET['confirm']))
		{
			if(preg_match("/^[0-9]{1,}$/", $_GET['confirm']))
			{
				
				MYSQL_UPDATE("update booking set book_status='Confirmed' where b_id=".$_GET['confirm']);

				header("location:admin.php");

			}
			else
			{
				header("location:index.php");
			}
		}
		





		if(isset($_GET['cancel']))
		{
			if(preg_match("/^[0-9]{1,}$/", $_GET['cancel']))
			{
				
				MYSQL_UPDATE("update booking set book_status='Cancelled' where b_id=".$_GET['cancel']);

				header("location:admin.php");

			}
			else
			{
				header("location:index.php");
			}
		}
		



?>


