<style>
<?php include "style.css" ?>
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="main.js"></script>
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
		<li><a href="epc_dashboard.php.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<form action="" method="POST" class="rmc_epc_req1">
<div class="rmc_req_container1">
            <div class="rmc_req_heading1"><p>Piling Requirement</p></div>
            <div class="outer02">
        <div class="trial1">
                <input type="text" name="project_code" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Code</label>
            </div>
            <div class="trial1">
                <input type="text" name="project_name" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Name</label>
            </div>
            <div class="trial1">
        <select class="input02" name="project_type" id="">
            <option value="" disabled selected>Choose Project Type</option>
            <option value="Urban Infra">Urban Infra</option>
            <option value="PipeLine">PipeLine</option>
            <option value="Marine">Marine</option>
            <option value="Road">Road</option>
            <option value="Bridge And Metro">Bridge And Metro</option>
            <option value="Plant">Plant</option>
            <option value="Refinery">Refinery</option>
            <option value="other">Others</option>
        </select>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="project_location" class="input02">
                <label for="" class="placeholder2">Project Location</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="site_pincode" class="input02">
                <label for="" class="placeholder2">Site Pincode</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="date_req" class="input02">
                <label for="" class="placeholder2">Date Of Requirement</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="completion_time" class="input02">
                <label for="" class="placeholder2">Completion Time</label>
            </div>
            <div class="trial1">
            <select name="month_days" id="" class="input02">
                <option value=""disabled selected>Select An Option</option>
                <option value="Month">Month</option>
                <option value="Days">Days</option>
            </select>
            </div>
            <div class="trial1">
                <input type="text" name="tm_req" placeholder="" class="input02">
                <label for="" class="placeholder2">Rigs Required</label>
            </div>
            </div>
            <div class="trial1">
            <p class="boq">BOQ</p>
        </div>
        <div class="trial1">
            <textarea type="text" name="note_vendor" class="input02" placeholder=""></textarea>
            <label for="" class="placeholder2">Notes For Vendor</label>
        </div>
        <div class="outer02">
            
            <div class="trial1">
                <select name="" id="" class="input02">
                    <option value="none"disabled selected>Choose Piling Type?</option>
                    <option value="Piling In Soil">Piling In Soil</option>
                    <option value="Piling In Rock">Piling In Rock</option>
                </select>
            </div>
            <div class="trial1">
                <select name="" class="input02" id="choose_dia1" onchange="choosedia1()">
                    <option value="" disabled selected>Choose Dia?</option>
                    <option value="500mm">500mm</option>
                    <option value="750mm">750mm</option>
                    <option value="800mm">800mm</option>
                    <option value="1000mm">1000mm</option>
                    <option value="1200mm">1200mm</option>
                    <option value="1500mm">1500mm</option>
                    <option value="1800mm">1800mm</option>
                    <option value="2000mm">2000mm</option>
                    <option value="2500mm">2500mm</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="trial1" id="otherdia1">
            <input type="text" placeholder=""  class="input02">
            <label for="" class="placeholder2">Other Dia</label>
        </div>
            <div class="trial1">
                <input type="text" placeholder=""  class="input02" >
                <label for="" class="placeholder2">Pile Depth</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" value="<?PHP ECHO'RMT' ?>" class="input02" readonly>
                <label for="" class="placeholder2">UOM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" >
                <label for="" class="placeholder2">Quantity</label>
            </div></div>

           
        </div>


        

        



        <div class="outer02">
            <div class="trial1">
                <select name="" id="" class="input02">
                    <option value="none"disabled selected>Choose Piling Type?</option>
                    <option value="Piling In Soil">Piling In Soil</option>
                    <option value="Piling In Rock">Piling In Rock</option>
                </select>
            </div>
            <div class="trial1">
                <select name="" class="input02" id="">
                    <option value="" disabled selected>Choose Dia?</option>
                    <option value="500mm">500mm</option>
                    <option value="750mm">750mm</option>
                    <option value="800mm">800mm</option>
                    <option value="1000mm">1000mm</option>
                    <option value="1200mm">1200mm</option>
                    <option value="1500mm">1500mm</option>
                    <option value="1800mm">1800mm</option>
                    <option value="2000mm">2000mm</option>
                    <option value="2500mm">2500mm</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Other Dia</label>
        </div>
            <div class="trial1">
                <input type="text" placeholder=""  class="input02" >
                <label for="" class="placeholder2">Pile Depth</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?PHP ECHO'RMT' ?>" class="input02" readonly>
                <label for="" class="placeholder2">UOM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" >
                <label for="" class="placeholder2">Quantity</label>
            </div>

           
        </div>


        

        




        <div class="outer02">
            <div class="trial1">
                <select name="" id="" class="input02">
                    <option value="none"disabled selected>Choose Piling Type?</option>
                    <option value="Piling In Soil">Piling In Soil</option>
                    <option value="Piling In Rock">Piling In Rock</option>
                </select>
            </div>
            <div class="trial1">
                <select name="" class="input02" id="">
                    <option value="" disabled selected>Choose Dia?</option>
                    <option value="500mm">500mm</option>
                    <option value="750mm">750mm</option>
                    <option value="800mm">800mm</option>
                    <option value="1000mm">1000mm</option>
                    <option value="1200mm">1200mm</option>
                    <option value="1500mm">1500mm</option>
                    <option value="1800mm">1800mm</option>
                    <option value="2000mm">2000mm</option>
                    <option value="2500mm">2500mm</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Other Dia</label>
        </div>
            <div class="trial1">
                <input type="text" placeholder=""  class="input02" >
                <label for="" class="placeholder2">Pile Depth</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?PHP ECHO'RMT' ?>" class="input02" readonly>
                <label for="" class="placeholder2">UOM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" >
                <label for="" class="placeholder2">Quantity</label>
            </div>

           
        </div>


        

        





        <div class="outer02">
            <div class="trial1">
                <select name="" id="" class="input02">
                    <option value="none"disabled selected>Choose Piling Type?</option>
                    <option value="Piling In Soil">Piling In Soil</option>
                    <option value="Piling In Rock">Piling In Rock</option>
                </select>
            </div>
            <div class="trial1">
                <select name="" class="input02" id="">
                    <option value="" disabled selected>Choose Dia?</option>
                    <option value="500mm">500mm</option>
                    <option value="750mm">750mm</option>
                    <option value="800mm">800mm</option>
                    <option value="1000mm">1000mm</option>
                    <option value="1200mm">1200mm</option>
                    <option value="1500mm">1500mm</option>
                    <option value="1800mm">1800mm</option>
                    <option value="2000mm">2000mm</option>
                    <option value="2500mm">2500mm</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Other Dia</label>
        </div>
            <div class="trial1">
                <input type="text" placeholder=""  class="input02" >
                <label for="" class="placeholder2">Pile Depth</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?PHP ECHO'RMT' ?>" class="input02" readonly>
                <label for="" class="placeholder2">UOM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" >
                <label for="" class="placeholder2">Quantity</label>
            </div>

           
        </div>


        

        



        <div class="outer02">
            <div class="trial1">
                <select name="" id="" class="input02">
                    <option value="none"disabled selected>Choose Piling Type?</option>
                    <option value="Piling In Soil">Piling In Soil</option>
                    <option value="Piling In Rock">Piling In Rock</option>
                </select>
            </div>
            <div class="trial1">
                <select name="" class="input02" id="">
                    <option value="" disabled selected>Choose Dia?</option>
                    <option value="500mm">500mm</option>
                    <option value="750mm">750mm</option>
                    <option value="800mm">800mm</option>
                    <option value="1000mm">1000mm</option>
                    <option value="1200mm">1200mm</option>
                    <option value="1500mm">1500mm</option>
                    <option value="1800mm">1800mm</option>
                    <option value="2000mm">2000mm</option>
                    <option value="2500mm">2500mm</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Other Dia</label>
        </div>
            <div class="trial1">
                <input type="text" placeholder=""  class="input02" >
                <label for="" class="placeholder2">Pile Depth</label>
            </div>
            <div class="trial1">
                <input type="text" value="<?PHP ECHO'RMT' ?>" class="input02" readonly>
                <label for="" class="placeholder2">UOM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" >
                <label for="" class="placeholder2">Quantity</label>
            </div>

           
        </div>


        

        

        <div class="outer02">
        <div class="trial1" id="">
    <textarea name="" id="concrete_placing" cols="65" rows="5" placeholder="" class="input02"></textarea>
    <label for="" class="placeholder2">Particular-Concrete Placing</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo "CUM" ?>" class="input02 uom_liner" readonly>
    <label for="" class="placeholder2">UOM</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" class="input02 uom_liner">
    <label for="" class="placeholder2">Quantity</label>
