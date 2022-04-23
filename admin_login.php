<?php
require_once ("DbConn.php");
session_start();
?>
<html>
<head>
	<meta charset="UTT-8"/>
  	<meta name="viewpoint" content="width=device-width, initial-scale=1.0"/>
  	<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@1,400;1,700&display=swap" rel="stylesheet">
<style>

body{
	margin: 0;
	padding: 0;
	background-color: #444444;
}
body:before{
	content: '';
	font-family: 'PT Serif', serif;
	position: fixed;
	width: 100vw;
	height: 100vh;
}
.contact_form{
	position: absolute;
	top: 50%;
	left: 70%;
	-webkit-transform:translate(-50%,-50%);
	-moz-transform:translate(-50%,-50%);
	-ms-transform:translate(-50%,-50%);
	-o-transform:translate(-50%,-50%);
	transform: translate(-50%,-50%);
	width: 30%;
	height: 50%;
	padding: 80px 40px;
	background-color: #333333;
	border-color: red;
	border-width: 50px;
	border-radius: 250px;
	box-shadow: 0 0 80px #EE5E3F;
}
.avatar{
	position: absolute;
	width: 120px;
	height: 120px;
	border-radius: 50%;
	overflow: hidden;
	top: calc(-80px / 2);
	left: calc(50% - 65px);
}
.contact_form h2{
	font-family: 'PT Serif', serif;
	margin: 0;
	padding: 0;
	color: #EE5E3F;
	text-align: center;
	text-transform: uppercase;
}
.contact_form p{
	margin: 0;
	padding: 0;
	font-weight: bold;
	color: #EE5E3F;
	font-size: 19;
}
.contact_form input{
	width: 100%;
	margin-bottom: 20px;
}
.contact_form input[type=text]{
	border: none;
	border-bottom: 1px solid #EE5E3F;
	background:transparent;
	outline: none;
	height: 35px;
	color: #EE5E3F;
	font-size: 15px;
}
.contact_form input[type=password]{
	border: none;
	border-bottom: 1px solid #EE5E3F;
	background:transparent;
	outline: none;
	height: 35px;
	color: #EE5E3F;
	font-size: 15px;
}
.contact_form input[type=submit]{
	height: 35px;
	color: #333333;
	font-size: 17px;
	background:#EE5E3F;
	cursor:pointer;
	border-radius: 25px;
	border:none;
	outline: none;
	margin-top: 15%;
	width: 100%;
}
.contact_form a{
	color: #EE5E3F;
	font-size: 14px;
	font-weight: bold;
	text-decoration: none;
}
input[type=checkbox]{
	width: 20%;
}
.account{
	font-size: 100px;
	font-weight: bold;
	position:relative;
	margin-bottom: 15px;
	color: white;
	padding: 25px;
}
.form_input{
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
}
.form{
	width: 80%;
	padding-left: 45px;
	padding-top: 20px;
}
.icon{
	position: absolute;
	right: 15px;
	top: -10px;
	font-size: 25px;
	color: #EE5E3F;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;

}
#hide1{
	display: none;
}

.page-content{
	margin: 100px;
	color: #EE5E3F;
}

.head{
	font-size: 50px;
}
.cont{
	font-size: 30px;
}

</style>
</head>
<body>

<div class="page-content">
	<h3 class="head">Solve a problem</h3>
	<p class="cont">Easier understanding of students grievances<br>Rights to speak<br>Quicker solve of those grievances</p>
</div>
<div class="contact_form">
<form method="post" class="form">
	<p>user name:</p>
  	<input type="text" id="Username" placeholder="Enter username" name="Username"><br><br>
  	<p>password:</p>
  	<div class="form_input">
  		<input type="password" id="Password" name="Password" placeholder="Enter password" autocomplete="off" >
  		<span class="icon" onclick="myFunction()">
  			<i id="hide1" class="fa fa-eye"></i>
  			<i id="hide2" class="fa fa-eye-slash"></i>
  		</span>
  	</div>
  	<input type="submit" value="Sign in">
</form>
</div>
<script>
	function validateForm() {
  		var x = document.forms["myForm"]["Username"].value;
  		if (x == "") {
    	alert("Username must be filled out");
    	return false;
  		}
  		var x = document.forms["myForm"]["Password"].value;
  		if (x == "") {
    	alert("Password must be filled out");
    	return false;
  		}
	}
</script>
<script >
	function myFunction(){
		var p = document.getElementById("Password");
		var q = document.getElementById("hide1");
		var r = document.getElementById("hide2");

		if(p.type === 'password'){
			p.type = "text";
			q.style.display = "block";
			r.style.display = "none";
		}
		else{
			p.type = "password";
			q.style.display = "none";
			r.style.display = "block";
		}
	}
</script>
<?php
if($_POST){
	$Username=$_POST["Username"];
	$Password=$_POST["Password"];
	if($Username=="Smartcollege@gmail.com" and $Password=="Smartcollege@123"){
		echo "<script>window.location.href='admin_pg.php';</script>";
	}
	else{
		echo "<script>alert('Incorrect username and password...');</script>";
	}
}
?>
</body>
</html>
