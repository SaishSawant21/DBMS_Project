<?php

@include '../database.php';


if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

  
   
   $sql = "SELECT * FROM `Employee` WHERE email_id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);


   

   if($rowCount > 0){

    if(password_verify($pass,$row['Password'])){
         echo "login successful";

      }
      else{
         echo 'Invalid Details';
      }
   }else{
      echo 'Invalid Details!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
      <h3>Login Now</h3>
      <input type="email" name="email" class="box" placeholder="Enter Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required title="Please enter valid email">
      <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
      <input type="submit" value="Login" class="btn" name="submit">
      <br>
      <br>
</form>
</body>
</html>
