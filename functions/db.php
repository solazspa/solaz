<?php


error_reporting(0);


function GET_CONNECTION()
{
	

	$db_mysql = mysqli_connect("localhost","solazspa_admin","solazspaadmin12345","solazspa_bookingdb");

	if(!$db_mysql)
	{
		$_SESSION['error'] = "No Database Connection.";
	}
	

	return $db_mysql;


	
}







function MYSQL_CHECK($table,$select_var,$if_var,$equal_var,$string)
{


	$db_mysql = GET_CONNECTION();

	

	if($string==1)
	{
		$query = "select ".$select_var." from ".$table." where ".$if_var."='".$equal_var."'";
	}
	else
	{
		$query = "select ".$select_var." from ".$table." where ".$if_var."=".$equal_var;
	}
	


	$result = mysqli_query($db_mysql,$query);

	$ok=true;

	while($row = mysqli_fetch_array($result))
	{
		$ok = false;
	}


	return $ok;


}




function MYSQL_INSERT($table,$columns,$values)
{


	$db_mysql = GET_CONNECTION();


	$query = "insert into ".$table."(".$columns.") values (".$values.")";




	mysqli_query($db_mysql,$query);


}



function MYSQL_SELECT($query,$session_name,$session_num)
{	


	$db_mysql = GET_CONNECTION();
	
	$session_rows = 0;

	$result = mysqli_query($db_mysql,$query);

	

	while($row = mysqli_fetch_array($result))
	{
		

		for($x=0;$x <= $session_num;$x++)
		{
			$_SESSION[$session_name."_".$session_rows."_".$x]=$row[$x];
		}

		$session_rows++;
		
	}

	return $session_rows;

}


function MYSQL_UPDATE($query)
{


	$db_mysql = GET_CONNECTION();
	

	mysqli_query($db_mysql,$query);


}


function MYSQL_DELETE($query)
{


	$db_mysql = GET_CONNECTION();
	

	mysqli_query($db_mysql,$query);



}





?>