<?php
    @include '../database.php';

    if(isset($_POST['sub'])){
        $empid = $_POST['empid'];
        $empid = filter_var($empid,FILTER_SANITIZE_STRING);
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        $lname = $_POST['lname'];
        $lname = filter_var($lname,FILTER_SANITIZE_STRING);
        $emailid = $_POST['emailid'];
        $emailid = filter_var($emailid,FILTER_SANITIZE_STRING);
        $mobile = $_POST['mobile'];
        $mobile = filter_var($mobile,FILTER_SANITIZE_STRING);
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass,FILTER_SANITIZE_STRING);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass,FILTER_SANITIZE_STRING);
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        $photo = $_FILES['photo']['name'];
        $photo = filter_var($photo, FILTER_SANITIZE_STRING);
        $photo_size = $_FILES['photo']['size'];
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_folder = '../uploaded_img/'.$photo;
        $select = $conn->prepare("Select * from users where email_id = ?");
        $select->execute([$emailid]);

        $Emp_check = $conn->prepare("Select * from users where Emp_id = ?");
        $Emp_check->execute([$empid]);
        $file_type=strtolower(pathinfo($photo,PATHINFO_EXTENSION));
        if($select->rowCount() > 0){
            echo "Employee with email already exist!!"; 
        }elseif($Emp_check->rowCount() > 0){
            echo "Employee with Employee ID already exist";
        }elseif($file_type!="jpg" && $file_type!="png" && $file_type!="jpeg" && $file_type!="webp") {
            echo "Only jpg,jpeg,png,webp are allowed";
        }
        else{
            if($pass != $cpass){
                echo "Passoword did not matched";
            }else{
            $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT,array('cost' => 9));
            $insert = $conn->prepare("Insert into Employee(Emp_id,First_name,Last_name,Mobile_no,email_id,Emp_photo,Password) VALUES(?,?,?,?,?,?,?)");
            $insert->execute([$empid,$fname,$lname,$mobile,$emailid,$photo,$pass]);
            move_uploaded_file($photo_tmp_name, $photo_folder);
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
        <input type="text" name="empid" placeholder="Employee ID" required/>
        <input type="text" name="fname" placeholder="First Name" required/>
        <input type="text" name="lname" placeholder="Last  Name" required/>
        <input type="email" name="emailid" placeholder="Email ID" required/>
        <input type="tel" name="mobile"  placeholder="Mobile No" required/>
        <input type="file" name="photo" placeholder="Employee Image" required  accept="photo/jpg, photo/jpeg, photo/png, photo/webp"/>
        <input type="password" name="pass" placeholder="Password" required/>
        <input type="password" name="cpass" placeholder="Confirm Password" required/>
        <input type="submit" name="sub" value="Register Employee"/>
    </form>
    </body>
</html>