<?php
include 'partials/_dbconnect.php';
if(isset($_POST['input'])){
    $input = $_POST['input'];
    $query = "SELECT * FROM team_members WHERE company_name LIKE '%$input%'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){?> 
    <div class="outertable">
    <table class="users_table">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Designation</th>

            </tr>
        </thead>
        <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $mob_num = $row['mob_number'];
                $user_email = $row['email'];
                // $companyname = $row['company name'];
                $designation = $row['designation'];
                ?>
                <tr>
                    <td><?php echo $row['company_name'];?></td>

                    <td><?php echo $name;?></td>
                    <td><?php echo $mob_num;?></td>
                    <td><?php echo $user_email;?></td>
                    <td><?php echo $designation;?></td>

                </tr>
                <?php

            }
            ?>
        </tbody>
    </table>
    </div>
    
    <?php
    }else{
        echo"<h3 class='no_data'>No Data Found</h3>";
    }
}
?>