</div>
        </div>


        <div class="outer02">
        <div class="trial1">
    <textarea name="" id="reinforcement"  cols="65" rows="5" placeholder="" class="input02"></textarea>
    <label for="" class="placeholder2">Particular-Reinforcement</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" value="<?php echo "MT" ?>" class="input02 uom_liner" readonly>
    <label for="" class="placeholder2">UOM</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" class="input02 uom_liner">
    <label for="" class="placeholder2">Quantity</label>
</div>
</div>
<div class="outer02">
        <div class="trial1">
    <textarea name="" id="ms_liner" cols="65" rows="5" placeholder="" class="input02"></textarea>
    <label for="" class="placeholder2"> Particular-MS Liner</label>
</div>

    
<div class="trial1">
    <input type="text" id="uom_liner" placeholder="" value="<?php echo "MT" ?>" class="input02 uom_liner" readonly>
    <label for="" class="placeholder2">UOM</label>
</div>
<div class="trial1">
    <input type="text"  placeholder="" class="input02 uom_liner">
    <label for="" class="placeholder2">Quantity</label>
</div>
<div class="abcd_piling" id="piling_button" onclick="other_part()">
            <i class="fa-solid fa-plus"></i>
            </div>


    </div>
    <div class="outer03" id="other_particular_container">
    <div class="outer02" >
        <div class="trial1">
    <textarea name="" id="other_particular" cols="65" rows="5" placeholder="" class="input02"></textarea>
    <label for="" class="placeholder2">Other Particular</label>
