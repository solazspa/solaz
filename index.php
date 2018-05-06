<?php
session_start();


		include("functions/db.php");
		include("includes/utils.php");

		GET_CONNECTION();

?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Booking</title>
	
<?php include("includes/head.php"); PRINT_HEAD(); ?>



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
		        <th>Action</th>
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

			    					<td><a href='book_select.php?cart_remove=".$x."'>Remove</a></td>

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

				echo "<br><center><button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"booking_personal_info.php\"'>Proceed</button></center>";

			}
		?>


		<br>
		<br>

		<hr>


		<?php

		if(!isset($_SESSION['selected_service']))
		{
			echo "
			<h4><b>Select Service</b></h4>

			<table class='table table-striped'>

				<thead>
			      <tr>
			        <th>Service</th>
			        <th>Price</th>
			        <th>Duration (minutes)</th>
			        <th>Action</th>
			      </tr>
			    </thead>

			    <tbody>
			    ";




			    	$sess_name = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');

			    	$row = MYSQL_SELECT("select * from products",$sess_name,3);

			    	for($x=0;$x<$row;$x++)
			    	{

			    		echo "<tr>
			    		<td>".$_SESSION[$sess_name.'_'.$x.'_1']."</td>
			    		<td>".$_SESSION[$sess_name.'_'.$x.'_2']."</td>
			    		<td>".$_SESSION[$sess_name.'_'.$x.'_3']."</td>
			    		<td><a href='book_select.php?selected_service=".$_SESSION[$sess_name.'_'.$x.'_0']."&service_name=".$_SESSION[$sess_name.'_'.$x.'_1']."&service_price=".$_SESSION[$sess_name.'_'.$x.'_2']."&service_duration=".$_SESSION[$sess_name.'_'.$x.'_3']."'>Select</a></td>
			    		</tr>";
			    	}



			echo "
			    </tbody>

			</table>";

		}


		if(!isset($_SESSION['selected_time']) && isset($_SESSION['selected_service']))
		{
			echo "
			<h4><b>Select Date & Time</b></h4>

			<p>Service: ".$_SESSION['service_name']." <a href='book_select.php?remove_selected_service=remove'>Remove</a>



			<form action='book_select.php' method='get'>


					<div class='form-group'>
						<input type='datetime-local' name='date_tb' class='form-control' value='2018-01-01T08:00' requried/>
					</div>

					<div class='form-group'>
						<input type='submit' class='form-control' value='Select'/>
					</div>

			</form>




			";

		}


		if(isset($_SESSION['selected_time']) && isset($_SESSION['selected_service']) && !isset($_SESSION['selected_employee']))
		{




			echo "
			<h4><b>Select Preferred Personnel</b></h4>

			<p>Service: ".$_SESSION['service_name']." <a href='book_select.php?remove_selected_service=remove'>Remove</a>
			<p>Service: ".DateNumToTextAndTime($_SESSION['selected_time'])." <a href='book_select.php?remove_selected_time=remove'>Remove</a>


			";


			//get duration
			$sess_nameduration = "dataduration_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');


			MYSQL_SELECT("select minutes from products where p_text='".str_replace("'", "''", $_SESSION['service_name'])."'",$sess_nameduration,0);


			$duration = $_SESSION[$sess_nameduration.'_0_0'];


			$enddate = Date('Y-m-d H:i',strtotime($_SESSION['selected_time'].' + '.$duration.' minutes'));



			//get employee
			$sess_nameemployee = "dataemployee_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');
			$rowemployee = MYSQL_SELECT("select employee.e_id,employee.f_name,employee.m_name,employee.l_name from employee,employee_products where employee.e_id=employee_products.e_id and employee_products.p_id=".$_SESSION['selected_service'],$sess_nameemployee,3);





			$have_employee = false;


			$count_skip = 0;


			for($x=0;$x<$rowemployee;$x++)
		    {

		    	$sess_nameemployeebook = "dataemployeebook_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s').$x . "1";
				MYSQL_SELECT("select e_id from booking where e_id=".$_SESSION[$sess_nameemployee.'_'.$x.'_0']." and (schedule between '".$_SESSION['selected_time'].":00' and '".$enddate.":59')  and book_status <> 'Cancelled'",$sess_nameemployeebook,0);

				$ok_employee = true;

				if(isset($_SESSION[$sess_nameemployeebook.'_0_0']))
				{
						if($_SESSION[$sess_nameemployeebook.'_0_0'] != 0)
						{
							$ok_employee = false;
						}
				}


				if($ok_employee==true)
				{
					$have_employee = true;

					if($count_skip==0)
					{
					echo "
					<br>
					<br>
					<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"book_select.php?selected_employee=".$_SESSION[$sess_nameemployee.'_'.$x.'_0']."&employeename=".$_SESSION[$sess_nameemployee.'_'.$x.'_1']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_2']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_3']."\"'>Skip</button>";
					$count_skip++;

					}

				}


		    }







			echo "

			<table class='table table-striped'>

				<thead>
			      <tr>
			        <th>Employee Name</th>
			        <th>Action</th>
			      </tr>
			    </thead>

			    <tbody>
			    ";


			
			





			if($have_employee==false)
			{
				echo "<tr>
			    		<td>Date & Time is not available</td>
			    		<td></td>
			    		</tr>";
			}





			for($x=0;$x<$rowemployee;$x++)
		    {

		    	$sess_nameemployeebook2 = "dataemployeebook_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s').$x;
				MYSQL_SELECT("select e_id from booking where e_id=".$_SESSION[$sess_nameemployee.'_'.$x.'_0']." and (schedule between '".$_SESSION['selected_time'].":00' and '".$enddate.":59') and book_status <> 'Cancelled'",$sess_nameemployeebook2,0);

				$ok_employee = true;

				if(isset($_SESSION[$sess_nameemployeebook2.'_0_0']))
				{
						if($_SESSION[$sess_nameemployeebook2.'_0_0'] != 0)
						{
							$ok_employee = false;
						}
				}


				if($ok_employee==true)
				{
					echo "<tr>
			    		<td>".$_SESSION[$sess_nameemployee.'_'.$x.'_1']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_2']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_3']."</td>
			    		<td><a href='book_select.php?selected_employee=".$_SESSION[$sess_nameemployee.'_'.$x.'_0']."&employeename=".$_SESSION[$sess_nameemployee.'_'.$x.'_1']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_2']." ".$_SESSION[$sess_nameemployee.'_'.$x.'_3']."'>Select</a></td>
			    		</tr>";
				}


		    }



		    echo "
			    </tbody>

			</table>";



		}



		if(isset($_SESSION['selected_time']) && isset($_SESSION['selected_service']) && isset($_SESSION['selected_employee']))
		{




			echo "
			<h4><b>Please confirm.</b></h4>

			<p>Service: ".$_SESSION['service_name']." <a href='book_select.php?remove_selected_service=remove'>Remove</a>
			<p>Service: ".DateNumToTextAndTime($_SESSION['selected_time'])." <a href='book_select.php?remove_selected_time=remove'>Remove</a>
			<p>Preferred Personel: ".$_SESSION['employee_name']." <a href='book_select.php?remove_selected_employee=remove'>Remove</a>
			<br>
			<br>
			<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"book_select.php?cart=add\"'>Add</button>
			";

		}


		?>



		

	</div>

</body>


</html>