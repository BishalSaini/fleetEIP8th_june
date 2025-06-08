<?php 
if(isset($_POST['bank_complete'])){
    include "partials/_dbconnect.php";
    $bankname=$_POST['bankname'];
    $acc_num=$_POST['acc_num'];
    $ifsc=$_POST['ifsc'];
    $branch=$_POST['branch'];
    $acc_type=$_POST['acc_type'];
    $nameoncheque=$_POST['nameoncheque'];
    $bank_comp_name=$_POST['bank_comp_name'];
    $sql="INSERT INTO `complete_profile` (`name_on_cheque`,`bank_name`, `account_num`, `branch`, `ifsc_code`, `account_type`, `companyname`)
     VALUES ('$nameoncheque','$bankname', '$acc_num', '$branch', '$ifsc', '$acc_type', '$bank_comp_name')";
     $result=mysqli_query($conn,$sql);
     if($result){
      session_Start();
      $_SESSION['basic_detail_success']="success";
        header("Location:complete_profile_new.php");
     }
     else{
      $_SESSION['basic_detail_error']="error";
      header("Location:complete_profile_new.php");

  }

}

?>