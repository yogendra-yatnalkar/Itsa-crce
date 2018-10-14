<?php
	$servername="localhost";
	$username="root";
	$password="";
	$databasename="itsa_upload";
	
	$conn=mysqli_connect($servername,$username,$password,$databasename);     
?>

<html>
	<head>
		<title>Uplaod Form</title>
	</head>
	<body>
		<form action="form.php" method="POST"  enctype="multipart/form-data" >
			<input type="file" name="file" placeholder="Choose the file here"><br>
			<textarea type="textarea" rows="4" cols="80" name="descp" placeholder="please enter the description"></textarea><br>
			<input type="submit" name="submit" value="Upload">
		</form>

<?php/*
	if(isset($_POST['submit11'])){
		if($_POST['username']=="super"){
			echo "hihihihihhihihihihi";
		}
	*/}?>
	

		<?php
	if(isset($_POST['submit'])){
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
			echo "<br>The file extension is not supported.";
		}
	}
?>

<pre>


</pre>

<!-- ----------------------- For All ---------------------------------- -->

<?php
	$counter=0;
	$sql2="SELECT * FROM `files`;";
	$result=mysqli_query($conn,$sql2);
?>
<table border="1">
<?php
	echo "<tr>";
	echo "<td>No.</td>";
	echo "<td>Name</td>";
	echo "<td>Description</td>";
	echo "<td>Date</td>";
	echo "<td>Size</td>";
	echo "</tdr<br>";
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
	</body>
<html>
