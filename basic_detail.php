<?php 

if(isset($_POST['submit_basic_Detail_form'])){
    include "partials/_dbconnect.php";
    $companyname=$_POST['basicdetail_companyname'];
    $enterprise_type=$_POST['enterprise_type_basicdetail'];
    $comp_add=$_POST['companyaddress_basicdetail'];
    $comp_state=$_POST['state_basic_detial'];
    $pincode=$_POST['pincode_basicdetial'];
    $cont_new=$_POST['cont_new'];
    $add_service_new = !empty($_POST['add_service_new']) ? $_POST['add_service_new'] : null;
    $rmc_type = !empty($_POST['rmc_type_new']) ? $_POST['rmc_type_new'] : null;
    $rmc_loca_new = !empty($_POST['rmc_loca_new']) ? $_POST['rmc_loca_new'] : null;
    $rmc_pin_new = !empty($_POST['rmc_pin_new']) ? $_POST['rmc_pin_new'] : null;
    $website=$_POST['website'] ?? '';

    $comp_logo = $_FILES['company_logo_basic_Detial']['name'];
    $temp_file_path = $_FILES['company_logo_basic_Detial']['tmp_name'];
    $folder1 = 'img/' . $comp_logo;
    move_uploaded_file($temp_file_path, $folder1);



    
    $sql="INSERT INTO `basic_details` (`enterprise_type`,`companylogo`, `companyname`, `company_address`, `state`,
     `pincode`, `office_number`,
     `add_on_services`, `rmc_type`, `rmc_location`, `rmc_pincode`, `website`) VALUES ('$enterprise_type','$comp_logo', '$companyname', '$comp_add', '$comp_state', '$pincode', '$cont_new', '$add_service_new',
      '$rmc_type', '$rmc_loca_new', '$rmc_pin_new','$website')";
      $result=mysqli_query($conn,$sql);
      if($result){
        session_start();
        $_SESSION['basic_detail_success']="basic details have been added successfully";
        header("Location:complete_profile_new.php");
        exit;
      }
      else{
        echo "There was some error";
      }
}

?>