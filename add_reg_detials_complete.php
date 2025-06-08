<?php
if(isset($_POST['registration_details_complete'])){
    include "partials/_dbconnect.php";
    $iso_dd=$_POST['iso_dd'];
    $iso_type=$_POST['iso_type'];
    $msme=$_POST['msme'];
    $msme_number=$_POST['msme_number'];
    // $msme_certificate=$_POST['msme_certificate'];
    $gst_new=$_POST['gst_new'];
    // $upl_gst=$_POST['upl_gst'];
    $pancard_new=$_POST['pancard_new'];
    // $pan_upl=$_POST['pan_upl'];
    $coi_avail=$_POST['coi_avail'];
    $coi_number=$_POST['coi_number'];

    $gst_cert = $_FILES['upl_gst']['name'];
    $temp_file_path = $_FILES['upl_gst']['tmp_name'];
    $folder1 = 'img/' . $gst_cert;
    move_uploaded_file($temp_file_path, $folder1);

    $pan = $_FILES['pan_upl']['name'];
    $temp_file_1 = $_FILES['pan_upl']['tmp_name'];
    $folder12 = 'img/' . $pan;
    move_uploaded_file($temp_file_1, $folder12);

    $msme_certificate = $_FILES['msme_certificate']['name'];
    $temp_file_2 = $_FILES['msme_certificate']['tmp_name'];
    $folder13 = 'img/' . $msme_certificate;
    move_uploaded_file($temp_file_2, $folder13);





    $companyname_registration=$_POST['companyname_registration'];
    $sql="INSERT INTO `registration_details` (`iso_registered`, `iso_type`, `msme`, `msme_number`, `msme_certificate`, `gst_new`, `upl_gst`, `pancard_new`, `pan_upl`, `coi_avail`, `coi_number`, `company_name`)
     VALUES ('$iso_dd', '$iso_type', '$msme', '$msme_number', '$msme_certificate', '$gst_new', '$gst_cert', '$pancard_new', '$pan', '$coi_avail', '$coi_number', '$companyname_registration')";
     $result=mysqli_query($conn,$sql);
     if($result){
      session_start();
      $_SESSION['basic_detail_success']="success";

        header("Location:complete_profile_new.php");
     }
     else{
      $_SESSION['basic_detail_error']="error";
      header("Location:complete_profile_new.php");

  }

}

?>