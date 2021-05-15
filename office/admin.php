<?php
    session_start();
    $currentUser;
   if(isset($_SESSION['loggedIn'])){
       if($_SESSION['loggedIn']>2){
        header('Location: office.php');
        exit(0);
       }
   } else {
       header('Location: login.php');
       exit(0);
   }
   $currentUser=$_SESSION['userId'];
 ?>
<html>
    <head>
        <title> ADMIN Page</title>
    </head>
    <body>
        <h3> <a href="logout.php">logout</a></h3>
        <h3> <a href="add_new_office.php">add new Office</a></h3>
        <h3> <a href="view_office.php">Manage added office</a></h3>
        <h3> <a href="add_new_employee.php">Add employee</a></h3>
        <h3> <a href="view_employee.php">manage employee</a></h3>
        <h3> <a href="add_order.php">add order</a></h3>
        <h3> <a href="set_default_value.php">set Value</a></h3>
        <h3> <a href="../php/track_order.php">track Order</a></h3>
    </body>
</html>