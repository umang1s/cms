<?php
    //  cms/office/
    session_start();
    if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['userId'])){
        header('Location: login.php') ;
        exit(0);
    }
    $loggedId=$_SESSION['loggedIn'];
    if($loggedId>2){
        echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
        header('Locataion: office.php');
        exit(0);
    }
    include('connection.php');
    $query34;
    if(isset($_GET['dt'])){
        $idd=$_GET['dt'];
        $quer43="DELETE FROM employee_table where id='$idd'";
        $data=mysqli_query($conn,$quer43);
        if($data) echo "<h2 align='center' style='color:red;'>Deleted</h2>";
        else echo "<h2 align='center' style='color:orange;'> Failed Deleted</h2>";
    }
    if(isset($_GET['op'])){
        $sortby=$_GET['op'];
        switch($sortby){
            case 1: $query34="SELECT * FROM employee_table ORDER BY empName"; break;
            case 2: $query34="SELECT * FROM employee_table ORDER BY emailid"; break;
            case 3: $query34="SELECT * FROM employee_table ORDER BY employeetype"; break;
            case 4: $query34="SELECT * FROM employee_table ORDER BY addrs"; break;
            case 5: $query34="SELECT * FROM employee_table ORDER BY mobileno"; break;
            case 6: $query34="SELECT * FROM employee_table ORDER BY addedDate"; break;
            case 7: $query34="SELECT * FROM employee_table ORDER BY officeId"; break;
            default: $query34="SELECT * FROM employee_table ORDER BY  id"; break;
        }
    }else $query34="SELECT * FROM employee_table";

    $result=mysqli_query($conn,$query34);
    $totalrows=mysqli_num_rows($result);
    if($totalrows==0){
        echo "<a href='login.php'>Home</a><br>
        <h1  style='color:green;' align='center'>Employee List</h1>";
        echo "<br><br><h1 align='center' style='color:red;'>No Employee found </h1><br>";
        exit(0);
    }
    $_GET=array();

    function getposttype($val){
        if($val==1) return 'Admin';
        else if($val==2) return 'Manager';
        else if($val==3) return 'Office Staff';
        else return 'Postman';
    }
?>
<html>
    <head>
        <title>Offices</title>
        <meta name="viewport" content="width=device-width,initial-scalse=1.0">
        <link rel="stylesheet" href="table.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href='login.php'><font  size=5px class="divLogin">Home</font></a><br>
        <h1  style='color:green;' align='center'>Employee List</h1><br>

        <?php
            $tableno=1;
            echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th><a href='view_employee.php'>Id</a></th>
                        <th><a href='view_employee.php?op=1'>Name</th>
                        <th><a href='view_employee.php?op=2'>Email</th>
                        <th><a href='view_employee.php?op=3'>Post</th>
                        <th><a href='view_employee.php?op=4'>Address</th>
                        <th><a href='view_employee.php?op=5'>mobile no</th>
                        <th><a href='view_employee.php?op=6'>Added date</th>
                        <th><a href='view_employee.php?op=7'>Office Id</th>
                        <th colspan='2'><font color='brown' >Operation</font></th>
                    </tr>
                </thead><tbody>";
                while($rowdata=mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td>".$tableno."</td>
                            <td >".$rowdata['id']."</td>
                            <td >".$rowdata['empName']."</td>
                            <td >".$rowdata['emailid']."</td>
                            <td>".getposttype($rowdata['employeetype'])."</td>
                            <td>".$rowdata['addrs']."</td>
                            <td>".$rowdata['mobileno']."</td>
                            <td>".$rowdata['addedDate']."</td>
                            <td>".$rowdata['officeId']."</td>
                            <td><a href='edit_employee.php?id=$rowdata[id]'><font color='orange' >Edit</font></a></td>
                            <td><a href='view_employee.php?id=$rowdata[id]&dt=1'><font color='red' >Delete</font></a></td>
                      </tr>";
                      
                    $tableno++;
                }
                echo "</tbody></table>";
               
        ?>
        
    </body>


</html>


