<?php
session_start();


		include("functions/db.php");
		include("includes/utils.php");

		GET_CONNECTION();

		$have_data = false;

		    		if(isset($_SESSION['booking_counter']))
		    		{
		    			for($x=0;$x<$_SESSION['booking_counter'];$x++)
		    			{

		    				if(!empty($_SESSION['booking_'.$x.'_1']))
		    				{
		    					$have_data = true;

		    					
		    				}


		    			}



		    			


		    		}


		  if($have_data == false)
		  {
		  	header("location:index.php");
		  }

?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Booking</title>
	
<?php include("includes/head.php"); PRINT_HEAD(); ?>

<script src='https://www.google.com/recaptcha/api.js'></script>

</head>


<body>
	
	<br>
	<br>
	<br>

	<div class='container'>
		<center><h1>BOOKING</h1></center>
		<br>
		<br>
		<br>




		<?php
			if(isset($_SESSION['error']))
			{
				echo "<br><p style='color:red'>".$_SESSION['error']."</p><br>";
				unset($_SESSION['error']);
			}

			if(isset($_SESSION['success']))
			{
				echo "<br><p style='color:green'>".$_SESSION['success']."</p><br>";
				unset($_SESSION['success']);
			}

		?>




		<hr>

		<h4><b>My Selected Service(s)</b></h4>

		<table class='table table-striped'>

			<thead>
		      <tr>
		        <th>Service</th>
		        <th>Price</th>
		        <th>Duration (minutes)</th>
		        <th>Personnel</th>
		        <th>Time</th>
		      </tr>
		    </thead>

		    <tbody>


		    	<?php 

		    	$have_data = false;
		    	$overall_total = 0;

		    		if(isset($_SESSION['booking_counter']))
		    		{
		    			for($x=0;$x<$_SESSION['booking_counter'];$x++)
		    			{

		    				if(!empty($_SESSION['booking_'.$x.'_1']))
		    				{
		    					$have_data = true;

		    					$overall_total += $_SESSION['booking_'.$x.'_2'];

			    				echo "<tr>

			    					<td>".$_SESSION['booking_'.$x.'_1']."</td>
			    					<td>".number_format($_SESSION['booking_'.$x.'_2'],2)."</td>
			    					<td>".$_SESSION['booking_'.$x.'_3']."</td>
			    					<td>".$_SESSION['booking_'.$x.'_6']."</td>
			    					<td>".DateNumToTextAndTime($_SESSION['booking_'.$x.'_4'])."</td>

			    				</tr>";
		    				}


		    			}



		    			


		    		}
		    		
		    	

		    	?>

		    	
		    </tbody>

		</table>


		<?php

		   if($have_data==true)
		    {
		    	echo "<h1 style='padding:10px;background-color:green;color:white'>Overall Total: " . number_format($overall_total,2)."</h1>";

				echo "<br><center><button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"index.php\"'>Go Back</button></center>";

			}
		?>


		<br>
		<br>

		<hr>

		<h1>Personal Info</h1>

		<form action='functions/booking.php' method='post'>


					<div class='form-group'>
						<label>First Name</label>
						<input type='text' name='fname_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<label>Middle Name</label>
						<input type='text' name='mname_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<label>Last Name</label>
						<input type='text' name='lname_tb' class='form-control' requried/>
					</div>

					<div class='form-group'>
						<label>Contact No</label>
						<input type='text' name='contactno_tb' class='form-control' requried/>
					</div>

					
					<center>

					    <div class="g-recaptcha" data-sitekey="6LfSBlMUAAAAADRnuDp_yp-OYQuI88bSuzyqZcUo"></div>
					</center>
					
					<br>

					<div class='form-group'>
						<input type='submit' class='form-control' value='Book'/>
					</div>

		</form>



		

	</div>


	<br>
	<br>
	<br>
	<br>
	<br>

</body>


</html>