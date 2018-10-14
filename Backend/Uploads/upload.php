<?php
	if(isset($_POST['submit'])){
		$file=$_FILES['file'];
		print_r($file);
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
		$allowed=["jpg","jpeg","png","pdf","txt","doc","docx","rtf"];
		if(in_array($f_ext,$allowed)){
			if($f_error===0){
				if($f_size<10000){
					$new_f_name=$f_st_name."--".uniqid('',true).".".$f_ext;
					$f_destn='upload_here/'.$new_f_name;
					move_uploaded_file($f_tmpnm,$f_destn);
					echo $f_name." : "."was successfully uploaded";
				}
				else{
					//echo "<br>File size is too big";
				}
			}
			else{
				//echo "<br>There was an error uploading the file.";
			}
		}
		else{
			//echo "<br>The file extension is not supported.";
		}


	}
?>
