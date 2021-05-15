<?php
    echo "<a href='../' >Home</a><br> ";
    echo "<h2 align =center>  Setup Page  </h2>";
    $create=createDatabase();
    exit(0);

    function createDatabase(){
        $con=new mysqli($_SERVER['HTTP_HOST'],'root','');
        echo 'Checking database............';
        $dbcheck= mysqli_select_db($con,"cms");
        isfoundOrNot($dbcheck);
        if($dbcheck)  createTable(0);
        else{
            echo 'database not found<br>Creating database<br>';
            $created=mysqli_query($con,"CREATE DATABASE cms");
            isfoundOrNot($created);
            if($created){
                createTable(1);
            }
            else echo('Failed</br>');
        }
    }

    function createTable($isNew){
        $deftable=$offtable=$ordtable=$orstable=$pintable=$emptable=$pathable=false;
        include('connection.php');
        if(!$isNew){
            echo'checking default table.......';
            $deftable= mysqli_query($conn, "DESCRIBE general" );
            isfoundOrNot($deftable);
            echo'checking office table.........';
            $offtable=mysqli_query($conn, "DESCRIBE office" );
            isfoundOrNot($offtable);
            echo ('checking order table..........');
            $ordtable=mysqli_query($conn, "DESCRIBE order_table" );
            isfoundOrNot($ordtable);
            echo 'checking order-status table';
            $orstable=mysqli_query($conn, "DESCRIBE order_status" );
            isfoundOrNot($orstable);
            echo 'checking pincode table......';
            $pintable=mysqli_query($conn, "DESCRIBE pincode" );
            isfoundOrNot($pintable);
            echo 'checking employee table...';
            $emptable=mysqli_query($conn, "DESCRIBE employee_table" );
            isfoundOrNot($emptable);
            echo 'checking path table...........';
            $pathable=mysqli_query($conn, "DESCRIBE path_table" );
            isfoundOrNot($pathable);

        }
        echo '<br>';
        //creating table
        if(!$deftable){
            echo 'creating general table.........';
            $sql = "CREATE TABLE general(weightperkm float,otime time,ctime time)";
            $result=$conn->query($sql);
            isfoundOrNot($result);
            $ctime="17:00";
            $otime="10:00";
            $wet=1;
            $sql = "INSERT into general(weightperkm ,otime ,ctime ) value('$wet','$otime','$ctime')";
            $conn->query($sql);
        }
        if(!$offtable){
            echo 'creating office table.........';
            $sql = "CREATE TABLE office(officeId INT(10) UNSIGNED AUTO_INCREMENT not null PRIMARY KEY,
            states char(30) ,district char(30) ,addrs char(40),typ int(1), headoffice int(10),
            pincode int(6) ,addedTime TIMESTAMP,openingtime time,closingtime time,contact char(30))";
            isfoundOrNot($conn->query($sql));
        }
        if(!$ordtable){
            echo 'creating order table.........';
            $sql = "CREATE TABLE order_table(id int(15) UNSIGNED AUTO_INCREMENT not null PRIMARY KEY,itemweight float(9,4),price float(9,2),initialOffice int(10),
            receivingTime DATETIME,deliveringTime DATETIME,destinationOffice int(10),currentOffice int(10),mobown int(10),
            progressStatus int(1), isreturn int(1),ownerName char(30),ownerPincode int(6),ownerAddress char(30),mobrec int(10),
            receiverName char(30),receiverPinCode int(6),orderTakenBy char(15),deliverdBy char(15),distance float(9,3),receiverAddress char(30))";
            isfoundOrNot($conn->query($sql));
        }
        if(!$orstable){
            echo 'creating order_status table.........';
            $sql = "CREATE TABLE order_status(orderId int(15),updateTime TIMESTAMP ,progressStatus int(1),office char(40))";
            isfoundOrNot($conn->query($sql));
        }
        if(!$pintable){
            echo 'creating pincode table.........';
            $sql = "CREATE TABLE pincode(id INT(10)UNSIGNED AUTO_INCREMENT not null PRIMARY KEY, offceI INT(10),officeF INT(10),pinI INT(6),pinF INT(2),distance float(9,3),
            headofficeI INT(10),headOfficeF INT(10))";
            isfoundOrNot($conn->query($sql));
        }
        if(!$emptable){
            echo 'creating employee table.........';
            $sql = "CREATE TABLE employee_table(id int(15) UNSIGNED AUTO_INCREMENT not null PRIMARY KEY,emailid varchar(25) unique key,empName char(30),employeetype int(1),
            officeId int(10),addedDate DATETIME,addedBy int(15),mobileno int(10),addrs char(30),passwords varchar(32))";
            isfoundOrNot($conn->query($sql));
            
        }
        if(!$pathable){
            echo 'creating paths table.........';
            $sql = "CREATE TABLE path_table(orderId int(15) unsigned auto_increment unique key,pathLength int(2) ,path1 int(10),path2 int(10),path3 int(10),path4 int(10),
            path5 int(10),path6 int(10),path7 int(10),path8 int(10),path9 int(10),path10 int(10),
            path11 int(10),path12 int(10),path13 int(10),path14 int(10),path15 int(10),path16 int(10),
            path17 int(10),path18 int(10),path19 int(10),path20 int(10))";
            isfoundOrNot($conn->query($sql));
        }
        $query22= "SELECT * FROM employee_table where employeetype='1'";
        $data=mysqli_query($conn,$query22);
        $totalFound=mysqli_num_rows($data);
        if($totalFound>0){
            echo 'admin found : '.$totalFound.'<br>';
            $num=$totalFound;
            while($result = mysqli_fetch_assoc($data)){
                echo "<tr>
                             <td>....".$result['id']."</td>
                            <td>....".$result['empName']."</td>
                            <td>.".$result['emailid']."</td>
                            <td>....".$result['passwords']."</td>
                      </tr><br>";//this will send data to next page
            }

        }else{
            echo 'Admin not found <br> before starting create admin<br>';
            echo '<h1 align="center"> id =1 <br>password 12345 <br> name admin<br>email :admin@gmail.com</h1><br>';
            echo 'Creating...';
            $password=md5('12345');
            $query2="INSERT INTO employee_table (emailid ,empName ,employeetype, officeId
            ,addedDate ,addedBy ,mobileno ,addrs ,passwords)
            VALUES ('admin@gmail.com','admin','1','0',CURRENT_TIMESTAMP(),'0','0','4','$password')";
            isfoundOrNot($conn->query($query2));

        }
    }

    function isfoundOrNot($value){
        if($value) echo '<img src="ok.png" width="16"><br> ';
        else echo '<img src="error.png" width="16"><br> ';
    }
?>





<!--
    this is structure of database and table
    cms{
        default         {
            weight
            distance}
        office          {
            id
            state
            dist
            pin
            addedtime
            openingtime
            closingtime
            contact number
            address
            type
            headoffice}
        order           {
            s.no
            id
            weight
            price
            initial office
            end office
            current office
            status
            isreturn
            owner name
            ownerpincode
            owner address
            receiver name
            receiveraddress
            receiverpincode
            received by 
            deliverd by}
        order-status    {
            s.no
            id
            time
            status
            office}
        pincode         {
            office1
            office2
            pin1
            pin2
            distance
            price
            head1
            head2}
        employee        {
            id
            type        //delivery,employee,admin,manager,
            name
            officeid
            added date
            email
            added by
            mobile number
            password
            status..................... 
            address}
        path            {
            s.no
            id 
            path1--
            path20-}
    

    }
-->