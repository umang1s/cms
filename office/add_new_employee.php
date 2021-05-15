<?php

    //cms/office/
    include('../php/localMethod.php');
   // error_reporting(0);
   session_start(); //user id
   if(!isset($_SESSION['loggedIn'])){
    header('Location: login.php'); exit(0);
   }
   if($_SESSION['loggedIn']>2){
    echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
    header('Location: office.php');
    exit(0);
   }
   include('connection.php');
    $error='';
    $datareceived=false;
    $waitstart=false;
    $newId=0;
    if(isset($_POST['submit'])){
        $datareceived=true;
        $type=$_POST['emptype'];
        $officeId=$_POST['officeid'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass1=$_POST['pass1'];
        $pass2=$_POST['pass2'];
        $address=$_POST['address'];
        $mobileno=$_POST['mobileno'];
        if(validationOfOffice($officeId) ){
            if($pass1==$pass2){
                $password=md5($pass1);
                $query = "INSERT INTO employee_table(emailid ,empName,employeetype,officeId ,
                addedDate ,addedBy ,mobileno ,addrs ,passwords) VALUE('$email','$name','$type','$officeId',
                now(),'$_SESSION[userId]','$mobileno','$address','$password')";
                $data=mysqli_query($conn,$query);
                if($data){   
                    $waitstart=true;
                    $query57="SELECT * FROM employee_table where emailid='$email'";
                    $resdata=mysqli_query($conn,$query57);
                    $resres=mysqli_fetch_array($resdata);
                    $newId=$resres['id'];
                } else {
                    $error='Failed to Add';
                }
            }else $error='Password is not matching';
            
        }else $error='Invalid office id'; 
        unset($_POST);
    }
 ?>

<html>
    <head>
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div class="divLogin">
            <form action="" method="POST" class="loginContainer">
            <h2   > Add new Employee</h2>
                <p>
                    Choose Employee Type
                    <select name="emptype" value="4">
                    <option value="1">Admin</option>
                    <option value="2">Manager</option>
                    <option value="3">Staff</option>
                    <option value="4">Postman</option>
                    </select>
                </p>
                <input type="text" placeholder="Enter name" name="name" required>
                <input type="text" placeholder="Enter email" name="email" required>
                <input type="text" placeholder="Enter Permanent address" name="address" required>
                <input type="text" placeholder="Enter office id" name="officeid" required>
                <input type="text" placeholder="Enter mobile no" name="mobileno" required>
                <input type="password" placeholder="Create password" name="pass1" required>
                <input type="password" placeholder="enter again password" name="pass2" required>
                <?php 
                    if($datareceived){
                        if(!$error=='') echo"<font color='red'>$error</font><br>";
                    }
                ?>
                <input type="submit" name="submit"><br>
                <a href="admin.php"> Back to Home</a>
                <br>
            </form>

        </div>
    </body>
</html>

<?php
    if($waitstart){
        session_start();
        $_SESSION['message']='ID is : '.$newId;
        $_SESSION['returnlocation']='login.php';
        header('Location:successfully.php');
        exit(0);
    }
?>