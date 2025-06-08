<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .custom-navbar {
      height: 75px;
      background-color: hsl(220, 100%, 99%);
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px hsla(220, 68%, 12%, 0.1);
    } 

    .navbar-nav {
    display: flex;
    justify-content: right;
    align-items: center;
    width: 70%;
    height: 100%;
    /* border: 1px solid green; */
}

.navbar-nav ul {
    list-style-type: none;
    padding: 0; 
    margin: 0;
}

.navbar-nav li {
    display: inline-block; 
    padding: 15px; 
    text-align: center; 
    border: 1px solid transparent; 
    font-size: 17px;
    transition: border-color 0.3s, color 0.3s; 
    font-weight: 200; 
    font-family: "Poppins", sans-serif; 
}

.navbar-nav a {
    text-decoration: none; 
    color: hsl(220, 48%, 28%); 
    transition: color 0.3s; 
    font-weight: 100; 
    font-size: 17px; 
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; 
}

.navbar-nav a:hover {
    text-decoration: underline; 
}

  </style>
</head>
<body>
  <nav class="navbar fixed-top navbar-expand-lg custom-navbar">
    <div class="container">
      <!-- <a class="navbar-brand" href="index.php"><img src="images/logo.png" height="50"></a> -->
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="../rental_dashboard.php">Dashboard</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="index.php">News</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
