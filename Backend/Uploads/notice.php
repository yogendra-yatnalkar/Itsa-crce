<?php
	$servername="localhost";
	$username="root";
	$password="";
	$databasename="itsa_upload";
	
	$conn=mysqli_connect($servername,$username,$password,$databasename);     
?>

    <form action="notice.php" method="POST"  >
            <textarea type="textarea" rows="4" cols="80" name="type1" placeholder="please enter the notice"></textarea><br>
			<button type="submit" name="submit12" value="Declare" > Declare</button>
		</form> 


<?php        
    if(isset($_POST['submit12'])){
        $notice=$_POST['type1'];
        $sql3="INSERT INTO notices(text,date) VALUES('$notice',CURDATE());";
        mysqli_query($conn,$sql3);
    }
?>

<?php

$sql2="SELECT * FROM `notices` where id in( select max(id) from `notices`);";
$result1=mysqli_query($conn,$sql2);
while($row1=mysqli_fetch_assoc($result1)){
	echo "<br><br><br><b><h2>NOTICE</h2></b>";
	echo "Date : ".$row1['date']."<br>";
    echo $row1['text'];
    echo "<br><br><br>";
}

?>
