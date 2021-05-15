<?php
    //  cms/office/
    session_start();
    if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['userId'])){
        header('Location: login.php') ;
        exit(0);
    }
    $loggedId=$_SESSION['loggedIn'];
    include('connection.php');
    $query34;
    if(isset($_GET['dt']) && $loggedId<3){
        if($loggedID<3){
            $idd=$_GET['id'];
            $quer43="DELETE FROM office where officeId='$idd'";
            $data=mysqli_query($conn,$quer43);
            if($data) echo "<h2 align='center' style='color:red;'>Deleted</h2>";
            else echo "<h2 align='center' style='color:orange;'> Failed Deleted</h2>";
        } else echo "<h2 align='center' style='color:orange;'>Permission Denied</h2>";
        
    }
    if(isset($_GET['op'])){
        $sortby=$_GET['op'];
        switch($sortby){
            case 1: $query34="SELECT * FROM office ORDER BY addrs"; break;
            case 2: $query34="SELECT * FROM office ORDER BY pincode"; break;
            case 3: $query34="SELECT * FROM office ORDER BY district"; break;
            case 4: $query34="SELECT * FROM office ORDER BY states"; break;
            case 5: $query34="SELECT * FROM office ORDER BY addedTime"; break;
            case 6: $query34="SELECT * FROM office ORDER BY typ"; break;
            default: $query34="SELECT * FROM office ORDER BY  officeId"; break;
        }
    }else $query34="SELECT * FROM office";

    $result=mysqli_query($conn,$query34);
    $totalrows=mysqli_num_rows($result);
    if($totalrows==0){
        echo "<a href='login.php' class=divLogin>Home</a><br>
        <h1  style='color:green;' align='center'>Office List</h1>";
        echo "<br><br><h1 align='center' style='color:red;'>No Office found </h1><br>";
        exit(0);
    }
    $_GET=array();

    function getOfficeType($val){
        if($val==1) return 'Sub Office';
        if($val==2) return 'Office';
        if($val==3) return 'Main Office';
        return 'Head Office';
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
        <h1  style='color:green;' align='center'>Office List</h1><br>
        <?php
            $tableno=1;
            echo "<table class='styled-table'>
                    <thead>
                    <tr>
                        <th >Sn.</th>
                        <th><a href='view_office.php'>Id</a></th>
                        <th><a href='view_office.php?op=1'>Address</th>
                        <th><a href='view_office.php?op=2'>Pincode</th>
                        <th><a href='view_office.php?op=3'>District</th>
                        <th><a href='view_office.php?op=4'>State</th>
                        <th><a href='view_office.php?op=5'>Added date</th>
                        <th><a href='view_office.php?op=6'>Type</th>";
                        if($loggedId<3) echo "<th colspan='3'><font color='brown' >Operation</font></th>";
                        echo "</tr></thead><tbody>";
                while($rowdata=mysqli_fetch_assoc($result)){
                    echo "
                        <tr>
                            <td >".$tableno."</td>
                            <td >".$rowdata['officeId']."</td>
                            <td>".$rowdata['addrs']."</td>
                            <td>".$rowdata['pincode']."</td>
                            <td>".$rowdata['district']."</td>
                            <td>".$rowdata['states']."</td>
                            <td>".$rowdata['addedTime']."</td>
                            <td>".getOfficeType($rowdata['typ'])."</td>";
                            if($loggedId<3) echo "
                            <td><a href='connected_office.php?id=$rowdata[officeId]'><font color='green' >View</font></a></td>
                            <td><a href='edit_office.php?id=$rowdata[officeId]'><font color='orange' >Edit</font></a></td>
                            <td><a href='view_office.php?id=$rowdata[officeId]&dt=1'><font color='red' >Delete</font></a></td>";
                     echo "</tr>";
                    $tableno++;
                } 
                echo '</dbody></table>';
               
        ?>
        
    </body>


</html>


