<?php


function ISLOGGEDIN()
{
			if(isset($_SESSION['login_details_0_0']))
			{
				if($_SESSION['login_details_0_0'] != 0)
				{
					return true;
				}
				else
				{
					return false;
				}

			}
			else
			{
				return false;
			}
}




function ISADMIN()
{
			if($_SESSION['login_details_0_6']==1)
			{
				return true;
			}
			else
			{
				return false;
			}
}



?>