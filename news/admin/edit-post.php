<?php 
session_start();
include('includes/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (strlen($_SESSION['loggedin']) == 0) {
    header('location:index.php');
    exit;
}

if (isset($_POST['update'])) {
    $posttitle = $_POST['posttitle'];
    $postdetails = strip_tags($_POST['postdescription']);
    $lastuptdby = $_SESSION['loggedin'];
    $arr = explode(" ", $posttitle);
    $url = implode("-", $arr);
    $status = 1;
    $postid = intval($_GET['pid']);

    $stmt = $con->prepare("UPDATE tblposts SET PostTitle=?, PostDetails=?, PostUrl=?, Is_Active=?, lastUpdatedBy=? WHERE id=?");
    $stmt->bind_param('sssisi', $posttitle, $postdetails, $url, $status, $lastuptdby, $postid);
    
    if ($stmt->execute()) {
        $msg = "Post updated successfully.";
    } else {
        $error = "Something went wrong. Please try again. " . $stmt->error;
    }
    $stmt->close();
}

$postid = intval($_GET['pid']);
$stmt = $con->prepare("SELECT id AS postid, PostImage, PostTitle AS title, PostDetails FROM tblposts WHERE id = ? AND Is_Active = 1");
$stmt->bind_param('i', $postid);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Query Error: ' . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>Newsportal | Edit Post</title>

    <!-- Summernote css -->
    <link href="../plugins/summernote/summernote.css" rel="stylesheet" />

    <!-- Select2 -->
    <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Jquery filer css -->
    <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
    <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <script src="assets/js/modernizr.min.js"></script>
</head>

<body class="fixed-left">
    <div id="wrapper">
        <?php include('includes/topheader.php');?>
        <?php include('includes/leftsidebar.php');?>

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Edit Post</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Posts</a></li>
                                    <li class="active">Edit Post</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?php if(isset($msg)) { ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            </div>
                            <?php } ?>

                            <?php if(isset($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <form name="addpost" method="post">
                                    <div class="form-group m-b-20">
                                        <label for="posttitle">Post Title</label>
                                        <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['title']);?>" name="posttitle" placeholder="Enter title" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                                                <textarea class="summernote" name="postdescription" required><?php echo htmlentities($row['PostDetails']);?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <h4 class="m-b-30 m-t-0 header-title"><b>Post Image</b></h4>
                                                <img src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300"/>
                                                <br />
                                                <a href="change-image.php?pid=<?php echo htmlentities($row['postid']);?>">Update Image</a>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php $stmt->close(); ?>
                </div>
            </div>
            <?php include('includes/footer.php');?>
        </div>
    </div>

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="../plugins/switchery/switchery.min.js"></script>

<!--Summernote js-->
<script src="../plugins/summernote/summernote.min.js"></script>
<!-- Select 2 -->
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Jquery filer js -->
<script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

<!-- page specific js -->
<script src="assets/pages/jquery.blog-add.init.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<script>
    jQuery(document).ready(function(){
        $('.summernote').summernote({
            height: 240,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        // Select2
        $(".select2").select2();

        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });
    });
</script>

<script src="../plugins/switchery/switchery.min.js"></script>
<!--Summernote js-->
<script src="../plugins/summernote/summernote.min.js"></script>

</body>
</html>
