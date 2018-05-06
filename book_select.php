<?php


session_start();

if(isset($_GET['selected_service']))
{
	if(preg_match("/^[0-9]{1,}$/", $_GET['selected_service']))
	{
		$_SESSION['selected_service'] = $_GET['selected_service'];
		$_SESSION['service_name'] = $_GET['service_name'];
		$_SESSION['service_price'] = $_GET['service_price'];
		$_SESSION['service_duration'] = $_GET['service_duration'];
		header("location:index.php");
	}
	else
	{
		header("location:index.php");
	}
}


if(isset($_GET['remove_selected_service']))
{
	unset($_SESSION['selected_service']);
	unset($_SESSION['service_name']);
	unset($_SESSION['service_price']);
	unset($_SESSION['service_duration']);
	unset($_SESSION['selected_time']);
	unset($_SESSION['selected_employee']);
	unset($_SESSION['employee_name']);
	header("location:index.php");
}


if(isset($_GET['remove_selected_time']))
{

	unset($_SESSION['selected_time']);
	unset($_SESSION['selected_employee']);
	unset($_SESSION['employee_name']);
	header("location:index.php");
}

if(isset($_GET['remove_selected_employee']))
{

	unset($_SESSION['selected_employee']);
	unset($_SESSION['employee_name']);
	header("location:index.php");
}


if(isset($_GET['date_tb']))
{


				$ok_date = true;
				$selected_date = str_replace("T", " ", $_GET['date_tb']);

					if(isset($_SESSION['booking_counter']))
		    		{
		    			for($x=0;$x<$_SESSION['booking_counter'];$x++)
		    			{

		    				if(!empty($_SESSION['booking_'.$x.'_1']))
		    				{
		    					

		    					$enddate = Date('Y-m-d H:i',strtotime($_SESSION['booking_'.$x.'_4'].' + '.$_SESSION['booking_'.$x.'_3'].' minutes'));


		    					if($selected_date >= $_SESSION['booking_'.$x.'_4'] && $selected_date <= $enddate)
		    					{
		    						$ok_date = false;
		    					}

			    				
		    				}


		    			}



		    			


		    		}
		    		




	

	if($ok_date==true)
	{
		$_SESSION['selected_time'] = $selected_date;
	}
	else
	{
		$_SESSION['error'] = "You are not available on that date & time.";
	}

	
	header("location:index.php");
}


if(isset($_GET['selected_employee']))
{
	if(preg_match("/^[0-9]{1,}$/", $_GET['selected_employee']))
	{
		$_SESSION['selected_employee'] = $_GET['selected_employee'];
		$_SESSION['employee_name'] = $_GET['employeename'];
		header("location:index.php");
	}
}





if(isset($_GET['cart']))
{
	if($_GET['cart']=="add")
	{
		

		if(!isset($_SESSION['booking_counter']))
		{
			$_SESSION['booking_counter'] = 0;
		}


		$_SESSION['booking_'.$_SESSION['booking_counter'].'_0'] = $_SESSION['selected_service'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_1'] = $_SESSION['service_name'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_2'] = $_SESSION['service_price'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_3'] = $_SESSION['service_duration'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_4'] = $_SESSION['selected_time'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_5'] = $_SESSION['selected_employee'];
		$_SESSION['booking_'.$_SESSION['booking_counter'].'_6'] = $_SESSION['employee_name'];

		$var_temp = $_SESSION['booking_counter'] + 1;
		$_SESSION['booking_counter'] = $var_temp;



		unset($_SESSION['selected_service']);
		unset($_SESSION['service_name']);
		unset($_SESSION['service_price']);
		unset($_SESSION['service_duration']);
		unset($_SESSION['selected_time']);
		unset($_SESSION['selected_employee']);
		unset($_SESSION['employee_name']);
		header("location:index.php");




		header("location:index.php");
	}
}


if(isset($_GET['cart_remove']))
{

	if(preg_match("/^[0-9]{1,}$/", $_GET['cart_remove']))
	{	
		
		$_SESSION['booking_'.$_GET['cart_remove'].'_0'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_1'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_2'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_3'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_4'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_5'] = "";
		$_SESSION['booking_'.$_GET['cart_remove'].'_6'] = "";

		header("location:index.php");
	}
	else
	{
		header("location:index.php");
	}

}



?>