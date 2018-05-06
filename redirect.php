<?php


		session_start();

		include("includes/isloggedin.php");

		if(ISLOGGEDIN()==true)
		{
			if(ISADMIN())
			{
				header("location:admin.php");
			}

			
		}
		else
		{
			header("location:index.php");
		}


?>