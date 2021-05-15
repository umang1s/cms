<?php
    session_start();
    include('../php/localMethod.php');
    if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['userId'])){
        header('Location: login.php') ;
        exit(0);
    }
    $loggedId=$_SESSION['loggedIn'];
    if($loggedId>3){
        echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
        header('Locataion: office.php');
        exit(0);
    }
    include('connection.php');
    $query34;
    $query434;
    $officeIds;
    if(isset($_GET['id']) && validationOfOffice($_GET['id'])) $officeIds=$_GET['id'];
    else{
            echo "<h2 align='center' style='color:red;'>Incorrect Information</h2>";
        header('Locataion: office.php');
        exit(0);
    }
    if($loggedId==3){
        $userIDD=$_SESSION['userId'];
        $query89="SELECT * FROM employee_table where id='$userIDD'";
        $ret89=mysqli_query($conn,$query89);
        $fet89=mysqli_fetch_array($ret89);
        if($fet89['officeId']!=$officeIds){
            echo "<h2 align='center' style='color:red;'>Permission Denied</h2>";
            header('Locataion: office.php');
            exit(0);
        }
    }else{
        if(isset($_GET['dte'])){
        $idde=$_GET['dte'];
            $quere43="DELETE FROM employee_table where id='$idde'";
            $datae=mysqli_query($conn,$quere43);
            if($datae) echo "<h2 align='center' style='color:red;'>Deleted Employee</h2>";
            else echo "<h2 align='center' style='color:orange;'> Failed Deleting</h2>";
        }

        if(isset($_GET['ope'])){
            $sortby=$_GET['ope'];
            switch($sortby){
                case 1: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY empName"; break;
                case 2: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY emailid"; break;
                case 3: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY employeetype"; break;
                case 4: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY addrs"; break;
                case 5: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY mobileno"; break;
                case 6: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY addedDate"; break;
                case 7: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY officeId"; break;
                default: $query34="SELECT * FROM employee_table where id='$officeIds'  ORDER BY  id"; break;
            }
        }else $query34="SELECT * FROM employee_table where id='$officeIds' ";
        $result=mysqli_query($conn,$query34);
        $totalrows=mysqli_num_rows($result);
        

    }

    if(isset($_GET['dt'])){
        $idd=$_GET['dt'];
        $quer434="DELETE FROM pincode where id='$idd'";
        $data434=mysqli_query($conn,$quer434);
        if($data434) echo "<h2 align='center' style='color:red;'>Deleted connection</h2>";
        else echo "<h2 align='center' style='color:orange;'> Failed Deleting</h2>";
    }

    if(isset($_GET['op'])){
        $sortb=$_GET['op'];
        switch($sortb){
            case 1: $query44="SELECT * FROM pincode   where offceI='$officeIds' ORDER BY pinF"; break;
            case 2: $query44="SELECT * FROM pincode   where offceI='$officeIds' ORDER BY headOfficeF"; break;
            case 3: $query44="SELECT * FROM pincode   where offceI='$officeIds' ORDER BY distance"; break;
            default: $query44="SELECT * FROM pincode   where offceI='$officeIds' ORDER BY  id"; break;
        }
    }else $query44="SELECT * FROM  pincode where offceI='$officeIds'  ";
    $result4=mysqli_query($conn,$query44);
    $totalrow4=mysqli_num_rows($result4);
    
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
        <a href='view_office.php'><font  size=5px class="divLogin">Home</font></a><br>
        <h1  style='color:green;' align='center'>Office ID : <?php echo $officeIds; ?></h1><br>

        <?php
            $tableno=1;
            echo "<h1  style='color:green;' align='center'>Connected Office List</h1>";
            echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th><a href='connected_office.php?id=$officeIds'>Office Id</a></th>
                        <th><a href='connected_office.php?op=1&id=$officeIds'>Pincode</th>
                        <th><a href='connected_office.php?op=2&id=$officeIds'>HeadOffice</th>
                        <th><a href='connected_office.php?op=3&id=$officeIds'>Distance</th>
                        <th ><font color='brown' >Operation</font></th>
                    </tr>
                </thead><tbody>";
                while($rowdat=mysqli_fetch_assoc($result4)){
                    echo "<tr>
                            <td>".$tableno."</td>
                            <td >".$rowdat['officeF']."</td>
                            <td >".$rowdat['pinF']."</td>
                            <td >".$rowdat['headOfficeF']."</td>
                            <td>".$rowdat['distance']."KM</td>
                            <td><a href='connected_office.php?id=$officeIds&dt=$rowdat[id]'><font color='red' >Delete</font></a></td>
                            
                      </tr>";
                      
                    $tableno++;
                }
                echo "</tbody></table>";
                if($totalrow4==0){
                    echo "<br><br><h1 align='center' style='color:red;'>No Connected Office found </h1><br>";
                }
                echo "<br><br><h1 align='center' style='color:green;'><a href='add_connected.php?id=$officeIds'>--------Add new Connection----</a></h1><br>";
                if($loggedId==3) exit(0);
               
        ?>
        <h1></h1>

        <h1  style='color:green;' align='center'>Office <?php echo $officeIds; ?></h1><br>

        <?php
            if($loggedId!=3){
                $tablen=1;
                echo "<h1  style='color:green;' align='center'>Employee List</h1>";
            echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th><a href='connected_office.php?id=$officeIds'>Id</a></th>
                        <th><a href='connected_office.php?ope=1&id=$officeIds'>Name</th>
                        <th><a href='connected_office.php?ope=2&id=$officeIds'>Email</th>
                        <th><a href='connected_office.php?ope=3&id=$officeIds'>Post</th>
                        <th><a href='connected_office.php?ope=4&id=$officeIds'>Address</th>
                        <th><a href='connected_office.php?ope=5&id=$officeIds'>mobile no</th>
                        <th><a href='connected_office.php?ope=6&id=$officeIds'>Added date</th>
                        <th><a href='connected_office.php?ope=7&id=$officeIds'>Office Id</th>
                        <th colspan='2'><font color='brown' >Operation</font></th>
                    </tr>
                </thead><tbody>";
                while($rowdata=mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td>".$tablen."</td>
                            <td >".$rowdata['id']."</td>
                            <td >".$rowdata['empName']."</td>
                            <td >".$rowdata['emailid']."</td>
                            <td>".getposttype($rowdata['employeetype'])."</td>
                            <td>".$rowdata['addrs']."</td>
                            <td>".$rowdata['mobileno']."</td>
                            <td>".$rowdata['addedDate']."</td>
                            <td>".$rowdata['officeId']."</td>
                            <td><a href='edit_employee.php?id=$rowdata[id]'><font color='orange' >Edit</font></a></td>
                            <td><a href='connected_office.php?id=$officeIds&dte=$rowdata[id]'><font color='red' >Delete</font></a></td>
                      </tr>";
                      
                    $tablen++;
                }
                echo "</tbody></table>";
                if($totalrows==0){
                    echo "<br><br><h1 align='center' style='color:red;'>No Employee found </h1><br>";
                }
                echo "<br><br><h1 align='center' style='color:green;'><a href='view_order.php?officeId=$officeIds'>--------View Order List----</a></h1><br>";

            }
               
        ?>
        
    </body>


</html>