<?php 

if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
	include_once 'partials/_dbconnect.php'; // Include the database connection file

	echo "<pre>";
	print_r($_FILES['my_image']);
	echo "</pre>";
	$type01 = $_POST['sell_type'];
	$make01 = $_POST['make'];
	$model01 = $_POST['model'];
	$capacity01 = $_POST['capacity'];
	$yom01 = $_POST['yom'];
	$location01 = $_POST['location'];
	$boomlength01 = $_POST['boom_length'];
	$jiblength01 = $_POST['jib_length'];
	$luffinglength01 = $_POST['luffing_length'];
	$cranedesc01 = $_POST['crane_desc'];
	$img_name = $_FILES['my_image']['name'];
	$img_size = $_FILES['my_image']['size'];
	$tmp_name = $_FILES['my_image']['tmp_name'];
	$error = $_FILES['my_image']['error'];


	echo "<pre>";
	print_r($_FILES['my_image2']);
	echo "</pre>";
	$img_name2 = $_FILES['my_image2']['name'];
	$img_size2 = $_FILES['my_image2']['size'];
	$tmp_name2 = $_FILES['my_image2']['tmp_name'];
	$error2 = $_FILES['my_image']['error'];


	echo "<pre>";
	print_r($_FILES['my_image3']);
	echo "</pre>";
	$img_name3 = $_FILES['my_image3']['name'];
	$img_size3 = $_FILES['my_image3']['size'];
	$tmp_name3 = $_FILES['my_image3']['tmp_name'];
	$error3 = $_FILES['my_image3']['error'];

	if ($error === 0) {
		if ($img_size > 1250000 or $img_size2 > 1250000 or $img_size3 > 1250000 ) {
			// $em = "Sorry, your file is too large.";
		    // header("Location: index.php?error=$em");
			echo "File Size Is Too large";
		}else {
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
			$img_ex_lc2 = strtolower($img_ex2);

			$img_ex3 = pathinfo($img_name3, PATHINFO_EXTENSION);
			$img_ex_lc3 = strtolower($img_ex3);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'img/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				$new_img_name2 = uniqid("IMG-", true).'.'.$img_ex_lc2;
				$img_upload_path2 = 'img/'.$new_img_name2;
				move_uploaded_file($tmp_name2, $img_upload_path2);

				$new_img_name3 = uniqid("IMG-", true).'.'.$img_ex_lc3;
				$img_upload_path3 = 'img/'.$new_img_name3;
				move_uploaded_file($tmp_name3, $img_upload_path3);

				// Insert into Database
				$sql = "INSERT INTO images(type,front_pic,left_side_pic,right_side_pic,names,make,capacity,yom,location,boomlength,jiblength,luffinglength,description) 
				        VALUES('$type01' , '$new_img_name' , '$new_img_name2' , '$new_img_name3' , '$make01' , '$model01' , '$capacity01' , '$yom01' , '$location01' , '$boomlength01' , '$jiblength01' , '$luffinglength01' , '$cranedesc01')";
				$result01=mysqli_query($conn, $sql);
				if ($result01){
					$showAlert = true;
					if($showAlert){
						echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
							 <strong>Success!</strong>" You Account Is Created And Now You Can Login."
							 </div>';
					 }
					header("Location: tets.php");

					
				}
			
			else{
				$showError = true;
				header("Location: tets.php");

			}
				
			}
}}}