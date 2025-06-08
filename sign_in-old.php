<?php
$login = false;
$showError = false;
session_start();
 
if(isset($_SESSION['verified'])){
  $login = true;
  unset($_SESSION['verified']);
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


            // Redirect based on enterprise type
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
                    $showError = "Invalid Credentials";
            }
        }
        elseif($row['status'] === 'notverified'){
          $_SESSION['email']=$_POST['email'];
          header("Location:user-otp.php");
        }
    
    } 

    
    else {
        $showError = "Invalid Credentials";
    }
}
?>
<style>
<?php include "style.css" ?>
</style>

<style>
  <?php include "main.js" ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
  <link rel="stylesheet" href="footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="main.js"></script>
    <title>SignIn</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet"> 

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
/>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
rel="stylesheet"
integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
crossorigin="anonymous"
/>

<!-- <link rel="stylesheet" href="assets/css/style.css"> -->

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet">
</head> 
<body>     
  <section class="page_404">
            <div class="container404">
                <div class="row">    
                    <div class="col-sm-12">
                        <div class="col-sm-10 col-sm-offset-1 text-center">
                            <div class="four_zero_four_bg">
                                <h1 class="text-center">Fleet EIP</h1>
                            </div>
                            
                            <div class="contant_box_404">
                                <h3 class="h2">
                                Kindly View It On Laptop Or Desktop 
                                                              </h3>
                                
                                <!-- <p> </p> -->
                                
                               <!--  <p class="text-muted">For the best experience, we recommend viewing our website on a computer or laptop.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<section class="mainbody1"> 
<div class="navbar1" id="main_nav">
<div class="nav__data">
  <div class="nav_logo"></div>
</div>
      <div class="iconcontainer">
        <ul>
          <li><a href="sign_in.php">Home</a></li>
        <li><a class="naviconnew" onclick="scroll_to_service()" >Services</a></li>
            <!-- <li><a class="naviconnew" onclick="scroll_to_aboutus()">About Us</a></li> -->
            <li><a class="naviconnew" onclick="scroll_to_contactus()">Contact Us</a></li>
            <li><a class="naviconnew" onclick="window.location.href='jobs_corner.php'">Jobs Corner</a></li>
            <li><a href="sign_up.php">SignUp</a></li></ul>
        </div>
    </div>
    <br><br>
    <?php
    if($login){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText"><b>Success!</b>You Can Now LogIN
              <br class="clear"/></span>
        </div>
      </label>';
    }
    if($showError){
        echo '<label class="errornotification">
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Mis Matched Credentials
              <br class="clear"/></span>
        </div>
      </label>';
    }
  
    ?>
    <br>
    <div class="header_container">
      <div class="font_header_cont">
        <div class="tag_container">
        <div class="tagline">Empowering Business, Elevating Success Your Premier Crane Rental Ecosystem</div></div>
      <div class="gif_contaier"><marquee class="gifmarquee" behavior="smooth" direction="left">
      <img src="gif1.gif" alt=""><img class="flipimage" src="gif2.gif" alt=""><img src="gif4.gif" alt=""><img class="flipimage" src="truck7.gif" alt="">


      </marquee>
    <!-- <div class="staticgif_container"><img src="static2.gif" alt=""><img src="staticgif1.gif" alt=""></div> -->
    </div>
      </div>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Login</span></div>
        <form action="sign_in.php" class="login_form" method="POST" autocomplete="off">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="email" value="<?php if(isset($log_email)){ echo $log_email;} ?>"  placeholder="Email " required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" value="<?php if(isset($log_pass)){ echo $log_pass;} ?>" name="password" placeholder="Password" required>
          </div>
          <input type="checkbox" <?php echo $checked; ?> id="remember_me"  name="remember_me">
          <label for="remember_me" class="remember_me1">Remember Me</label>  

          <div class="forgot-password">
              <a href="forgot-password.php">Forgot Password?</a>
          </div>


          <div class="row button">
            <input type="submit" value="Log In">
          </div>
          <div class="signup-link">Not a member? <a href="sign_up.php">Signup now</a></div>
        </form>
      </div>
    </div>
