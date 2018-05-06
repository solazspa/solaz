<?php


		session_start();

		include("includes/isloggedin.php");
		include("includes/utils.php");

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


		if(isset($_GET['id']))
		{
			if(preg_match("/^[0-9]{1,}$/", $_GET['id']))
			{
				$sess_name = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');


				MYSQL_SELECT("select * from employee where e_id=".$_GET['id'],$sess_name,9);

				if(isset($_SESSION[$sess_name.'_0_0']))
				{
					if(empty($_SESSION[$sess_name.'_0_0']))
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
		}
		else
		{
			header("location:index.php");
		}

		



?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Admin - Employee - Details</title>
	
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



	<?php
			if(isset($_SESSION['error']))
			{
				echo "<center><br><p style='color:red'>".$_SESSION['error']."</p><br></center>";
				unset($_SESSION['error']);
			}

			if(isset($_SESSION['success']))
			{
				echo "<center><br><p style='color:green'>".$_SESSION['success']."</p><br></center>";
				unset($_SESSION['success']);
			}

		?>

	

	<div style='padding:10px'>
		

		

		<?php
			



			$sess_name4 = "data4_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');

			    	$row = 0;

		    
		    		$row = MYSQL_SELECT("select * from employee where e_id=".$_SESSION[$sess_name.'_0_0'],$sess_name4,3);

					
					 	echo "
						 	<h4><b>Driver Details</b></h4>

							<table class='table table-striped' id='selected_table' style='background-color: green;border:2px solid green;'>

								<thead style='color:white;'>
							      <tr>
							        <th>Full Name</th>
							      </tr>
							    </thead>

							    <tbody>
					    		";
					 	

				
				    		

				    		
				    		
				    		echo "<tr>
				    		<td>".$_SESSION[$sess_name4.'_0_1']." ".$_SESSION[$sess_name4.'_0_2']." ".$_SESSION[$sess_name4.'_0_3']."</td><tr>";
				    		



				    	
					  

					   	echo "
					    	
					    </tbody>
					  
						</table>

						<br>
						<br>


						<center><button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"employee.php\"'>Go Back</button></center>

						<br>
						<hr>



						";


		?>

		<h1>ADD NEW PRODUCTS/SERVICES</h1>

		<form action='functions/employee_products.php' method='post'>
					
					<input type='hidden' name='id_tb' class='form-control' value='<?php echo $_SESSION[$sess_name.'_0_0']; ?>' />

					<div class='form-group'>
						<label>Products/Services</label>

						<select name='products_cb' class='form-control'>

							<?php
								

								$sess_name44 = "data44_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');

								$row = MYSQL_SELECT("select * from products",$sess_name44,3);



								for($x=0;$x<$row;$x++)
								{

									$ok = true;

									$sess_name2 = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s') . $x;

									MYSQL_SELECT("select e_id from employee_products where e_id=".$_SESSION[$sess_name.'_0_0'] . " and p_id=".$_SESSION[$sess_name44.'_'.$x.'_0'],$sess_name2,0);
									

									if(isset($_SESSION[$sess_name2.'_0_0']))
									{
										if($_SESSION[$sess_name2.'_0_0'] != 0)
										{
											$ok = false;
										}
									}

									if($ok == true)
									{
										echo "<option>".$_SESSION[$sess_name44.'_'.$x.'_1']."</option>";
									}
									
								}
							?>

							

						</select>

					</div>


					<div class='form-group'>
						<input type='submit' class='form-control' value='Add Product/Service'/>
					</div>

		</form>



		<br>
		<hr>






		<h4><b>List of Products</b></h4>

		<table class='table table-striped'>

			<thead>
		      <tr>
		        <th>Product/Service</th>
		        <th>Price</th>
		        <th>Duration (minutes)</th>
		        <th>Action</th>
		      </tr>
		    </thead>

		    <tbody>


		    	<?php 


		    	$sess_name200 = "data200_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s'). "products";

		    	$row200 = MYSQL_SELECT("select products.p_id,products.p_text,products.p_price,products.minutes from products,employee_products where products.p_id=employee_products.p_id and employee_products.e_id = ".$_SESSION[$sess_name.'_0_0'],$sess_name200,3);

		    	for($x=0;$x<$row200;$x++)
		    	{

		    		echo "<tr>
		    		<td>".$_SESSION[$sess_name200.'_'.$x.'_1']."</td>
		    		<td>".$_SESSION[$sess_name200.'_'.$x.'_2']."</td>
		    		<td>".$_SESSION[$sess_name200.'_'.$x.'_3']."</td>
		    		<td><a href='employee_products_remove.php?id=".$_SESSION[$sess_name200.'_'.$x.'_0']."&id2=".$_SESSION[$sess_name.'_0_0']."'>Remove</a></td>
		    		</tr>";
		    	}

		    	?>

		    	
		    </tbody>


							
		
		

		
	</div>

	




</body>


</html>