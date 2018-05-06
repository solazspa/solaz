<?php


		session_start();

		include("includes/isloggedin.php");
		include("includes/utils.php");
		include("functions/db.php");

		if(ISLOGGEDIN()==true)
		{
			if(ISADMIN()==true)
			{
				if(isset($_GET['id']))
				{
					if(preg_match("/^[0-9]{1,}$/", $_GET['id']))
					{
						$sess_name = "data_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');


						MYSQL_SELECT("select * from booking where b_id=".$_GET['id'],$sess_name,6);

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

	
	<center><h1><b>Schedule Status</b></h1></center>

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


			    			$sess_nameall = "datapending_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');

							$row2 = MYSQL_SELECT("select * from booking where b_id=".$_GET['id'],$sess_nameall,6);

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
									<td>".$time."</td>";




									



								echo "
								</tr>";

								

							}





			    	?>


			    </tbody>







			</table>



			<br>
			<br>


			<?php

				if(isset($_GET['status']))
				{
					if($_GET['status']=='confirm')
					{
						echo "<center><h3>Do you want to confirm this transaction?</h3>
						<br>

						<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"booking.php?confirm=".$_GET['id']."\"'>Yes</button>
						<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"admin.php\"'>No</button>

						</center>";



					}


					if($_GET['status']=='cancel')
					{
						echo "<center><h3>Do you want to cancel this transaction?</h3>
						<br>

						<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"booking.php?cancel=".$_GET['id']."\"'>Yes</button>
						<button type='button' class='btn-success' style='padding:20px 40px 20px 40px' onclick='window.location.href=\"admin.php\"'>No</button>

						</center>";



					}
				}

			?>

			



</body>


</html>