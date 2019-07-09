<?php
session_start();
//get values
if(isset($_POST['user'])){
	echo "user is set.";
}
$user=$_POST['user'];
$password=$_POST['password'];

//prevent mysql injection
$mysqli = new mysqli("localhost", "root", "", "swapdb");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
$user = $mysqli->real_escape_string($_POST['user']);
$password = $mysqli->real_escape_string($_POST['password']);


//Query datbase for user
$result=$mysqli->query("select *from admin where user ='$user' and password ='$password'") or die("failed to query database" .mysqli_error());
$row=mysqli_fetch_array($result);


if(isset($row)){
	user($row);
}else{
	admin($mysqli,$user,$password);
}


function user($row){
	echo "Login successful";
	$_SESSION['user_Id']=$row['user_Id'];
	$_SESSION['user']=$row['user'];
	$_SESSION['email']=$row['email'];
	$_SESSION['password']=$row['password'];
	header("location: adminhome.php");
}


function admin($mysqli,$user,$password){
	$result=$mysqli->query("select *from admin where user ='$user' and password ='$password'") or die("failed to query database" .mysqli_error());
		$row=mysqli_fetch_array($result);

		if(isset($row)){
			echo "Login successful";
			$_SESSION['user']=$row['user'];
			// $_SESSION['email']=$row['email'];
			$_SESSION['password']=$row['password'];
			header("location: adminhome.php");
		}else{
			counselor($mysqli,$user,$password);
		}
}



function login_error(){
	
header( "refresh:0.5; url=Registration.html" );
$message = "Invalid username or password";
echo "<script type='text/javascript'>alert('$message');</script>";

}