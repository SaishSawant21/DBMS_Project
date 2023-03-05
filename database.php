<?php

$db_name = "mysql:host=localhost;dbname=cubbicle_booking";
$username= "root";
$password= "";
$conn = new PDO($db_name,$username,$password);

if($conn==TRUE){
    echo "Connection Successful";
}
else{
    echo "Not established";
}
?>