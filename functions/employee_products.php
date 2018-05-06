<?php
session_start();

include("db.php");

if($_POST)
{


	if(isset($_POST['products_cb']) && isset($_POST['id_tb']))
	{

		$ok = true;

		$_POST['products_cb'] = str_replace("'", "''", $_POST['products_cb']);

		if(!is_numeric($_POST['id_tb']))
		{
			$_SESSION['error'] = "Not a number.";
			header("location:../employee.php");
			$ok = false;
		}

		


		if($ok == true)
		{
			MYSQL_INSERT("employee_products","e_id,p_id",$_POST['id_tb'].",".GET_PRODUCT_ID($_POST['products_cb']));

			$_SESSION['success'] = "Product/Service added.";
			header("location:../employee_details.php?id=".$_POST['id_tb']);

		}

	}
	else
	{
		$_SESSION['error'] = "Please fill up all fields.";
		header("location:../employee.php");
	}
}
else
{
	header("location:../index.php");
}


function GET_PRODUCT_ID($val)
{
	$sess_name2 = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s') . "productid";

	MYSQL_SELECT("select p_id from products where p_text='".$val."'",$sess_name2,0);

	return $_SESSION[$sess_name2.'_0_0'];
}


?>