</div>
<div class="trial1">
    <input type="text" placeholder=""  class="input02 uom_liner" readonly>
    <label for="" class="placeholder2">UOM</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" class="input02 uom_liner">
    <label for="" class="placeholder2">Quantity</label>
</div>
    </div>
    </div>
    <div class="outer02">
        <div class="trial1">
<select name="" id="" class="input02">
    <option value="none"disabled selected>Sourcing Water In Scope Of?</option>
    <option value="Client">Client</option>
    <option value="Vendor">Vendor</option>
</select>
</div>
<div class="trial1">
    <select name="" id="" class="input02">
        <option value="none"disabled selected>Electricity In Scope Of?</option>
        <option value="Client">Client</option>
        <option value="Vendor">Vendor</option>
    </select>
</div> 
    </div>
<div class="outer02">
    <div class="trial1">
        <select name="" id="" class="input02">
            <option value="none" disabled selected>Payment Terms</option>
            <option value="Advance">Advance</option>
            <option value="15 Days">15 Days </option>
            <option value="30 Days">30 Days </option>
            <option value="45 Days">45 Days </option>
        </select>
    </div>
    <div class="trial1">
        <select name="" id="" class="input02">
            <option value="none" disabled selected>Mobilisation Advance</option>
            <option value="Yes">Yes </option>
            <option value="No">No </option>
        </select>
    </div>
   

</div> 
<div class="outer02">
<div class="trial1">
        <input type="file" placeholder="" class="input02">
        <label for="" class="placeholder2">Upload Soil Report</label>
    </div>
    <div class="trial1">
        <input type="file" placeholder="" class="input02">
        <label for="" class="placeholder2">Upload BBS Report</label>
    </div> </div>     
    
        <button class="epc-button">Submit</button>
<br><br>


</div>
</form>
<br><br>
<script>
    function other_part(){
    const plus=document.getElementById("piling_button");
    const particular=document.getElementById("other_particular_container")

    plus.style.display="none";
    particular.style.display="block";
}

function choosedia1(){
    const dia_dd=document.getElementById("choose_dia1");
    const dia1=document.getElementById("otherdia1");
    if(dia_dd.value==='Other'){
        dia1.style.display="block";
    }
    else{
        dia1.style.display="none";
    }
}
    </script>
</body>
</html>