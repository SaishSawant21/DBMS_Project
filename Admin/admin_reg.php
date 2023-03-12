<?php
    @include '../database.php';

    if(isset($_POST['sub'])){
        $adminid = $_POST['adminid'];
        $adminid = filter_var($adminid,FILTER_SANITIZE_STRING);
        $uname = $_POST['uname'];
        $uname = filter_var($uname,FILTER_SANITIZE_STRING);
        $emailid = $_POST['emailid'];
        $emailid = filter_var($emailid,FILTER_SANITIZE_STRING);
        $mobile = $_POST['mobile'];
        $mobile = filter_var($mobile,FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass,FILTER_SANITIZE_STRING);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass,FILTER_SANITIZE_STRING);
        $select = $conn->prepare("Select * from admin where email_id = ?");
        $select->execute([$emailid]);

        $Admin_check = $conn->prepare("Select * from users where Admin_id = ?");
        $Admin_check->execute([$adminid]);
        if($select->rowCount() > 0){
            echo "Admin with email already exist!!"; 
        }elseif($Admin_check->rowCount() > 0){
            echo "Employee with Employee ID already exist";
        }
        else{
            if($pass != $cpass){
                echo "Passoword did not matched";
            }else{
            $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT,array('cost' => 9));
            $insert = $conn->prepare("Insert into Admin(Admin_id,Username,Mobile_no,email_id,Password) VALUES(?,?,?,?,?)");
            $insert->execute([$adminid,$uname,$mobile,$emailid,$pass]);
            echo "Successfully Added";
        }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Employee Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="adminid" placeholder="Admin ID" required/>
        <input type="text" name="uname" placeholder="Username" required/>
        <input type="email" name="emailid" placeholder="Email ID" required/>
        <input type="tel" name="mobile"  placeholder="Mobile No" required/>
        <input type="password" name="pass" placeholder="Password" required/>
        <input type="password" name="cpass" placeholder="Confirm Password" required/>
        <input type="submit" name="sub" value="Register Admin"/>
    </form>
    </body>
</html>