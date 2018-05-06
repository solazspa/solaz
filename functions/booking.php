<?php
session_start();

sleep ( rand ( 2, 10));



include("db.php");

if($_POST)
{
    
    $recaptcha_ok = false;
    
    
    
    if(isset($_POST['g-recaptcha-response']))
    {
        if(!empty($_POST['g-recaptcha-response']))
        {
            
            
            $secret_key = "6LfSBlMUAAAAAFx1ru2nVrN-GWaYcw3jXlOeNTQ1";
            $ip = $_SERVER["REMOTE_ADDR"];
            $captcha = $_POST['g-recaptcha-response'];
            
            $url = 'https://www.google.com/recaptcha/api/siteverify';
        	$data = array(
        		'secret' => $secret_key,
        		'response' => $captcha
        	);
        	$options = array(
        		'http' => array (
        			'method' => 'POST',
        			'content' => http_build_query($data)
        		)
        	);
        	$context  = stream_context_create($options);
        	$verify = file_get_contents($url, false, $context);
        	$captcha_success=json_decode($verify);
        	if ($captcha_success->success==false) {
        		//you are a bot
        	} else if ($captcha_success->success==true) {
        		$recaptcha_ok = true;
        	}
            
            
            
        }
    }
    
    
    

	if(isset($_POST['fname_tb']) && isset($_POST['mname_tb']) && isset($_POST['lname_tb'])  && isset($_POST['contactno_tb']) && $recaptcha_ok==true)
	{


		$_POST['fname_tb'] = str_replace("'", "''", $_POST['fname_tb']);
		$_POST['mname_tb'] = str_replace("'", "''", $_POST['mname_tb']);
		$_POST['lname_tb'] = str_replace("'", "''", $_POST['lname_tb']);
		$_POST['contactno_tb'] = str_replace("'", "''", $_POST['contactno_tb']);


			$ok = true;


			if(checkallitemsfirst()==false)
			{
				$ok = false;

				$_SESSION['error'] = "Some schedules are not available and automatically removed. Please review your selected service(s).";
				header("location:../index.php");
			}





			if($ok == true)
			{

				MYSQL_INSERT("billing","f_name,m_name,l_name,contact_no","'".$_POST['fname_tb']."','".$_POST['mname_tb'] . "','".$_POST['lname_tb']."','".$_POST['contactno_tb']."'");





				$sess_name22 = "databookingno_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s');


				MYSQL_SELECT("select bill_id from billing where f_name='".$_POST['fname_tb'] . "' and m_name='".$_POST['mname_tb'] . "' and l_name='".$_POST['lname_tb'] . "' and contact_no='".$_POST['contactno_tb'] ."'",$sess_name22,0);

				$billing_no = $_SESSION[$sess_name22.'_0_0'];


				date_default_timezone_set('Asia/Manila');


				for($x=0;$x<$_SESSION['booking_counter'];$x++)
		    			{

		    				if(!empty($_SESSION['booking_'.$x.'_1']))
		    				{


		    					
		    					MYSQL_INSERT("booking","bill_id,e_id,p_id,schedule,book_status,book_date",$billing_no.",".$_SESSION['booking_'.$x.'_5'].",".$_SESSION['booking_'.$x.'_0'].",'".$_SESSION['booking_'.$x.'_4']."','Pending','".Date('Y-m-d H:i:s')."'");




		    				}


		    			}




				$_SESSION['success'] = "Successfully booked. Booking No: ". $billing_no;

				unset($_SESSION['booking_counter']);

				header("location:../index.php");


			}


	}
	else
	{
		$_SESSION['error'] = "Please fill up all fields.";
		//header("location:../booking_personal_info.php");
	}
	
	
	if($recaptcha_ok==false)
    {
        $_SESSION['error'] = "Please verify that you are not a robot.";
				//header("location:../booking_personal_info.php");
    }
    
}
else
{
	header("location:../index.php");
}




function checkallitemsfirst()
{

						$ok_all = true;


						for($x=0;$x<$_SESSION['booking_counter'];$x++)
		    			{

		    				if(!empty($_SESSION['booking_'.$x.'_1']))
		    				{


		    					$enddate = Date('Y-m-d H:i',strtotime($_SESSION['booking_'.$x.'_4'].' + '.$_SESSION['booking_'.$x.'_3'].' minutes'));


		    					$sess_name2 = "dataitemscheck_" . Date('Y') . Date('m') . Date('d') . Date('H') . Date('i') . Date('s') . $x;


								MYSQL_SELECT("select e_id from booking where e_id=".$_SESSION['booking_'.$x.'_5'] . " and (schedule between '".$_SESSION['booking_'.$x.'_4'].":00' and '".$enddate.":59') and book_status <> 'Cancelled'",$sess_name2,0);


								if(isset($_SESSION[$sess_name2.'_0_0']))
								{
									if($_SESSION[$sess_name2.'_0_0'] != 0)
									{
										$ok_all = false;

										$_SESSION['booking_'.$x.'_0'] = "";
										$_SESSION['booking_'.$x.'_1'] = "";
										$_SESSION['booking_'.$x.'_2'] = "";
										$_SESSION['booking_'.$x.'_3'] = "";
										$_SESSION['booking_'.$x.'_4'] = "";
										$_SESSION['booking_'.$x.'_5'] = "";
										$_SESSION['booking_'.$x.'_6'] = "";

									}
								}








		    				}


		    			}



		    			return $ok_all;



}



?>