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
		<li><a href="commercial_rmc_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<form action="" class="rmc_sales" autocomplete="off">
    <div class="rmc_salesperson_container">
        <div class="salespersonhead"><p>Add Vendor</p></div>
        
        <!-- <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Vendor Name</label>
        </div> -->
        <!-- <div class="outer02"> -->
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Vendor Company Name</label>
            </div>
            
        <!-- </div> -->
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Gst Number</label>
            </div>
            <div class="trial1">
            <input type="file" placeholder="" class="input02">
            <label for="" class="placeholder2"> Upload Gst Certificate </label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Pan Card Number</label>
            </div>
            <div class="trial1">
            <input type="file" placeholder="" class="input02">
            <label for="" class="placeholder2"> Upload Pan Card </label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Mobile Number</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Email</label>
        </div>
        </div>
<div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Address</label>
        </div>
        <div class="trial1">
            <select name="" id="" class="input02">
                <option value="none"disabled selected>Select State</option>
                <option value="">Select a state</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
    <option value="Daman and Diu">Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Puducherry">Puducherry</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
            </select>
        </div>
        </div>
        
        <div class="outer02">
        <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Bank Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Account Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">IFSC Code</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <select name="" id="" class="input02">
                <option value="none"disabled selected>Are You MSME Registered?</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="trial1">
            <input type="file" class="input02">
            <label for="" class="placeholder2">Upload MSME Certificate</label>
        </div>
        </div>
        <div class="trial1">
            <p class="product_services">Product/Services</p>
        </div>
       <div class="service_container">
       <div class="new">

            <input type="checkbox" class="">
            <label for="" class="">Spare Part & Accessories </label>
            </div>
            <div class="new">
            <input type="checkbox" class="">
            <label for="" class="">Authorised Tyre Dealer</label>
            </div><div class="new">
            <input type="checkbox" class="">
            <label for="" class="">Lubricants & Grease</label>
            </div><div class="new">
            <input type="checkbox" class="">
            <label for="" class="">Authorised Cement Dealer/Distributor</label>
            </div>
            <div class="new">
            <input type="checkbox" class="">
            <label for="" class="">Raw Material Supplier</label>
            </div>
            </div>

        <br>
<button class="epc-button">Submit</button>
<br>

        
    </div>
</form>
<br>
    </div>
</form>
    
</body>
</html>