<?php
    include('php/localMethod.php');
    error_reporting(0);
    checkLogin();
    $offices=getTotalOffice();
    echo $offices;
    $deliverdItem=getTotalOrderNumber();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Home-
        </title>
        <meta name="viewport" content="width=device-width,initial-scalse=1.0">
        <link rel="stylesheet" href="css/css.css">

    </head>
    <body background="Images/xx.jpg" style="width:100%; height:100%;">
    </body>
</html>




<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CMS</title>
<link rel="stylesheet" href="css\css.css">
</head>

<body background="Images\xx.jpg" style="background-position: top; background-repeat: no-repeat ; width: 100%; height: 100%; margin: 0px; background-attachment: fixed">
	<div class="Header">
        <font size="40px"  >Courier Management System</font>
	</div>
	<div class="Home">
	<table border="1" style="font-size: 20px; border-collapse: collapse ;border-right: thick; width: 100%" >
		<tr align="center">
			<td width="200px"><a href="php/track_order.php"><font color="white">Track Order</font></a></td>
			<td width="200px"><a href="php/find_nearest_office.php"><font color="white">Find Nearest Office</font></a></td>
			<td width="80px"><a href="office/login.php"><font color="white">Login</font> </a></td>
			<td width="110px"><a href="about.html"><font color="white">About Us</font></a></td>
			<td width="150px"><a href="contactus.html"><font color="white">Contact Us</font></a></td>
		</tr>
	</table>
	</div>
	<div class="left"><h1 style="color: #5F0000"><u>Services</u></h1><br>
		<p style=" text-align:center; color: #FFFFFF;">CBX's aim is to build the operating system for commerce in India. We provide parcel transportation, warehousing, freight, reverse logistics, cross-border and technology services to over 10000 customers including all of India’s largest e-commerce companies and leading enterprises. Our supply chain platform and logistics operations bring flexibility, breadth, efficiency and innovation to our customers’ supply chain and logistics operations. Our operations, infrastructure and technology enable our customers to transact with us and our partners at the lowest costs.</p>
	</div>
	
	
	<div class="team">
<h1 style="font-stretch: expanded ; text-align: center; color: #FB5A5D"><u> OUR TEAM</u></h1>
		<table width="100%">
		<tr style="color: #FFFFFF">
			<td><img src="xyz.jpg" alt="visible when available">
				<h3>Yateesh Chaturvedi</h3>
				<h6>Computer Science, U.I.E.T.</h6>
				I am currently pursuing my degree. I designed the front-end of this site.
				With the help of sources like google and online courses i learnt developing 
				the sites which is creating this. I tried my best and show my best through this site. 
				I hope this will please you.
				</td>
			<td><img src="xyz.jpg" alt="visible when available">
				<h3>Umang Maurya</h3>
				<h6>Computer Science, U.I.E.T.</h6>
				I am currently pursuing my degree. I designed the back-end of this site.
				With the help of sources like google and online courses i learnt creating  
				the database and how to handle it. I tried my best and show my best through this site.
				I hope this will please you.
				
			</td>
			</tr>
		</table>
		
	</div>
	<p style="text-align: center">Follow us:
		<img src="Images\fb.jpg" width="30px" height="30px" alt="facebook"> <img src="Images\tt.png" width="30px" height="30px" alt="twitter "> </p>
	
</body>
</html>