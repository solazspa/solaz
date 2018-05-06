<?php


		session_start();

		include("includes/isloggedin.php");
		include("includes/utils.php");
		include("functions/db.php");

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

?>


<!DOCTYPE html>

<html>

<head>

<title>SPA System - Admin</title>
	
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

	
	<center><h1><b>Confirmed Schedules</b></h1></center>


	<hr>
						<div class='container'>
							<?php


								echo "<form  method ='get'>
								 		<input type='hidden' name='id' value = '".$_GET['id']."'/>
									<div class='form-group'>
												<label>Filter by Date From</label>
												<input type='date' name='searchdatefrom' class='form-control' value= '";

												if(isset($_GET['searchdatefrom'])){echo $_GET['searchdatefrom'];} echo "'  requried>
												<label>To</label>
												<input type='date' name='searchdateto' class='form-control' value= '";
												 if(isset($_GET['searchdatefrom'])){echo $_GET['searchdateto'];} echo "' requried>
										</div>

										<input type='submit' value='Filter'/>

									</form>


									";


									if(isset($_GET['bookingno']))
									{
										if($_GET['bookingno'] != "")
										{
											$_SESSION['search_booking_no2'] = $_GET['bookingno'];
										}
										else
										{
											unset($_SESSION['search_booking_no2']);
										}
										
									}


							?>

							<br>

							<form method ='get'>
							<div class='form-group'>
										<label>Search Booking No</label>
										<input type='number' name='bookingno' class='form-control' value ='<?php if(isset($_SESSION['search_booking_no2'])){echo $_SESSION['search_booking_no2'];} ?>' requried>
								</div>

								<input type='submit' value='Search'/>

							</form>

						</div>







	<hr>

	<br>

			<table style='padding:10px' class='table table-striped'>

				<thead>
			      <tr>
			        <th>Service</th>
			        <th>Personnel</th>
			         <th>Client</th>
			         <th>Contact No</th>
			        <th>Time</th>
			      </tr>
			    </thead>

			    <tbody>



			    	<?php






			    			$query = "select * from booking where book_status = 'Confirmed' order by schedule asc";


								if(isset($_GET['searchdatefrom']) && isset($_GET['searchdateto']))
						    	{

						    		if($_GET['searchdatefrom'] != "" && $_GET['searchdateto'] == "")
						    		{
						    			$search_this = str_replace("'", "''", $_GET['searchdatefrom']);

						    			$query = "select * from booking where book_status = 'Confirmed' and schedule like '%".$search_this."%' order by schedule asc";
						    		}

						    		if($_GET['searchdatefrom'] != "" && $_GET['searchdateto'] != "")
						    		{


						    			
						    				$search_this = str_replace("'", "''", $_GET['searchdatefrom']);

							    			$search_this2 = str_replace("'", "''", $_GET['searchdateto']);

							    			$query = "select * from booking where book_status = 'Confirmed' and (schedule between '".$search_this." 00:00:00' and '".$search_this2." 23:59:59')  order by schedule asc";


						    			
						    		}



						    		
						    	}


						    	if(isset($_GET['bookingno']))
						    	{
						    		if(preg_match("/^[0-9]{1,}$/", $_GET['bookingno']))
									{

										$query = "select * from booking where book_status = 'Confirmed' and bill_id=".$_GET['bookingno']." order by schedule asc";

										

									}

						    	}


						    	if(isset($_SESSION['search_booking_no2']))
						    	{
						    		$query = "select * from booking where book_status = 'Confirmed' and bill_id=".$_SESSION['search_booking_no2']." order by schedule asc";
						    	}







						    $sess_nameall = "dataConfirmed_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');
			    			
							$row2 = MYSQL_SELECT($query,$sess_nameall,6);




							for($x=0;$x<$row2;$x++)
							{


								//select service

								$sess_nameservice = "dataservice_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s').$x;

								MYSQL_SELECT("select * from products where p_id = ".$_SESSION[$sess_nameall.'_'.$x.'_3'],$sess_nameservice,3);

								$service_name = $_SESSION[$sess_nameservice.'_0_1'];
								$service_duration = $_SESSION[$sess_nameservice.'_0_3'];



								//select service

								$sess_namepersonnel = "datapersonnel_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s').$x;

								MYSQL_SELECT("select * from employee where e_id = ".$_SESSION[$sess_nameall.'_'.$x.'_2'],$sess_namepersonnel,3);

								$personnel_name = $_SESSION[$sess_namepersonnel.'_0_1'] . " " . $_SESSION[$sess_namepersonnel.'_0_2'] . " " . $_SESSION[$sess_namepersonnel.'_0_3'];


								$time = DateNumToTextAndTime($_SESSION[$sess_nameall.'_'.$x.'_4']);

								$enddate = Date('Y-m-d H:i',strtotime($_SESSION[$sess_nameall.'_'.$x.'_4'].' + '.$service_duration.' minutes'));

								$time .= " - " . DateNumToTextAndTime($enddate);




								//select service

								$sess_nameclient = "dataclient_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s').$x;

								MYSQL_SELECT("select * from billing where bill_id = ".$_SESSION[$sess_nameall.'_'.$x.'_1'],$sess_nameclient,4);


								$client_name = $_SESSION[$sess_nameclient.'_0_1'] . " " . $_SESSION[$sess_nameclient.'_0_2'] . " " . $_SESSION[$sess_nameclient.'_0_3'];
								$contact_no = $_SESSION[$sess_nameclient.'_0_4'];



								echo "<tr>

									<td>".$service_name."</td>
									<td>".$personnel_name."</td>
									<td>".$client_name."</td>
									<td>".$contact_no."</td>
									<td>".$time."</td>
									

								</tr>";



							}





			    	?>


			    </tbody>


			</table>



</body>


</html>