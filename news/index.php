<?php 
session_start();
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FleetEIP News</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">   
    <style>   
        .rm { 
            text-decoration: none!important;
        }
        .readmore {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s linear;
            border-radius: 5px; 
            background: hsl(220, 48%, 48%);  
            color: white;
            border: 1px solid;
            padding: 10px 20px;  
        } 
        .readmore > svg {
            margin-left: 5px;
            transition: all 0.4s ease-in;
        }
        .readmore:hover > svg {
            font-size: 1.2em; 
            transform: translateX(6px);
        }
        .readmore:hover {
            box-shadow: 10px 10px 40px #d1d1d1;
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">
        <div class="row" style="margin-top: 4%">
            <!-- Blog Entries Column -->
            <?php 
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $no_of_records_per_page = 8;
            $offset = ($pageno - 1) * $no_of_records_per_page;

            $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
            $result = mysqli_query($con, $total_pages_sql);
            $total_rows = mysqli_fetch_array($result)[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $query = mysqli_query($con, "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle, tblposts.PostImage, tblposts.PostDetails as postdetails, tblposts.PostingDate as postingdate FROM tblposts WHERE tblposts.Is_Active=1 ORDER BY tblposts.id DESC LIMIT $offset, $no_of_records_per_page");

            $counter = 0; // To track the number of news items processed
            while ($row = mysqli_fetch_array($query)) {
                if ($counter % 2 == 0) { // Start a new column every two news items
                    if ($counter > 0) echo '</div>'; // Close the previous row div if not the first column
                    echo '<div class="col-md-6 mb-4">'; // Open a new column
                }
                ?>

                <div class="card mb-4">
                    <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="rm">
                            <button class="readmore">
                                <span>Read More</span>
                                <svg width="15" height="15" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </button>
                        </a> 
                    </div>
                    <div class="card-footer text-muted">
                        Posted on <?php echo htmlentities($row['postingdate']);?>
                    </div>
                </div>

                <?php
                $counter++;
            }
            if ($counter % 2 != 0) echo '</div>'; // Close the last column if odd number of items
            
            ?>

            <!-- Pagination -->
            <ul class="pagination justify-content-center mb-4">
                <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link">Prev</a>
                </li>
                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>" class="page-link">Next</a>
                </li>
                <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
            </ul>
        </div>

   
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
