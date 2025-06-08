<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $newshead = $_POST["news_head"];
    $newscontent = nl2br($_POST["news_content"]);

    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] === 0) {
        $newsImageName = $_FILES['news_image']['name'];
        $newsImageTempName = $_FILES['news_image']['tmp_name'];
        
        $imageUploadPath = 'img/' . $newsImageName; 

        if (move_uploaded_file($newsImageTempName, $imageUploadPath)) {
            $query = "INSERT INTO `news` (`news_head`, `news_content`, `news_image`) 
                     VALUES (?, ?, ?)";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $newshead, $newscontent, $newsImageName);
            $result = $stmt->execute();

            if ($result) {
                $showAlert = true;
            } else {
                $showError = true;
            }
        }
    } else {
        // Handle case where no file was uploaded
        $showError = true;
    }
}
?><style>
<?php include "style.css"; ?>
</style>
<script>
    <?php include "main.js"; ?>
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

    <div class="iconcontainer">
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <!-- <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="sign_up.php">Sign Up</a></li>
        </ul>
    </div>
</div>

<?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">News Added Successfully<br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>

<form action="add_news.php" method="POST" class="form_news" enctype="multipart/form-data" autocomplete="off">
    <div class="outer121">
        <div class="headcont"><p>Add News</p></div>
        <div class="trial1">
            <input type="file" name="news_image" class="input02">
            <label class="placeholder2">Add Image</label>
        </div>    
        <div class="trial1">
            <input type="text" name="news_head" class="input02">
            <label class="placeholder2">News Heading</label>
        </div>
        <div class="trial1">
            <textarea name="news_content" class="input02"></textarea>
            <label class="placeholder2">News Content</label>
            <br>
            <button type="submit" class="epc-button">Post News</button>
            <br>
            <br>
        </div>
    </div>
</form>
</body>
</html>