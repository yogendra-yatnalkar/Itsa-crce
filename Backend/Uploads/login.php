<?php
	session_start();
	if(isset($_SESSION['usertype'])) {
        //echo  "Hello " . $_SESSION['usertype']. " User";
        session_unset();
        session_destroy();
        session_start();
    }
?>

<?php

	$servername="localhost";
	$username="root";
	$password="";
	$databasename="itsa_upload";
	
    $conn=mysqli_connect($servername,$username,$password,$databasename);   
?>

<html>
	<head>
		<title>Login Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="http://maps.google.com/maps/api/js?" 
        type="text/javascript"></script>
        <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
        <link rel="icon" href="favicon.png" type="image/x-icon">
	</head>

<body bgcolor="#131339">
<pre>


</pre>
<div class="w3-container">
<center>
    <h2 class="w3-content w3-containter" style="max-width:600px; color:white"><b>Members Only Login</b></h2>
        <div class="w3-card-4 w3-white" style="max-width:600px; max-height:600px; border-radius:11px">
            <img src="favicon.png" width="200px" height="200px">
            <form action="login.php" method="POST">
                <div class="container" style="padding-top:15px; padding-bottom:15px">
                   <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="uname" required>
                    <br/><br/>
                    <label for="uname"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="passwd" required>
                    <br/><br/>
                    <button class="w3-button w3-round-xlarge w3-green"  type="submit" name="submit">Login</button>
                    <button class="w3-button w3-round-xlarge w3-red"  type="reset">Clear</button>
                    
                </div>
            </form>
        </div>

</center>
</div>

<?php 
    if(isset($_POST['submit'])){
        $uname = mysqli_real_escape_string($conn,$_POST['uname']);
        $passwd = mysqli_real_escape_string($conn,$_POST['passwd']);
        //echo "<br>".$uname."<br>"."PWD   ".$passwd."<br>";

        if(empty($uname)||empty($passwd)){
            echo "<br><script>alert('Username or Password feild was incomplete');document.write('hi');</script><br>";
            exit();
        }
        else{
            $sql = "SELECT * FROM users WHERE uname like '$uname';";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_assoc($result);
            if( $row >=1 ){
                $db_uname=$row['uname'];
                $hash=$row['passwd'];
                $hash = substr( $hash, 0, 60 );
                //echo "<br>".$db_uname."<br>"."DB hash   ".$hash."<br>";
                $pcheck=password_verify($passwd,$hash);
                if($pcheck==1){
                    if($db_uname=='super_user'){
                        $_SESSION['usertype']='Super';
                        header("Location:admin.php");
                    }
                    else{
                        $_SESSION['usertype']='Normal';
                        header("Location:forall.php");
                    }
                }
                else{
                    echo "<script>alert('Incorrect Password');</script>"; 
                    exit();
                }
            }
            else{
                echo "<script>alert('Incorrect Username');</script>";       
                exit();
            } 
        }
    }
?>

</body>
</html>
