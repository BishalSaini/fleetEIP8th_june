<?php 
session_start();
include('includes/config.php');

// Generating CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
    // Verifying CSRF Token
    if (!empty($_POST['csrftoken'])) {
        if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $_POST['comment'];
            $postid = intval($_GET['nid']);
            $st1 = '0';
            $query = mysqli_query($con, "INSERT INTO tblcomments(postId, name, email, comment, status) VALUES ('$postid', '$name', '$email', '$comment', '$st1')");
            if ($query) {
                echo "<script>alert('Comment successfully submitted. It will be displayed after admin review.');</script>";
                unset($_SESSION['token']);
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";  
            }
        }
    }
}

$postid = intval($_GET['nid']);

// Updating viewCounter
$sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $visits = $row["viewCounter"];
    $sql = "UPDATE tblposts SET viewCounter = $visits + 1 WHERE id = '$postid'";
    $con->query($sql);
} else {
    echo "No results";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FleetEIP | Home Page</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">
        <div class="row" style="margin-top: 4%">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- Blog Post -->
                <?php
                $pid = intval($_GET['nid']);
                $query = mysqli_query($con, "SELECT tblposts.PostTitle as posttitle, tblposts.PostImage, tblposts.PostDetails as postdetails, tblposts.PostingDate as postingdate, tblposts.PostUrl as url, tblposts.postedBy FROM tblposts WHERE tblposts.id = '$pid'");

                if (!$query) {
                    die("Error: " . mysqli_error($con));
                }

                while ($row = mysqli_fetch_array($query)) {
                ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
                        <p>
                            <b>Posted by </b> <?php echo htmlentities($row['postedBy']);?> on <?php echo htmlentities($row['postingdate']);?>
                        </p>
                        <p><strong>Share:</strong> 
                            <a href="http://www.facebook.com/share.php?u=<?php echo $currenturl;?>" target="_blank">Facebook</a> | 
                            <a href="https://twitter.com/share?url=<?php echo $currenturl;?>" target="_blank">Twitter</a> |
                            <a href="https://web.whatsapp.com/send?text=<?php echo $currenturl;?>" target="_blank">Whatsapp</a> | 
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $currenturl;?>" target="_blank">Linkedin</a>  
                            <b>Visits:</b> <?php echo $visits; ?>
                        </p>
                        <hr />
                        <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                        <p class="card-text"><?php echo htmlentities($row['postdetails']);?></p>
                    </div>
                    <div class="card-footer text-muted"></div>
                </div>
                <?php } ?>
            </div>

            <!-- Sidebar Widgets Column -->
            <?php include('includes/sidebar.php');?>
        </div>
        <!-- /.row -->

        <!-- Comment Section -->
        <div class="row" style="margin-top: -8%">
            <div class="col-md-8">
                <div class="card my-4">
                    <h5 class="card-header">Leave a Comment:</h5>
                    <div class="card-body">
                        <form name="Comment" method="post">
                            <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Comment Display Section -->
                <?php 
                $sts = 1;
                $query = mysqli_query($con, "SELECT name, comment, postingDate FROM tblcomments WHERE postId = '$pid' AND status = '$sts'");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                            <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
                        </h5>
                        <?php echo htmlentities($row['comment']);?>            
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
