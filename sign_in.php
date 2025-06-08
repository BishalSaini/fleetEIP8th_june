<?php
$login = false;
$showError = false;
$showAlert=false;
$showError1=false;
$companyname=false;
$emailerror=false;
$captcha_error=false;
session_start();

if (!isset($_SESSION['captcha_code'])) {
  $_SESSION['captcha_code'] = rand(1000, 9999); // 4-digit random number
}
 
if(isset($_SESSION['verified'])){
  $login = true;
  unset($_SESSION['verified']);
}
if(isset($_SESSION['error'])){
  $showError = true;
  unset($_SESSION['error']);
}
if(isset($_SESSION['wrong_pass'])){
  $showError1 = true;
  unset($_SESSION['wrong_pass']);
}
if(isset($_SESSION['companyexist'])){
  $companyname = true;
  unset($_SESSION['companyexist']);
}
if(isset($_SESSION['emailerror'])){
  $emailerror = true;
  unset($_SESSION['emailerror']);
}
if(isset($_SESSION['captcha_error'])){
  $captcha_error = true;
  unset($_SESSION['captcha_error']);
}

if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_password'])){
  $log_email=$_COOKIE['login_email'];
  $log_pass=$_COOKIE['login_password'];

}

else{
  $log_email="";
  $log_pass="";
}
$checked = isset($_COOKIE['login_email']) ? 'checked' : '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM login WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        if ($password == $row["password"] && $row['status']=== 'verified') {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            
            $companyname = mysqli_real_escape_string($conn, $row['companyname']);
            $_SESSION['companyname'] = $companyname;

            $username = mysqli_real_escape_string($conn, $row['username']);
            $_SESSION['username'] = $username;

            $strtdate = mysqli_real_escape_string($conn, $row['time']);
            $_SESSION['time'] = $strtdate;

            $enter = mysqli_real_escape_string($conn, $row['enterprise']);
            $_SESSION['enterprise'] = $enter;

            if (isset($_POST['remember_me'])){
              setcookie('login_email',$_POST['email'],time()+(60*60*24));
              setcookie('login_password',$_POST['password'],time()+(60*60*24));

            }
            else{
              setcookie('login_email','',time()-(60*60*24));
              setcookie('login_password','',time()-(60*60*24));

            } 

            switch ($row['enterprise']) {
                case 'rental':
                    header("location: rental_dashboard.php");
                    exit;
                case 'OEM':
                    header("location: oem_dashboard.php");
                    exit;
                case 'logistics':
                    header("location: logisticsdashboard.php");
                    exit;
                case 'admin':
                  header("location: news/admin/dashboard.php");
                    exit;
                case 'epc':
                    header("location: epc_dashboard.php");
                    exit;
                default:
                    $showError = true;
            }
        }
        elseif($row['status'] === 'notverified'){
          $_SESSION['email']=$_POST['email'];
          header("Location:user-otp.php");
        }
    
    } 
    else {
        $showError = true;
    }
}


?>                                    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Sign In</title>
</head>

<body>
<div class="error_container">
<?php
    if($login){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText"><b>Success!</b>You Can Now Login
              <br class="clear"/></span>
        </div>
      </label>';
    }
    
    if($showAlert){
       echo '<label>
       <input type="checkbox" class="alertCheckbox" autocomplete="off" />
       <div class="alert notice">
         <span class="alertClose">X</span>
         <span class="alertText">You Can Now Login
             <br class="clear"/></span>
       </div>
     </label>';
    }
    if($showError){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong
              <br class="clear"/></span>
        </div>
      </label>';}
    if($captcha_error){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Captcha Verification Failed
              <br class="clear"/></span>
        </div>
      </label>';}
    if($emailerror){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Something Went Wrong The Verification Email Was Not Sent
              <br class="clear"/></span>
        </div>
      </label>';}
    if($companyname){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Company already exist you might login
              <br class="clear"/></span>
        </div>
      </label>';}

      if($showError1){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Mis Matched Credentials
              <br class="clear"/></span>
        </div>
      </label>';
    }

    
    ?>
  

</div>
    <div class="container" id="container">

<!-- Load the reCAPTCHA JavaScript API -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <!-- </div> -->

    <div class="form-container sign-up">
    <form action="signup.php" method="POST" autocomplete="off" >
    <h1>Create Account</h1>
    <input type="email" name="email_new" placeholder="Email" required>
    <input type="password" name="pass_new" placeholder="Password" required>
    <input type="password" name="conf_pass_new" placeholder="Confirm Password" required>
    <input type="text" name="comp_name_new" placeholder="Company Name" required>
    <select name="companyweb_dd" id="web_present" onchange="webdd_signin()" required>
        <option value="" disabled selected>Company Website?</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
    <input type="text" placeholder="Website Address" name="web_add_new" id="web_add_company">
    <select name="ent_class_new" id="ent_Type_" required>
        <option value="" disabled selected>Enterprise Classified As</option>
        <option value="OEM">OEM</option>
        <option value="rental">Rental</option>
        <option value="logistics">Logistics</option>
        <option value="epc">EPCM</option>
    </select>

    <div class="g-recaptcha" data-sitekey="6Lc4ucIqAAAAADgqJw_6He2SXOde8FQhyoQqIfut"></div>

    

    <button type="submit">Sign Up</button>
</form></div>

        <div class="form-container sign-in">
            <form action="sign_in.php" method="POST" autocomplete="off">
                <h1>Sign In</h1>
                <input type="text" name="email" value="<?php if(isset($log_email)){ echo $log_email;} ?>"  placeholder="Email " required>
                <input type="password" value="<?php if(isset($log_pass)){ echo $log_pass;} ?>" name="password" placeholder="Password" required>
                <div class="remebermecontainer">
                <input type="checkbox" <?php echo $checked; ?> id="remember_me"  name="remember_me">
          <label for="remember_me" class="remember_me1">Remember Me</label> 
          </div> 

                <a href="forgot-password.php">Forgot Password?</a>

                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Create an account to enjoy full access to the site’s features.</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="signin.js"></script>
    <script src="main.js"></script>
    <script>
    
    // function validateCaptcha() {
    //     var response = grecaptcha.getResponse();
    //     if (response.length == 0) {
    //         alert("Please complete the CAPTCHA.");
    //         return false;  
    //     }
    //     return true;  
    // }
</script>
</body>

</html>