</div>
<section id="service_section_content">
        <div class="service-container" >
          <h3 class="service-title">Services</h3>
          <div class="row">
            <div class="col-md-4">
              <div class="main">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/jcb.png" alt="" />
                  </div>
                  <h4>Market Lead</h4>
                  <p>
                    Our crane rental ecosystem features a robust market lead function, allowing potential clients to easily submit inquiries for crane rentals through our portal. With a user-friendly submission form capturing essential project details and contact information, we ensure seamless communication and prompt responses
                  </p>
                </div>
              </div>
            </div>
  
            <div class="col-md-4">
              <div class="main">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/service7.png" alt="" />
                  </div>
                  <h4>Market Place</h4>
                  <p>
                    Our marketplace simplifies the process of buying and selling crane equipment. Users can easily list their cranes for sale by uploading photos and details, attracting potential buyers seeking reliable, pre-owned equipment. Simultaneously, buyers can browse a curated selection of used cranes available on our platform.
                  </p>
                </div>
              </div>
            </div>
  
            <div class="col-md-4">
              <div class="main">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/service6.png" alt="" />
                  </div>
                  <h4>Fleet Management</h4>
                  <p>
                    Our fleet management solution empowers users to efficiently add, monitor, and maintain their fleets with ease. Users can seamlessly input their fleet details, ensuring comprehensive tracking and management capabilities. Crucially, our system notifies users of impending document expirations.
                  </p>
                </div>
              </div>
            </div> 

            <div class="col-md-4">
              <div class="main main_secondrow">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/service7.png" alt="" />
                  </div>
                  <h4 class="service_heading">Operator Management</h4>
                  <p>
                    Our operator management allows users to find operators based on specific needs. Users can view operator ratings and feedback from previous employers, ensuring informed hiring decisions.Users can match their operational requirements with skilled operators, leveraging ratings and reviews for confident hiring.
                  </p>
                </div>
              </div>
            </div> 

            <div class="col-md-4">
              <div class="main main_secondrow">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/service6.png" alt="" />
                  </div>
                  <h4 class="service_heading">Accounts Management</h4>
                  <p>
                  Our account management feature simplifies creating, tracking, and managing quotations and bills. It provides clear visibility into pending and cleared bills, streamlining financial oversight for efficient business operations and fostering growth and profitability.



</div>
              </div>
            </div> 

            <div class="col-md-4">
              <div class="main main_secondrow">
                <div class="service newcard">
                  <div class="service-logo">
                    <img src="assets/images/jcb.png" alt="" />
                  </div>
                  <h4>Purchase Requisition</h4>
                  <p>
                    Our purchase requisition system facilitates direct interaction between OEMs listing their fleets and users seeking transparency in procurement. It ensures seamless communication and clear visibility, enabling efficient fleet acquisition with confidence.
                  </p>
                </div>
              </div>
            </div>
  

          </div>
        </div>
      </section>  


<br>
<br>
<footer class="new_footer_area bg_color" id="footer_content">
        <div class="new_footer_top">
            <div class="">
                <div class="row1">
                <div class="footer_content_main">
    <p>&copy; 2024 FleetEIP. All rights reserved. Unauthorized use or reproduction of any content is strictly prohibited.</p>
    <p><strong> Office Address:</strong>SF-B301,Roman Court,Near Parkar Mall,Kundli,Sonipat,Haryana 131023</p>
    <p><strong>Contact Us:</strong> support@fleeteip.com</p>
    <!-- <div class="social_line"><img src="facebook_logo.png" alt="Facebook" onclick="window.open('https://www.facebook.com/fleetEIP/', '_blank');" style="cursor: pointer;"><img src="linkedin.png"  alt="LinkedIn" onclick="window.open('https://www.linkedin.com/company/fleeteip/', '_blank');" style="cursor: pointer;"></div> -->
    <div class="f_social_icon socials">
    <a href="https://www.facebook.com/fleetEIP/" target="_blank" class="fab fa-facebook"></a>
<a href="https://www.linkedin.com/company/fleeteip/" target="_blank" class="fab fa-linkedin"></a>
                            </div>

  </div>
  

                    
                    <div class="col-lg-3 col-md-6">
                    </div>
                </div>
            </div>
            <div class="footer_bg">
                <div class="footer_bg_one"></div>
                <div class="footer_bg_two"></div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-7">
                        <p class="mb-0 f_400">©️ FleetEIP.</p>
                    </div>
                    <div class="col-lg-6 col-sm-5 text-right">
                    </div>
                </div>
            </div>
        </div>
    </footer>



<!-- <footer class="sign_up_footer" id="footer_content">
  <div class="footer_content_main">
    <div class="social_line"><img src="facebook_logo.png" alt="Facebook" onclick="window.open('https://www.facebook.com/fleetEIP/', '_blank');" style="cursor: pointer;"><img src="linkedin.png"  alt="LinkedIn" onclick="window.open('https://www.linkedin.com/company/fleeteip/', '_blank');" style="cursor: pointer;"></div>
    <p>&copy; 2024 FleetEIP. All rights reserved. Unauthorized use or reproduction of any content is strictly prohibited.</p>

  </div>
  <div class="footer_Secondary">
    <p><strong> Office Address:</strong>SF-B301,Roman Court,Near Parkar Mall,Kundli,Sonipat,Haryana 131023</p>
    <p><strong>Contact Us:</strong> support@fleeteip.com  &nbsp +91-89767 23779</p>
    

  </div>

</footer> -->
    


  </section>
</body>
</html>