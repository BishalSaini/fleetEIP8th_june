<?php
session_start();
require 'partials/_dbconnect.php'; 

$email = isset($_SESSION['email']) ? $_SESSION['email'] : false;
if($email == false){
  header('Location: login-user.php');
  exit();
}

$errors = array();

if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "Confirm password does not match!";
    } else {
        $code = 0;
        $update_pass = "UPDATE login SET code = $code, password = '$password' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $info = "Your password has been changed. Now you can log in with your new password.";
            $_SESSION['info'] = $info;
            header('Location: sign_in.php');
            exit();
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        html, body {
            background: #fff;
            font-family: 'Poppins', sans-serif;
        }
        ::selection {
            color: #fff;
            background: #fff;
        }
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container .form {
            background: #fff;
            padding: 30px 35px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .container .form .form-control {
            height: 40px;
            font-size: 15px;
        }
        .container .form .forget-pass {
            margin: -15px 0 15px 0;
        }
        .container .form .forget-pass a {
            font-size: 15px;
        }
        .container .form .button {
            background: #4067B5;
            color: #fff;
            font-size: 17px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .container .form .button:hover {
            background: #4067B5;
        }
        .container .form .link {
            padding: 5px 0;
        }
        .container .form .link a {
            color: #6665ee;
        }
        .container .login-form form p {
            font-size: 14px;
        }
        .container .row .alert {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="new-password.php" method="POST" autocomplete="off">
                    <h2 class="text-center">New Password</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Create new password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="change-password" value="Change">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
