<?php


function PRINT_NAV()
{
	echo "
		<div id='nav'>
			
			<button style='color:black!important' onclick='window.location.href=\"admin.php\"'>Home</button>
			<button style='color:black!important' onclick='window.location.href=\"confirmed.php\"'>Confirmed</button>
			<button style='color:black!important' onclick='window.location.href=\"cancelled.php\"'>Cancelled</button>
			<button style='color:black!important' onclick='window.location.href=\"noshow.php\"'>No Show</button>
			<button style='color:black!important' onclick='window.location.href=\"accounts.php\"'>Accounts</button>
			<button style='color:black!important' onclick='window.location.href=\"employee.php\"'>Employee</button>
			<button style='color:black!important' onclick='window.location.href=\"products.php\"'>Products/Services</button>
			
		</div>


		<br>
		<br>
		<br>";
}


?>