<?php
     session_start();
     $currentUser;
     if(isset($_SESSION['loggedIn'])){
         if($_SESSION['loggedIn']<3){
          header('Location: admin.php');
          exit(0);
         }
         $currentUser=$_SESSION['userId'];
     } else {
         header('Location: login.php');
         exit(0);
     }
     //get office id
     //if 
     include('connection.php');
     $query90="SELECT * FROM employee_table where id='$currentUser'";
     $res90=mysqli_query($conn,$query90);
     $dat90=mysqli_fetch_array($res90);
     $officeId=$dat90['officeId'];
 ?>
<html>
    <head>
        <title> Office</title>
    </head>
    <body>
        <h3> <a href="logout.php">logout</a></h3>
        <h3> <a href='<?php echo "edit_employee.php?id=".$currentUser; ?>'>edit details</a></h3>
        
        <?php 
            if($_SESSION['loggedIn']==3) {echo "<h3> <a href='connected_office.php?id=$officeId'>Connect office</a></h3>";
                echo "<h3> <a href='add_order.php'>add order</a></h3>";
            }
        ?>
        <h3> <a href="<?php  echo 'view_order.php?officeId='.$officeId; ?>">manage order</a></h3>
    </body>
</html>