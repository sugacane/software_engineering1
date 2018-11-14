<?php

session_start();
//IF USER IS NOT A ADMIN, SEND THEM TO HOME PAGE
if(isset($_SESSION['admin_status']))
{
  // if not admin send home
  if($_SESSION['admin_status'] == 0)
  {
    $newurl = "home.php";
    header('Location: '.$newurl);
    die();
  }
} else
{
  // user has not logged in
  session_destroy();
  $newurl = "index.php";
  header('Location: '.$newurl);
  die();
}

if(!isset($_GET["des"]))
{
  // send to admin page 
  $newurl = "admin_home.php";
  header('Location: '.$newurl);
  die();
}

require('config.php');
//require_once('destination_names.php');

// 
function sendBus($destination)
{
  //
	$status = 1;
	$time = date("Y-m-d H:i:s"); //
	
  
  $conn = new mysqli(hostname, user, password, db_name);
  
  $sql= "UPDATE tracking SET status = 1, 	pickup_time=? WHERE destination=? AND status=0 ORDER BY time_requested DESC LIMIT 26";
  
  // prepare and bind
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $time,$destination);
  
  $stmt->execute();
  
  //$rc = $stmt->get_result();
  
  // data is at least 1
  if($stmt->affected_rows > 0 ) 
  {
    echo "affected [".$stmt->affected_rows."] student accounts ";
  } else 
	{
		echo "Something went really wrong";
	}
  
} // 
$destination = $_GET["des"];
sendBus($destination);
?>