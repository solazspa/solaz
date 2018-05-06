<?php
session_start();

include("db.php");

if($_POST)
{


	if(isset($_POST['product_tb']) && isset($_POST['id_tb']) && isset($_POST['price_tb']) && isset($_POST['duration_tb']))
	{

		$ok = true;

		if(!preg_match("/^[0-9]{1,}$/", $_POST['id_tb']))
		{
			$ok = false;
			$_SESSION['error'] = "Error.";
			header("location:../products_edit.php?id=".$_POST['id_tb']);
		}


		if(!is_numeric($_POST['price_tb']))
		{
			$_SESSION['error'] = "Not a number.";
			header("location:../products_edit.php?id=".$_POST['id_tb']);
			$ok = false;
		}

		if(!is_numeric($_POST['duration_tb']))
		{
			$_SESSION['error'] = "Not a number.";
			header("location:../products_edit.php?id=".$_POST['id_tb']);
			$ok = false;
		}



		$_POST['product_tb'] = str_replace("'", "''", $_POST['product_tb']);




		if($ok == true)
		{


			MYSQL_UPDATE("update products set p_text='".$_POST['product_tb']."',p_price=".$_POST['price_tb'].",minutes=".$_POST['duration_tb']." where p_id=".$_POST['id_tb']);


			

			$_SESSION['success'] = "Product/Service updated.";
			header("location:../products.php");

		}

	}
	else
	{
		$_SESSION['error'] = "Please fill up all fields.";
		header("location:../products_edit.php?id=".$_POST['id_tb']);
	}
}
else
{
	header("location:../index.php");
}



?>