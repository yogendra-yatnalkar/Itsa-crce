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

	if( $_SESSION['usertype']=="Super"){
?>

<html>
	<head>
		<title>Super User</title>
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

<div class="w3-container w3-content" style="max-width:50% ">
<style>
	.title1{
		font-size:200%;
		max-width:60%;
	}
	.fill_file{
		padding-top:3%;
		padding-bottom:1%;
		padding-left:15%;
	}
	.up_button{
		padding-top:1%;
	}
</style>

<center>
        <div class="title1">
            <div style="max-width:60%; padding-bottom:2%; padding-top:2%;">
            <div class=" w3-center w3-round-xxlarge w3-border-black w3-leftbar w3-rightbar w3-border w3-text-black w3-hover-text-red">
                <b><span class=" w3-round-xxlarge" style="padding-right:1%;padding-left:1%;padding-top:1%;">File Upload
                </span></b>    
            </div></div></div>
        </center>


	<center>
		<form action="admin.php" method="POST"  enctype="multipart/form-data" >
			<input type="file" name="file" class="fill_file" >
			<textarea type="textarea" rows="4" cols="80" name="descp" placeholder="please enter the description" style="border-radius:10px" class="w3-pale-green"></textarea>
			<div class="up_button"><input type="submit" name="submit66" class="w3-button w3-round-large w3-black " value="Upload"></div>
		</form>
	</center>
	
		<?php
		echo "<center>";
	if(isset($_POST['submit66'])){
		$file=$_FILES['file'];
		//print_r($file);
		$f_name=$file['name'];
		//echo "<br>".$f_name;

		$f_type=$file['type'];
		//echo "<br>".$f_type;

		$f_tmpnm=$file['tmp_name'];
		//echo "<br>".$f_tmpnm;

		$f_error=$file['error'];
		//echo "<br>".$f_name;

		$f_size=$file['size'];
		//echo "<br>".$f_size;

		$f_narr=explode('.',$f_name);
		$f_ext=strtolower(end($f_narr));
		$f_st_name=reset($f_narr);
		//echo "<br>".$f_ext;
		$allowed=["jpg","jpeg","png","pdf","txt","doc","docx","rtf","zip"];
		if(in_array($f_ext,$allowed)){
			if($f_error===0){
				if($f_size<10000){
					$new_f_name=$f_st_name."--".uniqid('',true).".".$f_ext;
					$f_destn='upload_here/'.$new_f_name;
					move_uploaded_file($f_tmpnm,$f_destn);
					echo $f_name." : "."was successfully uploaded";

					$name=mysqli_real_escape_string($conn,$f_name);
					$size=mysqli_real_escape_string($conn,$f_size);
					$description=mysqli_real_escape_string($conn,$_POST['descp']);

					$sql="insert into files(name,description,size,date,path) values('$name','$description',$size,CURDATE(),'$f_destn');";
					mysqli_query($conn,$sql);

				}
				else{
					echo "<br>File size is too big";
				}
			}
			else{
				echo "<br>There was an error uploading the file.";
			}
		}
		else{
			echo "The file extension is not supported.";
		}
	}
	echo "</center>";
?>


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

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style>
	.notice{
		font-size:200%;
		max-width:60%;
		padding-top: 3%;
		padding-bottom: 4%;
	}
	.decl{
		padding-top:1%;
	}
</style>
<center>
        <div class="notice">
            <div style="max-width:60%; padding-bottom:0%; padding-top:2%;">
            <div class=" w3-center w3-round-xxlarge w3-border-black w3-leftbar w3-rightbar w3-border w3-text-black w3-hover-text-red">
                <b><span class=" w3-round-xxlarge" style="padding-right:1%;padding-left:1%;padding-top:1%;">New Notice
                </span></b>    
            </div></div></div>
        </center>

<center>
    <form action="admin.php" method="POST"  >
            <textarea type="textarea" rows="4" cols="80" name="type1" placeholder="Please enter the notice" style="border-radius:10px;" class="w3-pale-green"></textarea>
			<div class="decl"><button type="submit" name="submit12" value="Declare" class="w3-button w3-round-large w3-black"> Declare</button></div>
		</form> 
</center>

<?php        
    if(isset($_POST['submit12'])){
        $notice=mysqli_real_escape_string($conn,$_POST['type1']);
        $sql3="INSERT INTO notices(text,date) VALUES('$notice',CURDATE());";
        mysqli_query($conn,$sql3);
    }
?>

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

<div class="w3-container" >
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