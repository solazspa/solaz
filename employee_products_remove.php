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


		if(isset($_GET['id']) && isset($_GET['id2']) )
		{
			
			if(preg_match("/^[0-9]{1,}$/", $_GET['id']))
			{
				
				if(preg_match("/^[0-9]{1,}$/", $_GET['id2']))
				{
						
					MYSQL_DELETE("delete from employee_products where p_id=".$_GET['id']." and e_id=".$_GET['id2']);
					$_SESSION['success'] = "Product/Service removed.";
					header("location:employee_details.php?id=".$_GET['id2']);

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
		}
		else
		{
			header("location:index.php");
		}

		



?>


