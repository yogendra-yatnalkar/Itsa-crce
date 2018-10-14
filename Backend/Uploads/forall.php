<?php
	session_start();
	if(isset($_SESSION['usertype'])) {
		$hello = "Hello " . $_SESSION['usertype']. " User";
	}

	$servername="localhost";
	$username="root";
	$password="";
	$databasename="itsa_upload";
	
	$conn=mysqli_connect($servername,$username,$password,$databasename);     

	if( $_SESSION['usertype']=="Normal"){
?>

<html>
	<head>
		<title>Normal User</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="http://maps.google.com/maps/api/js?" 
        type="text/javascript"></script>
        <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
        <link rel="icon" href="favicon.png" type="image/x-icon">
	</head>

	<body >

	<div class="w3-bar w3-black">
			<button class="w3-bar-item w3-button" name="logout" style="position:fixed;" onclick="redirect()">Logout</button>
			<div class="w3-right">
				<div class="w3-bar-item"><?php echo $hello; ?></div>
			</div>
	</div>

	<script>
		function redirect(){
			window.location.replace("login.php");
		}
	</script>

<!-- ----------------------- For All ---------------------------------- -->
<style>
	.down{
		font-size:200%;
		max-width:60%;
	}
</style>
<center>
        <div class="down">
            <div style="max-width:60%; padding-bottom:0%; padding-top:2%;">
            <div class=" w3-center w3-round-xxlarge w3-border-black w3-leftbar w3-rightbar w3-border w3-text-black w3-hover-text-red">
                <b><span class=" w3-round-xxlarge" style="padding-right:1%;padding-left:1%;padding-top:1%;">Download
                </span></b>    
            </div></div></div>
        </center>


<?php
	$counter=1;
	$sql2="SELECT * FROM `files`;";
	$result=mysqli_query($conn,$sql2);
?>
<center>
<table border="1" style="border-radius:10px">
<?php
	echo "<tr style='border-radius:10px'class='w3-text-red w3-sand'><b>";
	echo "<td>No.</td>";
	echo "<td>Name</td>";
	echo "<td>Description</td>";
	echo "<td>Date</td>";
	echo "<td>Size</td>";
	echo "</b></tr><br/>";
	while($row=mysqli_fetch_assoc($result)){
		//print_r($row);echo "<br>";
		echo "<tr>";
		echo "<td>"; echo $counter++; echo "</td>";
		echo "<td>";?><a href="<?php echo $row['path'];?>"><?php echo $row['name'];?></a><?php echo "</td>";
		echo "<td>"; echo $row['description']; echo "</td>";
		echo "<td>"; echo $row['Date']; echo "</td>";
		echo "<td>"; echo $row['size']/100;echo "kb"; echo "</td>";
	}
?>
</table>
</center>

<!-- ------------------------ For all ----------------------------------------------------------- -->

<style>
	.notice_dis{
		font-size:200%;
		max-width:60%;
		padding-top: 1%;
		padding-bottom: 1%;
	}
</style>
<center>
        <div class="notice_dis">
            <div style="max-width:60%; padding-bottom:0%; padding-top:2%;">
            <div class=" w3-center w3-round-xxlarge w3-border-black w3-leftbar w3-rightbar w3-border w3-text-black w3-hover-text-red">
                <b><span class=" w3-round-xxlarge" style="padding-right:1%;padding-left:1%;padding-top:1%;">Notice
                </span></b>    
            </div></div>
		</div>
</center>

<center>
<div style="max-width:60%;">
<div class="w3-container" class="notice_dis">
	<div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
		<?php
			$sql22="SELECT * FROM `notices` where id in( select max(id) from `notices`);";
			$result1=mysqli_query($conn,$sql22);
			while($row1=mysqli_fetch_assoc($result1)){
				echo "<br><b>Date   ".$row1['date'].":</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo $row1['text'];
				echo "<br/><br/>";
			}
		?>
	</div>
</div>
</div>
</center>
<br>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

</div>
	</body>
<html>

<?php
	}
	else{
		header("Location:login.php");
	}
?>