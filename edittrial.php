<div class="otherquipquote" id="">
        <br>
        <p>Add Second Equipment Details</p>
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code7" class="input02" onchange="choose_new_equipment2_edit()" id="choose_Ac2">
            <option value="" disabled selected>Choose Asset Code</option>
            <option value="New Equipment" <?php if(isset($row3['asset_code2']) && $row3['asset_code2'] === 'New Equipment'){ echo 'selected'; } ?>>Choose New Equipment</option>
            <?php
while ($row_asset_code3 = mysqli_fetch_assoc($result_asset_code2)) {
    echo '<option value="' . htmlspecialchars($row_asset_code3['assetcode']) . '"';
    if (isset($row3['asset_code2']) && $row3['asset_code2'] === $row_asset_code3['assetcode']) {
        echo ' selected';
    }
    echo '>' . htmlspecialchars($row_asset_code3['assetcode']) . ' (' . htmlspecialchars($row_asset_code3['sub_type']) . ' ' . htmlspecialchars($row_asset_code3['make']) . ' ' . htmlspecialchars($row_asset_code3['model']) . ')' . '</option>';
}
?>
        </select>
        </div>
        <div class="trial1">
            <select name="avail1" id="availability_dd2" class="input02" onchange="not_immediate2()">
                <option value=""disabled selected>Availability</option>
                <option <?php if(isset($row3['availability2']) && $row3['availability2']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if(isset($row3['availability2']) && $row3['availability2']==='Not Immediate'){echo 'selected';} ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability2" >
            <input type="date" placeholder="" value="<?php if(isset($row3['tentative_date2'])) {echo $row3['tentative_date2'];} ?>" name="date_" class="input02">
            <label for="" class="placeholder2">Tentative Date Of Availability</label>
        </div>

        </div>
        <div class="prefilldata_secondvehicle" id="sec_equipment_prefill_fields">
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row3['yom2'])){ echo $row3['yom2'];} ?>" name="yom_equip_second" id="yom_second" class="input02">
            <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row3['cap2'])){ echo $row3['cap2'];} ?>" name="capacity_equip_second" id="capacity_second" class="input02">
            <label for="" class="placeholder2">Capacity</label>
            </div>

        
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" value="<?php if(isset($row3['boom2'])){ echo $row3['boom2'];} ?>" placeholder="" name="boom_equip_second" id="boomlength_second" class="input02">
            <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row3['jib2'])){ echo $row3['jib2'];} ?>" name="jib_equip_second" id="jiblength_second" class="input02">
            <label for="" class="placeholder2">Jib Length</label>
            </div>

            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row3['luffing2'])){ echo $row3['luffing2'];} ?>" name="luffing_equip_second" id="luffinglength_second" class="input02">
            <label for="" class="placeholder2">Luffing Length</label>
            </div>

        
        </div>
        </div>

        <div class="newequip_details1" id="newequipdet7">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category7" id="oem_fleet_type7" onchange="seco_equip_2()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if(isset($row3) && $row3['category2']==='Aerial Work Platform'){ echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
            <option <?php if(isset($row3) && $row3['category2']==='Concrete Equipment'){ echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
            <option <?php if(isset($row3) && $row3['category2']==='EarthMovers and Road Equipments'){ echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option <?php if(isset($row3) && $row3['category2']==='Material Handling Equipments'){ echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
            <option <?php if(isset($row3) && $row3['category2']==='Ground Engineering Equipments'){ echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option <?php if(isset($row3) && $row3['category2']==='Trailor and Truck'){ echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
            <option <?php if(isset($row3) && $row3['category2']==='Generator and Lighting'){ echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type7" id="fleet_sub_type1" >
        <option value="" disabled selected>Select Fleet Type</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Self Propelled Articulated Boomlift'){ echo 'selected'; } ?> value="Self Propelled Articulated Boomlift" class="awp_options7">Self Propelled Articulated Boomlift</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Scissor Lift Diesel'){ echo 'selected'; } ?> value="Scissor Lift Diesel" class="awp_options7">Scissor Lift Diesel</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Scissor Lift Electric'){ echo 'selected'; } ?> value="Scissor Lift Electric" class="awp_options7">Scissor Lift Electric</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Spider Lift'){ echo 'selected'; } ?> value="Spider Lift" class="awp_options7">Spider Lift</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Self Propelled Straight Boomlift'){ echo 'selected'; } ?> value="Self Propelled Straight Boomlift" class="awp_options7">Self Propelled Straight Boomlift</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Truck Mounted Articulated Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Articulated Boomlift" class="awp_options7">Truck Mounted Articulated Boomlift</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Truck Mounted Straight Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Straight Boomlift" class="awp_options7">Truck Mounted Straight Boomlift</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Batching Plant'){ echo 'selected'; } ?> value="Batching Plant" class="cq_options7">Batching Plant</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Self Loading Mixer'){ echo 'selected'; } ?> value="Self Loading Mixer" class="cq_options7">Self Loading Mixer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Concrete Boom Placer'){ echo 'selected'; } ?> value="Concrete Boom Placer" class="cq_options7">Concrete Boom Placer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Concrete Pump'){ echo 'selected'; } ?> value="Concrete Pump" class="cq_options7">Concrete Pump</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Moli Pump'){ echo 'selected'; } ?> value="Moli Pump" class="cq_options7">Moli Pump</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Mobile Batching Plant'){ echo 'selected'; } ?> value="Mobile Batching Plant" class="cq_options7">Mobile Batching Plant</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Static Boom Placer'){ echo 'selected'; } ?> value="Static Boom Placer" class="cq_options7">Static Boom Placer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Transit Mixer'){ echo 'selected'; } ?> value="Transit Mixer" class="cq_options7">Transit Mixer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Baby Roller'){ echo 'selected'; } ?> value="Baby Roller" class="earthmover_options7">Baby Roller</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Backhoe Loader'){ echo 'selected'; } ?> value="Backhoe Loader" class="earthmover_options7">Backhoe Loader</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Bulldozer'){ echo 'selected'; } ?> value="Bulldozer" class="earthmover_options7">Bulldozer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Excavator'){ echo 'selected'; } ?> value="Excavator" class="earthmover_options7">Excavator</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Milling Machine'){ echo 'selected'; } ?> value="Milling Machine" class="earthmover_options7">Milling Machine</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Motor Grader'){ echo 'selected'; } ?> value="Motor Grader" class="earthmover_options7">Motor Grader</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Pneumatic Tyre Roller'){ echo 'selected'; } ?> value="Pneumatic Tyre Roller" class="earthmover_options7">Pneumatic Tyre Roller</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Single Drum Roller'){ echo 'selected'; } ?> value="Single Drum Roller" class="earthmover_options7">Single Drum Roller</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Skid Loader'){ echo 'selected'; } ?> value="Skid Loader" class="earthmover_options7">Skid Loader</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Slip Form Paver'){ echo 'selected'; } ?> value="Slip Form Paver" class="earthmover_options7">Slip Form Paver</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Soil Compactor'){ echo 'selected'; } ?> value="Soil Compactor" class="earthmover_options7">Soil Compactor</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Tandem Roller'){ echo 'selected'; } ?> value="Tandem Roller" class="earthmover_options7">Tandem Roller</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Vibratory Roller'){ echo 'selected'; } ?> value="Vibratory Roller" class="earthmover_options7">Vibratory Roller</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Wheeled Excavator'){ echo 'selected'; } ?> value="Wheeled Excavator" class="earthmover_options7">Wheeled Excavator</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Wheeled Loader'){ echo 'selected'; } ?> value="Wheeled Loader" class="earthmover_options7">Wheeled Loader</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Fixed Tower Crane'){ echo 'selected'; } ?> value="Fixed Tower Crane" class="mhe_options7">Fixed Tower Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Fork Lift Diesel'){ echo 'selected'; } ?> value="Fork Lift Diesel" class="mhe_options7">Fork Lift Diesel</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Fork Lift Electric'){ echo 'selected'; } ?> value="Fork Lift Electric" class="mhe_options7">Fork Lift Electric</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Hammerhead Tower Crane'){ echo 'selected'; } ?> value="Hammerhead Tower Crane" class="mhe_options7">Hammerhead Tower Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Hydraulic Crawler Crane'){ echo 'selected'; } ?> value="Hydraulic Crawler Crane" class="mhe_options7">Hydraulic Crawler Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Luffing Jib Tower Crane'){ echo 'selected'; } ?> value="Luffing Jib Tower Crane" class="mhe_options7">Luffing Jib Tower Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Mechanical Crawler Crane'){ echo 'selected'; } ?> value="Mechanical Crawler Crane" class="mhe_options7">Mechanical Crawler Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Pick and Carry Crane'){ echo 'selected'; } ?> value="Pick and Carry Crane" class="mhe_options7">Pick and Carry Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Reach Stacker'){ echo 'selected'; } ?> value="Reach Stacker" class="mhe_options7">Reach Stacker</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Rough Terrain Crane'){ echo 'selected'; } ?> value="Rough Terrain Crane" class="mhe_options7">Rough Terrain Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Telehandler'){ echo 'selected'; } ?> value="Telehandler" class="mhe_options7">Telehandler</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Telescopic Crawler Crane'){ echo 'selected'; } ?> value="Telescopic Crawler Crane" class="mhe_options7">Telescopic Crawler Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Telescopic Mobile Crane'){ echo 'selected'; } ?> value="Telescopic Mobile Crane" class="mhe_options7">Telescopic Mobile Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='All Terrain Mobile Crane'){ echo 'selected'; } ?> value="All Terrain Mobile Crane" class="mhe_options7">All Terrain Mobile Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Self Loading Truck Crane'){ echo 'selected'; } ?> value="Self Loading Truck Crane" class="mhe_options7">Self Loading Truck Crane</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Hydraulic Drilling Rig'){ echo 'selected'; } ?> value="Hydraulic Drilling Rig" class="gee_options7">Hydraulic Drilling Rig</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Rotary Drilling Rig'){ echo 'selected'; } ?> value="Rotary Drilling Rig" class="gee_options7">Rotary Drilling Rig</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Vibro Hammer'){ echo 'selected'; } ?> value="Vibro Hammer" class="gee_options7">Vibro Hammer</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Dumper'){ echo 'selected'; } ?> value="Dumper" class="trailor_options7">Dumper</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Truck'){ echo 'selected'; } ?> value="Truck" class="trailor_options7">Truck</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Water Tanker'){ echo 'selected'; } ?> value="Water Tanker" class="trailor_options7">Water Tanker</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Low Bed'){ echo 'selected'; } ?> value="Low Bed" class="trailor_options7">Low Bed</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Semi Low Bed'){ echo 'selected'; } ?> value="Semi Low Bed" class="trailor_options7">Semi Low Bed</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Flatbed'){ echo 'selected'; } ?> value="Flatbed" class="trailor_options7">Flatbed</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Hydraulic Axle'){ echo 'selected'; } ?> value="Hydraulic Axle" class="trailor_options7">Hydraulic Axle</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Silent Diesel Generator'){ echo 'selected'; } ?> value="Silent Diesel Generator" class="generator_options7">Silent Diesel Generator</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Mobile Light Tower'){ echo 'selected'; } ?> value="Mobile Light Tower" class="generator_options7">Mobile Light Tower</option>
    <option <?php if(isset($row3['sub_type2']) && $row3['sub_type2']==='Diesel Generator'){ echo 'selected'; } ?> id="generator_option3" value="Diesel Generator" class="generator_options7">Diesel Generator</option>        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row3['make2'])){ echo $row3['make2'] ;}?>" name="newfleetmake7" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" value="<?php if(isset($row3['model2'])) { echo $row3['model2']; } ?>" name="newfleetmodel7" class="input02">
        <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text"  value="<?php if(isset($row3['cap2'])){ echo $row3['cap2'];} ?>" placeholder="" name="fleetcap7" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit7" id="" class="input02">
                <option  value=""disabled selected>Unit</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='m^3'){ echo 'selected';} ?> value="m^3">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="yom7" value="<?php if(isset($row3['yom3'])) {echo $row3['yom2'];} ?>" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" value="<?php if(isset($row3['boom2'])) {echo $row3['boom2'];} ?>" name="boomLength7"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" value="<?php if(isset($row3['jib2'])){echo $row3['jib2'];} ?>" name="jibLength7"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength7" value="<?php if(isset($row3['luffing2'])) {echo $row3['luffing2'];} ?>"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="rental2" value="<?php if(isset($row3['rental_charges2'])) {echo $row3['rental_charges2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="mob02" placeholder="" value="<?php if(isset($row3['mob_charges2'])) {echo $row3['mob_charges2'];} ?>" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="demob02" value="<?php if(isset($row3['demob_charges2'])) {echo $row3['demob_charges2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation02" value="<?php if(isset($row3['crane_location2'])) {echo $row3['crane_location2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <select name="adblue2" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if(isset($row3['adblue2']) && $row3['adblue2'] === 'Yes') { echo 'selected'; } ?> value="Yes">Yes</option>
                <option <?php if(isset($row3['adblue2']) && $row3['adblue2'] === 'No') { echo 'selected'; } ?> value="No">No</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text"  value="<?php if(isset($row3['fuel/hour2'])) {echo $row3['fuel/hour2'];} ?>" placeholder="" name="fuelperltr2" class="input02">
            <label for="" class="placeholder2">Fuel in ltrs Per Hour</label>
        </div>
        </div>
        </div>
