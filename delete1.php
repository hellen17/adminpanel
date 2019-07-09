<?php
$connect = mysqli_connect("localhost", "root", "", "swapdb");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM users WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>