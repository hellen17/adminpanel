<?php
$connect = mysqli_connect("localhost", "root", "", "swapdb");
if(isset( $_POST["user_id"],$_POST["name"],$_POST["description"],$_POST["price_estimate"],$_POST["category"]))
{

 $user_id = mysqli_real_escape_string($connect, $_POST["user_id"]);
 $name = mysqli_real_escape_string($connect, $_POST["name"]);
 $description = mysqli_real_escape_string($connect, $_POST["description"]);
 $price_estimate = mysqli_real_escape_string($connect, $_POST["price_estimate"]);
 $category = mysqli_real_escape_string($connect, $_POST["category"]);

 
 $query = "INSERT INTO goods(user_id, last_name,category,email) VALUES('$first_name', '$last_name','$category')";

 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
}
?>