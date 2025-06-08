function showTextBox() {
    const select1 = document.getElementById("mySelect1");
    const div1 = document.getElementById("hide_show");
    const div2 = document.getElementById("hide_show1");
    const div3 = document.getElementById("hide_show2");
    



    if (select1.value==="Crawler") {
        div1.style.display = "block";
        div2.style.display = "block";
        div3.style.display = "block";
        div4.style.display = "block";
        div5.style.display = "block";
        div6.style.display = "block";


    } else {
        div1.style.display = "none";
        div2.style.display = "none";
        div3.style.display = "none";
        div6.style.display = "none";
        div4.style.display = "none";
        div5.style.display = "none";


    }
}

function showTextBox2(){
    const select2 = document.getElementById("mySelect2");
    const div4 = document.getElementById("hide_show00");
    const div5 = document.getElementById("hide_show01");
    const div6 = document.getElementById("hide_show02");

    if (select2.value==="Crawler") {
        div4.style.display = "block";
        div5.style.display = "block";
        div6.style.display = "block";
    }
    else{
        div6.style.display = "none";
        div4.style.display = "none";
        div5.style.display = "none";
    }

    

}


function showOption(){
    const oem_fleet_type = document.getElementById("oem_fleet_type");
    const option1 = document.getElementById("aerial_work_platform_option1");
    const option2 = document.getElementById("aerial_work_platform_option2");
    const option3 = document.getElementById("aerial_work_platform_option3");
    const option4 = document.getElementById("aerial_work_platform_option4");
    const option5 = document.getElementById("aerial_work_platform_option5");
    const option6 = document.getElementById("aerial_work_platform_option6");
    const option7 = document.getElementById("aerial_work_platform_option7");

    const option8 = document.getElementById("concrete_equipment_option1");
    const option9 = document.getElementById("concrete_equipment_option2");
    const option10 = document.getElementById("concrete_equipment_option3");
    const option11 = document.getElementById("concrete_equipment_option4");
    const option12 = document.getElementById("concrete_equipment_option5");
    const option13 = document.getElementById("concrete_equipment_option6");
    const option14 = document.getElementById("concrete_equipment_option7");

    const option15 = document.getElementById("earthmovers_option1");
    const option16 = document.getElementById("earthmovers_option2");
    const option17 = document.getElementById("earthmovers_option3");
    const option18 = document.getElementById("earthmovers_option4");
    const option19 = document.getElementById("earthmovers_option5");
    const option20 = document.getElementById("earthmovers_option6");
    const option21 = document.getElementById("earthmovers_option7");
    const option22 = document.getElementById("earthmovers_option8");
    const option23 = document.getElementById("earthmovers_option9");
    const option24 = document.getElementById("earthmovers_option10");
    const option25 = document.getElementById("earthmovers_option11");
    const option26 = document.getElementById("earthmovers_option12");
    const option27 = document.getElementById("earthmovers_option13");
    const option28 = document.getElementById("earthmovers_option14");
    const option29 = document.getElementById("earthmovers_option15");

    const option30 = document.getElementById("mhe_option1");
    const option31 = document.getElementById("mhe_option2");
    const option32 = document.getElementById("mhe_option3");
    const option33 = document.getElementById("mhe_option4");
    const option34 = document.getElementById("mhe_option5");
    const option35 = document.getElementById("mhe_option6");
    const option36 = document.getElementById("mhe_option7");
    const option37 = document.getElementById("mhe_option8");
    const option38 = document.getElementById("mhe_option9");
    const option39 = document.getElementById("mhe_option10");
    const option40 = document.getElementById("mhe_option11");
    const option41 = document.getElementById("mhe_option12");
    const option42 = document.getElementById("mhe_option13");
    const option43 = document.getElementById("mhe_option14");
    const option99 = document.getElementById("mhe_option15");


    const option44 = document.getElementById("ground_engineering_equipment_option1");
    const option45 = document.getElementById("ground_engineering_equipment_option2");
    const option46 = document.getElementById("ground_engineering_equipment_option3");

    const option47 = document.getElementById("trailor_option1");
    const option48 = document.getElementById("trailor_option2");
    const option49 = document.getElementById("trailor_option3");
    const option50 = document.getElementById("trailor_option4");
    const option51 = document.getElementById("trailor_option5");
    const option52 = document.getElementById("trailor_option6");
    const option53 = document.getElementById("trailor_option7");

    const option54 = document.getElementById("generator_option1");
    const option55 = document.getElementById("generator_option2");
    const option56 = document.getElementById("generator_option3");

    // let menu = document.getElementById("oem_fleet_type")
    const cntr_weight = document.getElementById("counter_weight_input")
    const spr_lift = document.getElementById("superlift_dd")











    if(oem_fleet_type.value === "aerial_work_platform")
    {
        option1.style.display="block";
        option2.style.display="block";
        option3.style.display="block";
        option4.style.display="block";
        option5.style.display="block";
        option6.style.display="block";
        option7.style.display="block";
    }
    else{
        option1.style.display="none";
        option2.style.display="none";
        option3.style.display="none";
        option4.style.display="none";
        option5.style.display="none";
        option6.style.display="none";
        option7.style.display="none";
    }
    if(oem_fleet_type.value === "concrete_equipment")
    {
        option8.style.display="block";
        option9.style.display="block";
        option10.style.display="block";
        option11.style.display="block";
        option12.style.display="block";
        option13.style.display="block";
        option14.style.display="block";
    }

    else{
        option8.style.display="none";
        option9.style.display="none";
        option10.style.display="none";
        option11.style.display="none";
        option12.style.display="none";
        option13.style.display="none";
        option14.style.display="none";
    }
    if(oem_fleet_type.value === "earthmovers_equipments")
    {
        option15.style.display="block";
        option16.style.display="block";
        option17.style.display="block";
        option18.style.display="block";
        option19.style.display="block";
        option20.style.display="block";
        option21.style.display="block";
        option22.style.display="block";
        option23.style.display="block";
        option24.style.display="block";
        option25.style.display="block";
        option26.style.display="block";
        option27.style.display="block";
        option28.style.display="block";
        option29.style.display="block";
  
    }
    else{
        option15.style.display="none";
        option16.style.display="none";
        option17.style.display="none";
        option18.style.display="none";
        option19.style.display="none";
        option20.style.display="none";
        option21.style.display="none";
        option22.style.display="none";
        option23.style.display="none";
        option24.style.display="none";
        option25.style.display="none";
        option26.style.display="none";
        option27.style.display="none";
        option28.style.display="none";
        option29.style.display="none";
    }
    if(oem_fleet_type.value === "mhe")
    {
        option30.style.display="block";
        option31.style.display="block";
        option32.style.display="block";
        option33.style.display="block";
        option34.style.display="block";
        option35.style.display="block";
        option36.style.display="block";
        option37.style.display="block";
        option38.style.display="block";
        option39.style.display="block";
        option40.style.display="block";
        option41.style.display="block";
        option42.style.display="block";
        option43.style.display="block";
        option99.style.display="block";
        cntr_weight.style.display="block";
        spr_lift.style.display="block";

  
    }
    else{
        option30.style.display="none";
        option30.style.display="none";
        option31.style.display="none";
        option32.style.display="none";
        option33.style.display="none";
        option34.style.display="none";
        option35.style.display="none";
        option36.style.display="none";
        option37.style.display="none";
        option38.style.display="none";
        option39.style.display="none";
        option40.style.display="none";
        option41.style.display="none";
        option42.style.display="none";
        option43.style.display="none";
        option99.style.display="none";
        cntr_weight.style.display="none";
        spr_lift.style.display="none";

    }
    if(oem_fleet_type.value === "ground_engineering_equioments")
    {
        option44.style.display="block";
        option45.style.display="block";
        option46.style.display="block";
 
    }
    else{
        option44.style.display="none";
        option45.style.display="none";
        option46.style.display="none";
    }
    if(oem_fleet_type.value === "trailor_truck")
    {
        option47.style.display="block";
        option48.style.display="block";
        option49.style.display="block";
        option50.style.display="block";
        option51.style.display="block";
        option52.style.display="block";
        option53.style.display="block";
    }
    else{
        option47.style.display="none";
        option48.style.display="none";
        option49.style.display="none";
        option50.style.display="none";
        option51.style.display="none";
        option52.style.display="none";
        option53.style.display="none";
    }
    if(oem_fleet_type.value === "generator_lighting"){
        option54.style.display="block";
        option55.style.display="block";
        option56.style.display="block";

    }
    else{
        option54.style.display="none";
        option55.style.display="none";
        option56.style.display="none";
    }


    }

function hide(){
    const subtype = document.getElementById("oem_fleet_sub_type");
    const dd = document.getElementById("chassis_make1");

    if( subtype.value === "truck_mounted_articulated_boomlift")
    {
        dd.style.display="block";
    }
    else if( subtype.value === "truck_mounted_straight_boomlift")
    {
        dd.style.display="block";
    }
    else if( subtype.value === "concrete_boom_placer")
    {
        dd.style.display="block";
    }
    else if( subtype.value === "self_loading_truck_crane")
    {
        dd.style.display="block";
    }

    else{
        dd.style.display="none";
    }
  
    
}
function other_textbox1(){
    let make_dd = document.getElementById("crane_make_dd");
    let other1 = document.getElementById("other_input1")

    if(make_dd.value === "other_make"){
        other1.style.display="block";
    }
    else{
        other1.style.display="none";
    }
}

function other_chassis(){
    let otherchassis = document.getElementById("chassis_make1")
    let textbox_chassis = document.getElementById("otherchassis_tectbox")

    if(otherchassis.value ==="other_brand"){
        textbox_chassis.style.display="block"
    }
    else{
        textbox_chassis.style.display="none";
    }
}

function input_visible(){
    let ddinput=document.getElementById("superlift_dd")
    let weight_input_field=document.getElementById("superlift_weight")
     if(ddinput.value ==="yes")
     {
        weight_input_field.style.display="block";
     }
     else{
        weight_input_field.style.display="none";
     }

}

function showPhoto(){
    const selectyes = document.getElementById("edit_uploaded_images")
    const image1 = document.getElementById("picture1")
    const image2 = document.getElementById("picture2")
    const image3 = document.getElementById("picture3")

    if(selectyes.value === "yes"){
        image1.style.display="block";
        image2.style.display="block";
        image3.style.display="block";

    }
    else{
        image2.style.display="none";
        image3.style.display="none";
        image1.style.display="none";

    }

}


function rental_addfleet(){
    const make = document.getElementById("crane_make_retnal");
    const textbox01 = document.getElementById("othermake01");

    if(make.value==="Others"){
        textbox01.style.display="block";
    }
    else{
        textbox01.style.display="none";
    }
}

function chassis_make_rental1(){
    const chassis = document.getElementById("chassis_make_rental");
    const other_chassis = document.getElementById("otherchassis")

    if(chassis.value==="Other"){
        other_chassis.style.display="block"
    }
    else{
        other_chassis.style.display="none";
    }
}

function crawler_options() {
    const sub_types = document.getElementById("fleet_sub_type");
    const chassis_make_rental_outer = document.getElementById("chassis_make_rental_outer");
    const registration = document.getElementById("registration_rental");
    const kealy_length = document.getElementById("kealy_length");
    const pipelength = document.getElementById("pipelength");
    const length01 = document.getElementById("length_container");
    const boom_input = document.getElementById("boom_input");
    const silos_container = document.getElementById("silos_container");
    const jib_input = document.getElementById("jib_input");
    const luffing_input = document.getElementById("luffing_input");
    const silos_qty_container = document.getElementById("silos_qty_container");
    const forklift_height = document.getElementById("forklift_height");
    const tower_crane = document.getElementById("tower_crane");
    const kmrsellfleet=document.getElementById("kmrsellfleet");
    const hmrsellfleet=document.getElementById("hmrsellfleet");
    const reg_container=document.getElementById("reg_container");

    // Reset all elements to default
    const elementsToHide = [
        registration, kealy_length, pipelength, length01, chassis_make_rental_outer,
        silos_container, forklift_height, boom_input, jib_input, luffing_input,
        tower_crane, silos_qty_container,reg_container
    ];
    const elementsToShow = [
        kmrsellfleet, hmrsellfleet
    ];

    elementsToHide.forEach(el => {
        el.style.display = 'none';
        el.style.width = '';  // Clear any previously set widths
        el.style.height = ''; // Clear any previously set heights
    });

    console.log('Selected sub_type:', sub_types.value);

    switch (sub_types.value) {
        case "Hydraulic Crawler Crane":
        case "Mechanical Crawler Crane":
        case "Telescopic Crawler Crane":
        case "Pick and Carry Crane":
        // // case "Telescopic Mobile Crane":
        // case "Rough Terrain Crane":
            length01.style.display = "block";
            boom_input.style.display = "block";
            jib_input.style.display = "block";
            luffing_input.style.display = "block";
            length01.style.width = '100%'; // Debug: Set width to ensure visibility
            length01.style.height = 'auto'; // Debug: Set height to ensure visibility
            setTimeout(() => {
                length01.style.display = "flex";
                length01.style.width = '';  // Reset width to auto or default
                length01.style.height = ''; // Reset height to auto or default
                console.log('Setting length01 to flex');
            }, 0);
            break;

            case "Telescopic Mobile Crane":
                case "All Terrain Mobile Crane":

                registration.style.display = "block";

                length01.style.display = "block";
                boom_input.style.display = "block";
                jib_input.style.display = "block";
                luffing_input.style.display = "block";
                length01.style.width = '100%'; // Debug: Set width to ensure visibility
                length01.style.height = 'auto'; // Debug: Set height to ensure visibility
                setTimeout(() => {
                    length01.style.display = "flex";
                    length01.style.width = '';  // Reset width to auto or default
                    length01.style.height = ''; // Reset height to auto or default
                    console.log('Setting length01 to flex');
                }, 0);
                break;
    


                case "Rough Terrain Crane":
                    reg_container.style.setProperty("display", "flex", "important");
                    reg_container.style.setProperty("width", "100%", "important");
        
                    length01.style.display = "block";
                    boom_input.style.display = "block";
                    jib_input.style.display = "block";
                    luffing_input.style.display = "block";
                    length01.style.width = '100%'; // Debug: Set width to ensure visibility
                    length01.style.height = 'auto'; // Debug: Set height to ensure visibility
                    setTimeout(() => {
                        length01.style.display = "flex";
                        length01.style.width = '';  // Reset width to auto or default
                        length01.style.height = ''; // Reset height to auto or default
                        // console.log('Setting length01 to flex');
                    }, 0);
                    break;
        

            case "Reach Stacker":
                reg_container.style.setProperty("display", "flex", "important");
                reg_container.style.setProperty("width", "100%", "important");
            break;

        case "Truck Mounted Articulated Boomlift":
        case "Truck Mounted Straight Boomlift":
            chassis_make_rental_outer.style.display = "flex";
            length01.style.display = "block";
            boom_input.style.display = "block";

            length01.style.width = '100%'; // Debug: Set width to ensure visibility
            length01.style.height = 'auto'; // Debug: Set height to ensure visibility
            setTimeout(() => {
                length01.style.display = "flex";
                length01.style.width = '';  // Reset width to auto or default
                length01.style.height = ''; // Reset height to auto or default
            }, 0);
            jib_input.style.display = "none";
            luffing_input.style.display = "none";
            boom_input.style.width = '100%';
            break;

        case "Dumper":
        case "Truck":
        case "Water Tanker":
        case "Low Bed":
        case "Semi Low Bed":
        case "Flatbed":
        case "Hydraulic Axle":
            chassis_make_rental_outer.style.display = "flex";
            registration.style.display = "flex";

            hmrsellfleet.style.display='none';
            kmrsellfleet.style.display='none';
            break;

        case "Transit Mixer":
            registration.style.display = "block";
            chassis_make_rental_outer.style.display = "flex";
            registration.style.width = '80%';
            break;

        case "Hydraulic Drilling Rig":
        case "Rotary Drilling Rig":
            kealy_length.style.display = "block";
            break;

        case "Moli Pump":
            chassis_make_rental_outer.style.display = "flex";
            registration.style.display = "block";
            pipelength.style.display = "block";
            break;

        case "Shotcrete Machine":
            registration.style.display = "block";
            break;

        case "Self Loading Truck Crane":
            chassis_make_rental_outer.style.display = "flex";
            reg_container.style.setProperty("display", "flex", "important");
            reg_container.style.setProperty("width", "100%", "important");

            break;


            case "Concrete Boom Placer":
                // Logic for "Concrete Boom Placer"
                chassis_make_rental_outer.style.display = "flex";
                length01.style.display = "block";
                boom_input.style.display = "block";
            
                length01.style.width = '100%'; // Debug: Set width to ensure visibility
                length01.style.height = 'auto'; // Debug: Set height to ensure visibility
                setTimeout(() => {
                    length01.style.display = "flex";
                    length01.style.width = '';  // Reset width to auto or default
                    length01.style.height = ''; // Reset height to auto or default
                }, 0);
                jib_input.style.display = "none";
                luffing_input.style.display = "none";
                boom_input.style.width = '100%';
            
                // Additional logic for "Concrete Boom Placer"
                registration.style.display = "block";
                break;
            
            case "Self Propelled Articulated Boomlift":
            case "Self Propelled Straight Boomlift":
                // Shared logic for these cases
                reg_container.style.setProperty("display", "flex", "important");
                reg_container.style.setProperty("width", "100%", "important");
    
                chassis_make_rental_outer.style.display = "flex";
                length01.style.display = "block";
                boom_input.style.display = "block";
            
                length01.style.width = '100%'; // Debug: Set width to ensure visibility
                length01.style.height = 'auto'; // Debug: Set height to ensure visibility
                setTimeout(() => {
                    length01.style.display = "flex";
                    length01.style.width = '';  // Reset width to auto or default
                    length01.style.height = ''; // Reset height to auto or default
                }, 0);
                jib_input.style.display = "none";
                luffing_input.style.display = "none";
                boom_input.style.width = '100%';
                break;

        case "Static Boom Placer":
            length01.style.display = "block";
            boom_input.style.display = "block";

            length01.style.width = '100%'; // Debug: Set width to ensure visibility
            length01.style.height = 'auto'; // Debug: Set height to ensure visibility
            setTimeout(() => {
                length01.style.display = "flex";
                length01.style.width = '';  // Reset width to auto or default
                length01.style.height = ''; // Reset height to auto or default
            }, 0);
            jib_input.style.display = "none";
            luffing_input.style.display = "none";
            boom_input.style.width = '100%';
            break;

        case "Telehandler":
            reg_container.style.setProperty("display", "flex", "important");
            reg_container.style.setProperty("width", "100%", "important");
            
            length01.style.display = "block";
            boom_input.style.display = "block";

            length01.style.width = '100%'; // Debug: Set width to ensure visibility
            length01.style.height = 'auto'; // Debug: Set height to ensure visibility
            setTimeout(() => {
                length01.style.display = "flex";
                length01.style.width = '';  // Reset width to auto or default
                length01.style.height = ''; // Reset height to auto or default
            }, 0);
            jib_input.style.display = "none";
            luffing_input.style.display = "none";
            boom_input.style.width = '100%';
            break;

        case "Backhoe Loader":
        case "Motor Grader":
        case "Motor Grader":
        case "Wheeled Loader":
        case "Wheeled Excavator":
            reg_container.style.setProperty("display", "flex", "important");
            reg_container.style.setProperty("width", "100%", "important");
            break;



        case "Fork Lift Diesel":
        case "Fork Lift Electric":
        case "Scissor Lift Diesel":
        case "Scissor Lift Electric":
        case "Spider Lift":
            forklift_height.style.display = "block";
            break;

        case "Batching Plant":
            silos_container.style.display = "flex";
            silos_qty_container.style.display = "flex";
            break;


            case "Mobile Batching Plant":
                reg_container.style.setProperty("display", "flex", "important");
                reg_container.style.setProperty("width", "100%", "important");
                silos_container.style.display = "flex";
                silos_qty_container.style.display = "flex";
                break;
    

        case "Fixed Tower Crane":
        case "Hammerhead Tower Crane":
        case "Luffing Jib Tower Crane":
            length01.style.display = "block";
            length01.style.width = '100%'; // Debug: Set width to ensure visibility
            length01.style.height = 'auto'; // Debug: Set height to ensure visibility
            setTimeout(() => {
                length01.style.display = "flex";
                length01.style.width = '';  // Reset width to auto or default
                length01.style.height = ''; // Reset height to auto or default
            }, 0);
            jib_input.style.display = "block";
            boom_input.style.display = "none";
            luffing_input.style.display = "none";
            jib_input.style.width = '100%';
            tower_crane.style.display = "flex";
            break;

        default:
            elementsToHide.forEach(el => el.style.display = 'none');
            elementsToShow.forEach(el => el.style.display = 'block');
            break;
    }
}


function crawler_subtype(){
    const select_fleet_Type=document.getElementById("sub_type_oemaddfleet");
    // const jib_boom=document.getElementById("oem_addfleet_jib");
    const boom_oem=document.getElementById("boomlength_oem");
    const jib_oem=document.getElementById("jiblength_oem");
    const luffing_oem=document.getElementById("luffinglength_oem")

    if(select_fleet_Type.value==="Hydraulic Crawler Crane" || select_fleet_Type.value==="Mechanical Crawler Crane" || select_fleet_Type.value==="Telescopic Crawler Crane" ){
        boom_oem.style.display="block";
        jib_oem.style.display="block";
        luffing_oem.style.display="block";
    }
    else{
        boom_oem.style.display="none ";
        jib_oem.style.display="none";
        luffing_oem.style.display="none";
    }
}



function oemchassis_01(){
    const chassis_make= document.getElementById("chassis_make_oem");
    const specify_other=document.getElementById("specify_other_chassis_oem")
    if(chassis_make.value==="Other"){
        specify_other.style.display="block";
    }
    else{
        specify_other.style.display="none";
    }
}

function rental_addfleet1(){
    const make = document.getElementById("crane_make_retnal1");
    const textbox010 = document.getElementById("othermake012");

    if(make.value==="Others"){
        textbox010.style.display="block";
    }
    else{
        textbox010.style.display="none";
    }
}



function crane_fullspecs_feetmake(){
    const full_specs_make=document.getElementById("crane_fullspeccs_fleet_make");
    const full_specs_other_brand=document.getElementById("crane_full_specs_other_brand");
    if( full_specs_make.value==="Others"){
        full_specs_other_brand.style.display="block";
    }
    else{
        full_specs_other_brand.style.display="none";

    }
}



function idlefunction(){
const status=document.getElementById("operator_status");
    const driving_asset=document.getElementById("asset_code");
    if(status.value ==="working"){
        driving_asset.style.display="block";
    }
   else{
    driving_asset.style.display='none';
   }
}

function crawler_subtype_sellfleet(){
    const select_fleet_Type=document.getElementById("sub_type_oemaddfleet");
    // const jib_boom=document.getElementById("oem_addfleet_jib");
    const boom_oem=document.getElementById("boomlength_oem");
    const jib_oem=document.getElementById("jiblength_oem");
    const luffing_oem=document.getElementById("luffinglength_oem")

    if(select_fleet_Type.value==="Hydraulic Crawler Crane" || select_fleet_Type.value==="Mechanical Crawler Crane" || select_fleet_Type.value==="Telescopic Crawler Crane" ){
        boom_oem.style.display="block";
        jib_oem.style.display="block";
        luffing_oem.style.display="block";
    }
    else{
        boom_oem.style.display="none ";
        jib_oem.style.display="none";
        luffing_oem.style.display="none";
    }
}

function new_page(){
    dd_change=document.getElementById("rmc_type_dd")
    if(dd_change.value==="Dedicated RMC"){
        window.location.href="dedicatedrmc_req.php"
    }
}

function first_plus_click(){
    firstplus=document.getElementById("first_plus").style.display='none';
    second_div=document.getElementById("second_particular").style.display='block';

}

function second_plus_click(){
    second_plus=document.getElementById("second_plus").style.display="none";
    third_div=document.getElementById("third_particular").style.display="block";
}

function third_plus_click(){
    third_plus=document.getElementById("third_plus").style.display='none';
    fourth_particular=document.getElementById("fourth_particular").style.display='block';
}

function fourth_click(){
    fourth_plus=document.getElementById("fourth_plus").style.display="none";
    fifth_particular=document.getElementById("fifth_particular").style.display="block";
}

function back_to_old_page(){
    dd_change1=document.getElementById("rmc_type_dd_dedicated")
    if(dd_change1.value==="Commercial RMC"){
        window.location.href="epc_rmc_req.php"
    }
}
function first_plus_dedicated_click(){
    first_plus_dedicated1=document.getElementById('first_plus_dedicated').style.display='none';
    second_particular_dedicated=document.getElementById("second_particular_dedicated").style.display='block';
}
function second_plus_dedicated_click(){
    second_plus_dedicated=document.getElementById('second_plus_dedicated').style.display='none';
    third_particular_dedicated=document.getElementById('third_particular_dedicated').style.display='block';
}

function third_plus_dedicated_click(){
    third_plus_dedicated=document.getElementById("third_plus_dedicated").style.display='none';
    fourth_particular_dedicated=document.getElementById("fourth_particular_dedicated").style.display='block';
}
function fourth_plus_dedicated_click(){
    fourth_plus_dedicated=document.getElementById("fourth_plus_dedicated").style.display='none';
    fifth_particular_dedicated=document.getElementById("fifth_particular_dedicated").style.display='block';
}

function dd_hide1(){
    const pouring_equip=document.getElementById("pouring_equip");
    const no_of_equipment_required=document.getElementById("no_of_equipment_required");
    if (pouring_equip.value==='Concrete Pump' ||pouring_equip.value==='Boomplacer' ){
        no_of_equipment_required.style.display='block';
    }
    else{
        no_of_equipment_required.style.display='none';
    }
}

function dd_hide1_dedicated(){
    const pouring_equip_dedicated=document.getElementById("pouring_equip_dedicated");
    const no_of_equipment_required_dedicated=document.getElementById("no_of_equipment_required_dedicated");
    if(pouring_equip_dedicated.value==='Concrete Pump' ||pouring_equip_dedicated.value==='Boomplacer'  ){
        no_of_equipment_required_dedicated.style.display='block';
    }
    else{
        no_of_equipment_required_dedicated.style.display='none';
    }
}

function companywebsite(){
    const drop=document.getElementById("company_web_drop_down")
    const specify_comp_web=document.getElementById("specify_comp_web");
if(drop.value==="yes"){
    specify_comp_web.style.display="block";
}
else{
    specify_comp_web.style.display="none"
}
}

function rental_addon(){
    const enterprise_classified=document.getElementById('enterprise_options');
    const addonservices=document.getElementById("addonservices");
    {
        if( enterprise_classified.value==='rental' ){
            addonservices.style.display='block';
        }
        else{
            addonservices.style.display='none';
        }
    }
}

function insentive(){
    const insentive_dd=document.getElementById("insentive_dd");
    const minimum_target=document.getElementById("minimum_target");
    if(insentive_dd.value==='Yes'){
minimum_target.style.display='block'
    }
    else{
        minimum_target.style.display='none';
    }
}

function website_input(){
    const compweb=document.getElementById("company_web_drop_down")
    const yes_web=document.getElementById("enter_website");
    if (compweb.value==="yes"){
        yes_web.style.display="block";
    }
    else{
        yes_web.style.display="none";
    }
}

function enterprise_classified_as(){
    const ent_type=document.getElementById("enterprise_type");
    const service=document.getElementById("services");
    if (ent_type.value==='rental'){
        service.style.display='block';
    }
    else{
        service.style.display='none';
    }
}

function addon1(){
    const svrc=document.getElementById("services2")
    const rmc_type=document.getElementById("rmc_subtype");
    if(svrc.value==='RMC Plant' || svrc.value==='RMC Plant And Foundation Work' ){
        rmc_type.style.display="block";

    }
    else{
        rmc_type.style.display='none';
    }
}

function dedicated_rmc(){
    const rmc_subtype1=document.getElementById("rmc_subtype1");
    const loca=document.getElementById("dedicated_rmc_location")
    if(rmc_subtype1.value==="Dedicated"){
        loca.style.display="block";
    }
    else{
        loca.style.display='none';  
    }
}
function webdd_signin(){
    const web_present=document.getElementById("web_present");
    const web_add_company=document.getElementById("web_add_company");
    if(web_present.value==='Yes'){
        web_add_company.style.display='block';
    }
    else{
        web_add_company.style.display='none';
    }
}
function service_Addon(){
    const info=document.getElementById("_info");
    const rmc_Type=document.getElementById("rmc_Type");
    if (info.value==='RMC Plant' || info.value==='RMC Plant And Foundation Work'){
        rmc_Type.style.display='block';
    }
    else{
        rmc_Type.style.display='none';
    }
}

function ent_type(){
    const ent_Type_=document.getElementById("ent_Type_");
    const Info_Outer=document.getElementById("Info_Outer");
    if(ent_Type_.value==='rental'){
        Info_Outer.style.display="block";
    }
    else{
        Info_Outer.style.display='none';
    }


}

function Rmc_Location(){
    const rmc_Type=document.getElementById("rmc_Type");
    const Rmc_loca_outer=document.getElementById("Rmc_loca_outer");
    const Rmc_loca_outer2=document.getElementById("Rmc_loca_outer2");
    if(rmc_Type.value==='Commercial'){
        Rmc_loca_outer.style.display='block';
        Rmc_loca_outer2.style.display='block';

    }
    else{
        Rmc_loca_outer.style.display='none';
        Rmc_loca_outer2.style.display='none';
    }
}

function Get_asset_Detail() {
    const val = document.getElementById("bill_ac").value;
    console.log("Selected value:", val);
    window.location = "ac_redirection.php?id=" + encodeURIComponent(val);
}
function add_other_expense(){
    const first_expense_btn=document.getElementById("first_expense_btn");
    const expn_desc1=document.getElementById("expn_desc1");
    const cost1=document.getElementById("cost1");
    const second_expense_btn=document.getElementById("second_expense_btn");

    first_expense_btn.style.display="none";

    expn_desc1.style.display="block";
    cost1.style.display="block";
    second_expense_btn.style.display="block";
}
function add_other_Expense2(){
    document.getElementById("second_expense_btn").style.display="none";
    document.getElementById("expn_desc2").style.display="block";
    document.getElementById("cost2").style.display="block";
}
function open_req_grpinner(id) {
    window.location = "price_recieved_group.php?id=" + id;
}

function sell_icon(){
    document.getElementById("sellfleeticon").style.display="none";
    document.getElementById("pic4").style.display="block";
    document.getElementById("pic5").style.display="block";
  }

  function choose_new_equ(){
    const ac_dd=document.getElementById("assetcode");
    const new_equip=document.getElementById("new_equip");
    const newfleet_makemodel=document.getElementById("newfleet_makemodel");
    const newfleet_capinfo=document.getElementById("newfleet_capinfo");
    const newfleet_jib=document.getElementById("newfleet_jib");
    const prefetch = document.getElementById("prefetch");

    if(ac_dd.value==="New Equipment"){
        new_equip.style.display = "block"; // Set display to block initially
        new_equip.style.display = "flex"; // Change to flex after initial display
        new_equip.style.alignItems = "center";
        newfleet_makemodel.style.display="block";
        newfleet_makemodel.style.display="flex";
        newfleet_makemodel.style.alignItems="center";

        newfleet_capinfo.style.display="block";
        newfleet_capinfo.style.display="flex";
        newfleet_capinfo.style.alignItems="center";

        newfleet_jib.style.display="block";
        newfleet_jib.style.display="flex";
        newfleet_jib.style.alignItems="center";

        prefetch.style.display = 'none';


    }
    else{
        new_equip.style.display="none";
        newfleet_makemodel.style.display="none";
        newfleet_capinfo.style.display="none";
        newfleet_jib.style.display="none";

        prefetch.style.display = 'block';
        prefetch.style.display = 'flex';

        prefetch.style.flexDirection = 'column'; 
        prefetch.style.alignItems = 'center';

    }
}
 
//   function editchoosenewequipment(){
//     const ac_dd=document.getElementById("assetcode");
//     const new_equip=document.getElementById("new_equip");
//     const newfleet_makemodel=document.getElementById("newfleet_makemodel");
//     const newfleet_capinfo=document.getElementById("newfleet_capinfo");
//     const newfleet_jib=document.getElementById("newfleet_jib");
//     const prefetch = document.getElementById("newprefetch");

//     if(ac_dd.value==="New Equipment"){
//         new_equip.style.display = "block"; // Set display to block initially
//         new_equip.style.display = "flex"; // Change to flex after initial display
//         new_equip.style.alignItems = "center";
//         newfleet_makemodel.style.display="block";
//         newfleet_makemodel.style.display="flex";
//         newfleet_makemodel.style.alignItems="center";

//         newfleet_capinfo.style.display="block";
//         newfleet_capinfo.style.display="flex";
//         newfleet_capinfo.style.alignItems="center";

//         newfleet_jib.style.display="block";
//         newfleet_jib.style.display="flex";
//         newfleet_jib.style.alignItems="center";

//         prefetch.style.display = 'none';


//     }
//     else{
//         new_equip.style.display="none";
//         newfleet_makemodel.style.display="none";
//         newfleet_capinfo.style.display="none";
//         newfleet_jib.style.display="none";

//         prefetch.style.display = 'block';
//         prefetch.style.display = 'flex';

//         prefetch.style.flexDirection = 'column'; 
//         prefetch.style.alignItems = 'center';

//     }
// }
 
function scroll_to_service()
{
    var section = document.getElementById('service_section_content');
    if (section) {
        var offset = section.offsetTop - 100; // Calculate scroll offset with margin of 200px
        window.scrollTo({
            top: offset,
            behavior: 'smooth' // Smooth scrolling behavior
        });
    }
}
function scroll_to_aboutus()
{
    var section = document.getElementById('abtus_content');
    if (section) {
        var offset = section.offsetTop - 100; // Calculate scroll offset with margin of 200px
        window.scrollTo({
            top: offset,
            behavior: 'smooth' // Smooth scrolling behavior
        });
    }
}
function scroll_to_contactus()
{
    var section = document.getElementById('footer_content');
    if (section) {
        var offset = section.offsetTop - 100; // Calculate scroll offset with margin of 200px
        window.scrollTo({
            top: offset,
            behavior: 'smooth' // Smooth scrolling behavior
        });
    }
}

function addfleetnew(){
    document.getElementById("newfleet_btn_add").style.display="block";
}
function view_op_screen(){
    document.getElementById("addop_new").style.display="block";
}
function shift_hour() {
    const select_shift = document.getElementById("select_shift");
    const single_Shift_hour = document.getElementById("single_Shift_hour");
    const othershift_enginehour = document.getElementById("othershift_enginehour");

    if (select_shift.value === 'Single Shift') {
        single_Shift_hour.style.display = 'block';
        othershift_enginehour.style.display = 'none'; // Hide the other shift hour input if it's visible
    } else if (select_shift.value === 'Double Shift' || select_shift.value === 'Flexi Shift') {
        othershift_enginehour.style.display = 'block';
        single_Shift_hour.style.display = 'none'; // Hide the single shift hour input if it's visible
    } else {
        single_Shift_hour.style.display = 'none';
        othershift_enginehour.style.display = 'none';
    }
}
function other_quotation(){
    document.getElementById("new_out1").style.display='block'
    document.getElementById("second_addequipbtn").style.display='none'
    document.getElementById("new_out1").style.display='flex'
    document.getElementById("new_out1").style.flexDirection='column'
    document.getElementById("new_out1").style.alignItems='center'
    document.getElementById("new_out1").style.justifyContent='center'
}
function addanother_equip(){
    document.getElementById("new_out2").style.display='block'
    document.getElementById("lastaddequipbtn").style.display='none'
    document.getElementById("new_out2").style.display='flex'
    document.getElementById("new_out2").style.flexDirection='column'
    document.getElementById("new_out2").style.alignItems='center'
}
function quoteforthirdvehicle(){
    const ac_dd3=document.getElementById("choose_Ac3");
    const new_equip3=document.getElementById("new_equip3");
    const newfleet_makemodel3=document.getElementById("newfleet_makemodel3");
    const newfleet_capinfo3=document.getElementById("newfleet_capinfo3");
    const newfleet_jib3=document.getElementById("newfleet_jib3");
    if(ac_dd3.value==="New Equipment"){
        new_equip3.style.display = "block"; // Set display to block initially
        new_equip3.style.display = "flex"; // Change to flex after initial display
        new_equip3.style.alignItems = "center";
        newfleet_makemodel3.style.display="block";
        newfleet_makemodel3.style.display="flex";
        newfleet_makemodel3.style.alignItems="center";

        newfleet_capinfo3.style.display="block";
        newfleet_capinfo3.style.display="flex";
        newfleet_capinfo3.style.alignItems="center";

        newfleet_jib3.style.display="block";
        newfleet_jib3.style.display="flex";
        newfleet_jib3.style.alignItems="center";

    }
    else{
        new_equip3.style.display="none";
        newfleet_makemodel3.style.display="none";
        newfleet_capinfo3.style.display="none";
        newfleet_jib3.style.display="none";
    }
}
function cancelsecondequipment(){
    const second_addequipbtn=document.getElementById("second_addequipbtn");
    const container_secondequipment=document.getElementById("new_out1");

    container_secondequipment.style.display='none';
    second_addequipbtn.style.display='block';
    second_addequipbtn.style.display='flex';
}
function cancelthirdequipment(){
    const third_addequipbtn=document.getElementById("third_addequipbtn");
    const thirdvehicledetail=document.getElementById("thirdvehicledetail");

    thirdvehicledetail.style.display='none';
    third_addequipbtn.style.display='flex';
}
function third_vehicle(){
    const thirdvehicledetail=document.getElementById("thirdvehicledetail");
    const third_addequipbtn=document.getElementById("third_addequipbtn");
    thirdvehicledetail.style.display="flex";
    third_addequipbtn.style.display="none";

}

function cancelfourthequipment(){
    const fourth_addequipbtn=document.getElementById("fourth_addequipbtn");
    const fouthvehicledata=document.getElementById("fouthvehicledata");

    fouthvehicledata.style.display='none';
    fourth_addequipbtn.style.display='flex';
}
function cancelfifthequipment(){
    const fifth_addequipbtn=document.getElementById("fifth_addequipbtn");
    const fifthvehicledata=document.getElementById("fifthvehicledata");

    fifthvehicledata.style.display='none';
    fifth_addequipbtn.style.display='flex';
}
function not_immediate3(){
    const availability_dd3=document.getElementById("availability_dd3");
    const date_of_availability3=document.getElementById("date_of_availability3");
    if(availability_dd3.value==="Not Immediate"){
       date_of_availability3.style.display="block"
    }
    else{
       date_of_availability3.style.display="none";
    }
       }
   
function not_immediate2(){
    const availability_dd2=document.getElementById("availability_dd2");
    const date_of_availability2=document.getElementById("date_of_availability2");
    if(availability_dd2.value==="Not Immediate"){
       date_of_availability2.style.display="block"
    }
    else{
       date_of_availability2.style.display="none";
    }
       }
function not_immediate3(){
    const availability_dd3=document.getElementById("availability_dd3");
    const date_of_availability3=document.getElementById("date_of_availability3");
    if(availability_dd3.value==="Not Immediate"){
       date_of_availability3.style.display="block"
    }
    else{
       date_of_availability3.style.display="none";
    }
       }

function not_immediate4(){
    const availability_dd4=document.getElementById("availability_dd4");
    const date_of_availability4=document.getElementById("date_of_availability4");
    if(availability_dd4.value==="Not Immediate"){
       date_of_availability4.style.display="block"
    }
    else{
       date_of_availability4.style.display="none";
    }
       }

function not_immediate5(){
    const availability_dd5=document.getElementById("availability_dd5");
    const date_of_availability5=document.getElementById("date_of_availability5");
    if(availability_dd5.value==="Not Immediate"){
       date_of_availability5.style.display="block"
    }
    else{
       date_of_availability5.style.display="none";
    }
       }

       function choose_new_equ2() {
        const choose_Ac2 = document.getElementById("choose_Ac2"); // Corrected ID to match the select element
        const newequipdet1new = document.getElementById("newequipdet1");
        const prefetch_second=document.getElementById("prefetch_second");
    
        if (choose_Ac2.value === 'New Equipment') {
            newequipdet1new.style.display = 'block';
            newequipdet1new.style.display = 'flex';
            newequipdet1new.style.flexDirection = 'column'; 
            newequipdet1new.style.alignItems = 'center';
            newequipdet1new.style.justifyContent = 'center';
            prefetch_second.style.display='none'
        } else {
            newequipdet1new.style.display = 'none'; 
            prefetch_second.style.display = 'block';
            prefetch_second.style.display = 'flex';

            prefetch_second.style.flexDirection = 'column'; 
            prefetch_second.style.alignItems = 'center';
            prefetch_second.style.justifyContent = 'center';
        }
    }
           
       function choose_new_equ_third() {
        const choose_Ac2 = document.getElementById("choose_Ac3"); // Corrected ID to match the select element
        const newequipdet1new = document.getElementById("newequipdet3");
        const prefetch_second=document.getElementById("prefetch_third");
    
        if (choose_Ac2.value === 'New Equipment') {
            newequipdet1new.style.display = 'flex';
            newequipdet1new.style.flexDirection = 'column'; 
            newequipdet1new.style.alignItems = 'center';
            newequipdet1new.style.justifyContent = 'center';
            prefetch_second.style.display='none'
        } else {
            newequipdet1new.style.display = 'none'; 
            prefetch_second.style.display = 'block';
            prefetch_second.style.display = 'flex';

            prefetch_second.style.flexDirection = 'column'; 
            prefetch_second.style.alignItems = 'center';
            prefetch_second.style.justifyContent = 'center';
        }
    }
           
       function choose_new_equ_fourth() {
        const choose_Ac2 = document.getElementById("choose_Ac4"); // Corrected ID to match the select element
        const newequipdet1new = document.getElementById("newequipdet4");
        const prefetch_second=document.getElementById("prefetch_fourth");
    
        if (choose_Ac2.value === 'New Equipment') {
            newequipdet1new.style.display = 'block';
            newequipdet1new.style.display = 'flex';
            newequipdet1new.style.flexDirection = 'column'; 
            newequipdet1new.style.alignItems = 'center';
            newequipdet1new.style.justifyContent = 'center';
            prefetch_second.style.display='none'
        } else {
            newequipdet1new.style.display = 'none'; 
            prefetch_second.style.display = 'block';
            prefetch_second.style.display = 'flex';

            prefetch_second.style.flexDirection = 'column'; 
            prefetch_second.style.alignItems = 'center';
            prefetch_second.style.justifyContent = 'center';
        }
    }
           
       function choose_new_equ_fifth() {
        const choose_Ac2 = document.getElementById("choose_Ac5"); // Corrected ID to match the select element
        const newequipdet1new = document.getElementById("newequipdet5");
        const prefetch_second=document.getElementById("prefetch_fifth");
    
        if (choose_Ac2.value === 'New Equipment') {
            newequipdet1new.style.display = 'block';
            newequipdet1new.style.display = 'flex';
            newequipdet1new.style.flexDirection = 'column'; 
            newequipdet1new.style.alignItems = 'center';
            newequipdet1new.style.justifyContent = 'center';
            prefetch_second.style.display='none'
        } else {
            newequipdet1new.style.display = 'none'; 
            prefetch_second.style.display = 'block';
            prefetch_second.style.display = 'flex';

            prefetch_second.style.flexDirection = 'column'; 
            prefetch_second.style.alignItems = 'center';
            prefetch_second.style.justifyContent = 'center';
        }
    }
           
   function choose_new_equ3(){
    const choose_Ac2=document.getElementById("choose_Ac7");
    const newequipdet1=document.getElementById("newequipdet7");
    if (choose_Ac2.value==='New Equipment'){
        newequipdet1.style.display='block';
        newequipdet1.style.display='flex';
        newequipdet1.style.flexDirection='column';
        newequipdet1.style.alignItems='center';
    }
    else{
        newequipdet1.style.display='none';
 
    }
   }
   function client_nameadd() {
    const workorder = document.getElementById("workorder_DROPDOWN");
    const outerclient12 = document.getElementById("outerclient1");
    
    if (workorder.value === 'yes') {
        outerclient12.style.display = "block";
        outerclient12.style.display = "flex";
        outerclient12.style.alignItems = "center";
        outerclient12.style.justifyContent = "center";
        outerclient12.style.flexDirection = "column";
    } else {
        outerclient12.style.display = "none";
    }
}
function toggleModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = (modal.style.display === 'block') ? 'none' : 'block';
    } else {
        console.error("Modal with ID " + modalId + " not found.");
    }
}
function status_change() {
    const status_dd = document.getElementById("status_dd");
    const enquiry_closed_dd = document.getElementById("enquiry_closed_dd");
    const lost_to_ = document.getElementById("lost_to_");
    const regretted_reason_ = document.getElementById("regretted_reason_");

    if (status_dd.value === 'Inquiry Closed') {
        enquiry_closed_dd.style.display = 'block';
        lost_to_.style.display = 'none';  // Hide other sections
        regretted_reason_.style.display = 'none';
    } else if (status_dd.value === 'Lost') {
        lost_to_.style.display = 'block';
        enquiry_closed_dd.style.display = 'none';  // Hide other sections
        regretted_reason_.style.display = 'none';
    } else if (status_dd.value === 'Regretted') {
        regretted_reason_.style.display = 'block';
        enquiry_closed_dd.style.display = 'none';  // Hide other sections
        lost_to_.style.display = 'none';
    } else {
        enquiry_closed_dd.style.display = 'none';
        lost_to_.style.display = 'none';
        regretted_reason_.style.display = 'none';
    }
}
function enquiry_info(){
  const enquiry_reason=document.getElementById("enquiry_reason");
  const postponed_to_=document.getElementById("postponed_to_");
  if(enquiry_reason.value=== 'Requirement Postponed'){
    postponed_to_.style.display='block';
  }
  else{
    postponed_to_.style.display='none';
  }
}
function goBack() {
    window.location.href = "generate_quotation_landingpage.php";
}
function purchase_option() {
    const bedlengthdiv = document.getElementById("bedlengthdiv");

const options = document.getElementsByClassName('awp_options');
const options1 = document.getElementsByClassName('cq_options');
const options2 = document.getElementsByClassName('earthmover_options');
const options3 = document.getElementsByClassName('mhe_options');
const options4 = document.getElementsByClassName('gee_options');
const options5 = document.getElementsByClassName('trailor_options');
const options6 = document.getElementsByClassName('generator_options');

const first_select = document.getElementById('oem_fleet_type');
const reg_container = document.getElementById('reg_container');
const chassis_make_rental = document.getElementById('chassis_make_rental_outer');

// Set the display style for all elements at once
const displayStyle = (first_select.value === "Aerial Work Platform") ? "block" : "none";
Array.from(options).forEach(option => option.style.display = displayStyle);

const displayStyle1 = (first_select.value === "Concrete Equipment") ? "block" : "none";
Array.from(options1).forEach(option => option.style.display = displayStyle1);

const displayStyle2 = (first_select.value === "EarthMovers and Road Equipments") ? "block" : "none";
Array.from(options2).forEach(option => option.style.display = displayStyle2);

const displayStyle3 = (first_select.value === "Material Handling Equipments") ? "block" : "none";
Array.from(options3).forEach(option => option.style.display = displayStyle3);

const displayStyle4 = (first_select.value === "Ground Engineering Equipments") ? "block" : "none";
Array.from(options4).forEach(option => option.style.display = displayStyle4);

const displayStyle5 = (first_select.value === "Trailor and Truck") ? "block" : "none";
Array.from(options5).forEach(option => option.style.display = displayStyle5);

const displayStyle6 = (first_select.value === "Generator and Lighting") ? "block" : "none";
Array.from(options6).forEach(option => option.style.display = displayStyle6);

if(first_select.value==='Aerial Work Platform'){
reg_container.style.display='block';
reg_container.style.display='flex';
reg_container.style.width='100%';
chassis_make_rental.style.display='none';
}
else if(first_select.value ==='Trailor and Truck'){
bedlengthdiv.style.display="flex";

}

else{
reg_container.style.display='none';
bedlengthdiv.style.display="none";

}

}
function secondtrailor() {
    const firstadd = document.getElementById("firstadd");
    const seconddatacontainer = document.getElementById("seconddatacontainer");

    // Hide the first element
    firstadd.style.display = 'none';

    // Show the second element with flex display
    seconddatacontainer.style.display = 'flex';
}

function addAnotherEquipment(){
    const secondadd = document.getElementById("secondadd");
    const thirdvehcile_quotation = document.getElementById("thirdvehcile_quotation");

    secondadd.style.display= 'none';
    thirdvehcile_quotation.style.display= 'flex';



}
function fourthequipment(){
    const fouthadd = document.getElementById("fouthadd");
    const fourthequipmentcontainer = document.getElementById("fourthequipmentcontainer");

    fouthadd.style.display= 'none';
    fourthequipmentcontainer.style.display= 'flex';



}

function third_equipment() {
    const options3 = document.getElementsByClassName('awp_options3');
    const cp_options3 = document.getElementsByClassName('cq_options3');
    const earth_option3 = document.getElementsByClassName('earthmover_options3');
    const mhe_options3 = document.getElementsByClassName('mhe_options3');
    const gee_options = document.getElementsByClassName('gee_options3');
    const trailor_option3 = document.getElementsByClassName('trailor_options3');
    const generator_option3 = document.getElementsByClassName('generator_options3');

    const first_select3 = document.getElementById('oem_fleet_type3');

    // Set the display style for all elements at once
    const display001 = (first_select3.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = display001);

    const display002 = (first_select3.value === "Concrete Equipment") ? "block" : "none";
    Array.from(cp_options3).forEach(option => option.style.display = display002);

    const display003 = (first_select3.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(earth_option3).forEach(option => option.style.display = display003);

    const display004 = (first_select3.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(mhe_options3).forEach(option => option.style.display = display004);

    const display005 = (first_select3.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(gee_options).forEach(option => option.style.display = display005);

    const display006 = (first_select3.value === "Trailor and Truck") ? "block" : "none";
    Array.from(trailor_option3).forEach(option => option.style.display = display006);

    const display007 = (first_select3.value === "Generator and Lighting") ? "block" : "none";
    Array.from(generator_option3).forEach(option => option.style.display = display007);


}


function fourth_equipment() {
    const options3 = document.getElementsByClassName('awp_options4');
    const cp_options3 = document.getElementsByClassName('cq_options4');
    const earth_option3 = document.getElementsByClassName('earthmover_options4');
    const mhe_options3 = document.getElementsByClassName('mhe_options4');
    const gee_options = document.getElementsByClassName('gee_options4');
    const trailor_option3 = document.getElementsByClassName('trailor_options4');
    const generator_option3 = document.getElementsByClassName('generator_options4');

    const first_select3 = document.getElementById('oem_fleet_type4');

    // Set the display style for all elements at once
    const display001 = (first_select3.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = display001);

    const display002 = (first_select3.value === "Concrete Equipment") ? "block" : "none";
    Array.from(cp_options3).forEach(option => option.style.display = display002);

    const display003 = (first_select3.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(earth_option3).forEach(option => option.style.display = display003);

    const display004 = (first_select3.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(mhe_options3).forEach(option => option.style.display = display004);

    const display005 = (first_select3.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(gee_options).forEach(option => option.style.display = display005);

    const display006 = (first_select3.value === "Trailor and Truck") ? "block" : "none";
    Array.from(trailor_option3).forEach(option => option.style.display = display006);

    const display007 = (first_select3.value === "Generator and Lighting") ? "block" : "none";
    Array.from(generator_option3).forEach(option => option.style.display = display007);


}
function fifth_equipment() {
    const options3 = document.getElementsByClassName('awp_options5');
    const cp_options3 = document.getElementsByClassName('cq_options5');
    const earth_option3 = document.getElementsByClassName('earthmover_options5');
    const mhe_options3 = document.getElementsByClassName('mhe_options5');
    const gee_options = document.getElementsByClassName('gee_options5');
    const trailor_option3 = document.getElementsByClassName('trailor_options5');
    const generator_option3 = document.getElementsByClassName('generator_options5');

    const first_select3 = document.getElementById('oem_fleet_type5');

    // Set the display style for all elements at once
    const display001 = (first_select3.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = display001);

    const display002 = (first_select3.value === "Concrete Equipment") ? "block" : "none";
    Array.from(cp_options3).forEach(option => option.style.display = display002);

    const display003 = (first_select3.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(earth_option3).forEach(option => option.style.display = display003);

    const display004 = (first_select3.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(mhe_options3).forEach(option => option.style.display = display004);

    const display005 = (first_select3.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(gee_options).forEach(option => option.style.display = display005);

    const display006 = (first_select3.value === "Trailor and Truck") ? "block" : "none";
    Array.from(trailor_option3).forEach(option => option.style.display = display006);

    const display007 = (first_select3.value === "Generator and Lighting") ? "block" : "none";
    Array.from(generator_option3).forEach(option => option.style.display = display007);


}
function thirdnewequipment(){
    const choose_Ac3=document.getElementById("choose_Ac3");
    const thirdnewequipmentdata=document.getElementById("thirdnewequipmentdata");
    const thirdequipmentprefill=document.getElementById("thirdequipmentprefill");

    if(choose_Ac3.value==='New Equipment'){
        thirdnewequipmentdata.style.display='flex';
        thirdequipmentprefill.style.display='none';

    }
    else{
        thirdnewequipmentdata.style.display='none';
        thirdequipmentprefill.style.display='flex';

    }

}
function thirdnewvehicle_options(){
        const options3 = document.getElementsByClassName('awp_options3');
        const options3a = document.getElementsByClassName('cq_options3');
        const options3b = document.getElementsByClassName('earthmover_options3');
        const options3c = document.getElementsByClassName('mhe_options3');
        const options3d = document.getElementsByClassName('gee_options3');
        const options3e = document.getElementsByClassName('trailor_options3');
        const options3f = document.getElementsByClassName('generator_options3');
    
        const first_select3 = document.getElementById('oem_fleet_type3');
    
        // Set the display style for all elements at once
        const displayStyle007 = (first_select3.value === "Aerial Work Platform") ? "block" : "none";
        Array.from(options3).forEach(option => option.style.display = displayStyle007);
    
        const displayStyle17 = (first_select3.value === "Concrete Equipment") ? "block" : "none";
        Array.from(options3a).forEach(option => option.style.display = displayStyle17);
    
        const displayStyle27 = (first_select3.value === "EarthMovers and Road Equipments") ? "block" : "none";
        Array.from(options3b).forEach(option => option.style.display = displayStyle27);
    
        const displayStyle37 = (first_select3.value === "Material Handling Equipments") ? "block" : "none";
        Array.from(options3c).forEach(option => option.style.display = displayStyle37);
    
        const displayStyle47 = (first_select3.value === "Ground Engineering Equipments") ? "block" : "none";
        Array.from(options3d).forEach(option => option.style.display = displayStyle47);
    
        const displayStyle57 = (first_select3.value === "Trailor and Truck") ? "block" : "none";
        Array.from(options3e).forEach(option => option.style.display = displayStyle57);
    
        const displayStyle67 = (first_select3.value === "Generator and Lighting") ? "block" : "none";
        Array.from(options3f).forEach(option => option.style.display = displayStyle67);
    
    
    
}

function roadtax_criteria(){
    const roadtaxselect=document.getElementById("roadtaxselect");
    const roadtaxcondition=document.getElementById("roadtaxcondition");

    if(roadtaxselect.value==='client'){
        roadtaxcondition.style.display='block';
    }
    else if(roadtaxselect.value==='rental company'){
        roadtaxcondition.style.display='none';
    }
    else{
        roadtaxcondition.style.value='none';
    }

}

function lumsum_amount(){
const roadtaxcondition=document.getElementById("roadtaxcondition");
const enterlumsumamount=document.getElementById("enterlumsumamount");
if(roadtaxcondition.value==='lumsum amount'){
    enterlumsumamount.style.display='flex';
}
else{
    enterlumsumamount.style.value='none';
}



}

function quotation_filter() {
    const quotationfilterdd = document.getElementById("quotationfilterdd");
    const quotationfilterdate = document.getElementById("quotationfilterdate");
    const clientfilter = document.getElementById("clientfilter");
    const statusfilter = document.getElementById("statusfilter");
    const acfilter = document.getElementById("acfilter");

    // Hide all filter inputs first
    quotationfilterdate.style.display = 'none';
    clientfilter.style.display = 'none';
    statusfilter.style.display = 'none';
    acfilter.style.display = 'none';

    // Show only the relevant filter input based on the selected option
    switch (quotationfilterdd.value) {
        case 'Date':
            quotationfilterdate.style.display = 'block';
            break;
        case 'Client':
            clientfilter.style.display = 'flex';
            break;
        case 'Status':
            statusfilter.style.display = 'flex';
            break;
        case 'Asset Code':
            acfilter.style.display = 'flex';
            break;
        default:
            // Optionally handle the case where no option or an invalid option is selected
            break;
    }
}

function advancefordd(){
    const advanceapplicable=document.getElementById("advanceapplicable");
    const advancefor=document.getElementById("advancefor");

    if (advanceapplicable.value==='Applicable'){
        advancefor.style.display='block';
    }
    else{
        advanceapplicable.style.display='none';
    }
}

function engine_hour_input(){
    const dd_menu=document.getElementById('working_shift_dd');
    const work=document.getElementById('engine_hour_dd');
    if(dd_menu.value==='Double' || dd_menu.value==='Flexi Single'){
        work.style.display='block';
    }
    else{
        work.style.display='none';
    }
}

function showclient(){
    const tasktypedd=document.getElementById("tasktypedd");
    const selectclient=document.getElementById("selectclient");
    if(tasktypedd.value==='Call'){
        selectclient.style.display='flex';
        selectclient.style.gap='8px';
    }
    else{
        selectclient.style.display='none';

    }
}
function enternewclient(){
    const fleeteipclientlist=document.getElementById("fleeteipclientlist");
    const newclientinput=document.getElementById("newclientinput");

    if(fleeteipclientlist.value==='Client Name Not In List'){
        newclientinput.style.display='block';
        newclientinput.setAttribute('required', 'required');
        newclientinput.style.display.width='100%';
        fleeteipclientlist.style.display='none';
    }
}
function addexpense(){
    const expenselogform=document.getElementById("expenselogform");
    const btncontaineraddexpense=document.getElementById("btncontaineraddexpense");
    expenselogform.style.display='flex';
    btncontaineraddexpense.style.display='none';


}
function expensefilter(){

    document.getElementById('expensetypeselect').selectedIndex = 0; // Reset expense type
    document.getElementById('initiatedbyselect').selectedIndex = 0; // Reset initiated by
    document.getElementById('approvedbyselect').selectedIndex = 0; // Reset approved by

    const expensefilterselection=document.getElementById("expensefilterselection");
    const expensetypeselect=document.getElementById("expensetypeselect");
    const initiatedbyselect=document.getElementById("initiatedbyselect");
    const approvedbyselect=document.getElementById("approvedbyselect");
    const startandenddate=document.getElementById("startandenddate");



    if(expensefilterselection.value==='Expense-Type'){
        expensetypeselect.style.display='flex';
        initiatedbyselect.style.display='none';
        approvedbyselect.style.display='none';
        startandenddate.style.display='none';



    }
    else if(expensefilterselection.value==='Initiated By'){
        initiatedbyselect.style.display='flex';
        expensetypeselect.style.display='none';
        approvedbyselect.style.display='none';
        startandenddate.style.display='none';


    }
    else if(expensefilterselection.value==='Date'){
        startandenddate.style.display='flex';
        initiatedbyselect.style.display='none';
        expensetypeselect.style.display='none';
        approvedbyselect.style.display='none';

    }
    else if(expensefilterselection.value==='Approved By'){
        approvedbyselect.style.display='flex';
        expensetypeselect.style.display='none';
        initiatedbyselect.style.display='none';
        startandenddate.style.display='none';


    
    }
    else{
        expensetypeselect.style.display='none';
        initiatedbyselect.style.display='none';
        approvedbyselect.style.display='none';
        startandenddate.style.display='none';




    }
}
function showcallreminderform(){
    const addcallreminderbutton=document.getElementById("addcallreminderbutton");
    const callreminderformrental=document.getElementById("callreminderformrental");

    callreminderformrental.style.display='flex';
    addcallreminderbutton.style.display='none';
}
function showmemberform(){
    const epcprojectcontactinfo=document.getElementById("epcprojectcontactinfo");
    const addprojectteammemberepc=document.getElementById("addprojectteammemberepc");

    epcprojectcontactinfo.style.display='flex';
    addprojectteammemberepc.style.display='none';

}
function projectinsightshift(){
    const projectinsightshiftdd=document.getElementById("projectinsightshiftdd");
    const projectinsightenginehour=document.getElementById("projectinsightenginehour");
    const projectinsightworkinghour=document.getElementById("projectinsightworkinghour");

    if(projectinsightshiftdd.value==='Single Shift'){
        projectinsightworkinghour.style.display='block';
        projectinsightenginehour.style.display='none';
    }

    if(projectinsightshiftdd.value==='Double Shift' || projectinsightshiftdd.value==='Flexi Shift'){
        projectinsightworkinghour.style.display='none';
        projectinsightenginehour.style.display='block';

    }

}
function showequipmentform(){
    document.getElementById("linkequipmentform").style.display='flex';
    document.getElementById("linkanequipmentbutton").style.display='none';

}

function newprjectentry(){
    const selectprojectcode=document.getElementById("selectprojectcode");
    const newproject=document.getElementById("newproject");
    if(selectprojectcode.value==='New Project'){
        newproject.style.display='block';
        selectprojectcode.style.display='none';
    }
    else{
        newproject.style.display='none';
        selectprojectcode.style.display='block';

    }
}
function showcw2() {
    document.getElementById("cw2").style.display = 'flex'; // Show the element with ID cw2
    document.getElementById("icon1").style.display = 'none'; // Hide the element with ID icon2
}
function showcw3() {
    document.getElementById("cw3").style.display = 'flex'; // Show the element with ID cw2
    document.getElementById("icon2").style.display = 'none'; // Hide the element with ID icon2
}
function showcw4() {
    document.getElementById("cw4").style.display = 'flex'; // Show the element with ID cw2
    document.getElementById("icon3").style.display = 'none'; // Hide the element with ID icon2
}
function showcw5() {
    document.getElementById("cw5").style.display = 'flex'; // Show the element with ID cw2
    document.getElementById("icon4").style.display = 'none'; // Hide the element with ID icon2
}
function showcw6() {
    document.getElementById("cw6").style.display = 'flex'; // Show the element with ID cw2
    document.getElementById("icon5").style.display = 'none'; // Hide the element with ID icon2
}
function showhb2(){
    document.getElementById("hb2").style.display= 'flex';
    document.getElementById("hbicon1").style.display= 'none';

}
function showhb3(){
    document.getElementById("hb3").style.display= 'flex';
    document.getElementById("hbicon2").style.display= 'none';

}
function showhb4(){
    document.getElementById("hb4").style.display= 'flex';
    document.getElementById("hbicon3").style.display= 'none';

}
function showhb5(){
    document.getElementById("hb5").style.display= 'flex';
    document.getElementById("hbicon4").style.display= 'none';

}
function showhb6(){
    document.getElementById("hb6").style.display= 'flex';
    document.getElementById("hbicon5").style.display= 'none';

}
function flyjibinputinfo(){
    const flyjib_availability=document.getElementById("flyjib_availability");
    const jibheadingcontent=document.getElementById("jibheadingcontent");

    if(flyjib_availability.value==='Yes'){
        jibheadingcontent.style.display='flex';
    }
    else{
        jibheadingcontent.style.display='none';

    }

}

function lufferinputinfo(){
    const luffer_availability=document.getElementById("luffer_availability");
    const lufferheadingcontent=document.getElementById("lufferheadingcontent");

    if(luffer_availability.value==='Yes'){
        lufferheadingcontent.style.display='flex';
    }
    else{
        lufferheadingcontent.style.display='none';

    }

}

function auctiontypefunction(){
    const auctiontypedd=document.getElementById("auctiontypedd");
    const maxpriceinput=document.getElementById("maxpriceinput");
    const basepriceinput=document.getElementById("basepriceinput");

    if(auctiontypedd.value==='Service'){
        maxpriceinput.style.display='block';
        basepriceinput.style.display='none';

    }
    else{
        maxpriceinput.style.display='none';
        basepriceinput.style.display='block';

    }

}

function equipmentsection() {
    // Select all required input, select, and textarea fields
    const requiredFields = document.querySelectorAll("input[required], select[required], textarea[required]");
    let isValid = true;

    requiredFields.forEach(field => {
        // Check if the parent div is visible
        if (field.closest("div")?.offsetParent !== null) {
            if (!field.value.trim()) {
                isValid = false;
                field.reportValidity(); // Show error message
                return; // Stop checking after the first invalid field
            }
        }
    });

    if (isValid) {
        // If all visible required fields are filled, move to the next section
        document.getElementById("equipmentinfosectioncontainer").style.display = "flex";
        document.getElementById("contactpersonsectioncontainer").style.display = "none";
    }
}

function backtocontactpersonsection(){
    const equipmentinfosectioncontainer=document.getElementById("equipmentinfosectioncontainer");
    const contactpersonsectioncontainer=document.getElementById("contactpersonsectioncontainer");

    equipmentinfosectioncontainer.style.display='none';
    contactpersonsectioncontainer.style.display='flex';


}

function termssection() {
    // Select all required input, select, and textarea fields
    const requiredFields = document.querySelectorAll("input[required], select[required], textarea[required]");
    let isValid = true;

    requiredFields.forEach(field => {
        // Check if the parent div is visible
        if (field.closest("div")?.offsetParent !== null) {
            if (!field.value.trim()) {
                isValid = false;
                field.reportValidity(); // Show error message
                return; // Stop checking after the first invalid field
            }
        }
    });

    if (isValid) {
        // If all visible required fields are filled, move to the next section
        document.getElementById("termssectioncontainer").style.display = "flex";
        document.getElementById("equipmentinfosectioncontainer").style.display = "none";
    }
}

function backtoequipementsection(){
    const equipmentinfosectioncontainer=document.getElementById("equipmentinfosectioncontainer");
    const termssectioncontainer=document.getElementById("termssectioncontainer");

    equipmentinfosectioncontainer.style.display='flex';
    termssectioncontainer.style.display='none';




}

function showcurrentenrollmentform(){
    const currentenrollmentform=document.getElementById("currentenrollmentform");
    currentenrollmentform.style.display='flex';
}
function pfdeduction(){
    const pfdeductionselect=document.getElementById("pfdeductionselect");
    const pfinputamount=document.getElementById("pfinputamount");

    const deductionamountinput=document.getElementById("deductionamountinput");

    if(pfdeductionselect.value==='Yes'){
        pfdeductionselect.style.display='none';
        deductionamountinput.style.display='block';
        pfinputamount.setAttribute('required', 'required');
    }

    else{
        deductionamountinput.style.display='none';
        pfinputamount.removeAttribute('required'); 

    }
}
function esisselect(){
    const esisdd=document.getElementById("esisdd");
    const esisamnt=document.getElementById("esisamnt");
    const esisdeductionamountinput=document.getElementById("esisdeductionamountinput");

    if(esisdd.value==='Yes'){
        esisdd.style.display='none';
        esisdeductionamountinput.style.display='block';
        esisamnt.setAttribute('required', 'required');




    }
    else{
        esisdeductionamountinput.style.display='none';
        esisamnt.removeAttribute('required'); 

    }

}

function newteammemberoffer(){
    
    const sendernameofferletter=document.getElementById("sendernameofferletter");
    const newteammemberdiv=document.getElementById("newteammemberdiv");
    const sendernameofferletterdiv=document.getElementById("sendernameofferletterdiv");
    const newteammemberinput=document.getElementById("newteammemberinput");

    if(sendernameofferletter.value==='New Member'){
        sendernameofferletterdiv.style.display='none';
        newteammemberdiv.style.display='block';
        newteammemberinput.setAttribute('required', 'required');



    }
    else{
        sendernameofferletterdiv.style.display='block';
        newteammemberdiv.style.display='none';
        newteammemberinput.removeAttribute('required'); 


    }
    
}

function reimbusrementfucntion(){
    const reimbursementdd=document.getElementById("reimbursementdd");
    const reimbursement1=document.getElementById("reimbursement1");
    const reimbursement2=document.getElementById("reimbursement2");

    if(reimbursementdd.value==='Yes'){
        reimbursement1.style.display='flex';
        reimbursement2.style.display='flex';
    }
    else{
        reimbursement1.style.display='none';
        reimbursement2.style.display='none';
 
    }

}

function showgratuityeligibilitydd(){
    const gratuitydd=document.getElementById("gratuitydd");
    const gratuityeligibilitydd=document.getElementById("gratuityeligibilitydd");

    if(gratuitydd.value==='Yes'){
        gratuityeligibilitydd.style.display='block';
        gratuityeligibilitydd.setAttribute('required', 'required');
    }
    else{
        gratuityeligibilitydd.style.display='none';
        gratuityeligibilitydd.removeAttribute('required');


    }

}
 function shiftrelatedfield(){
  const shift_dd = document.getElementById("shift_dd");
  const doubleshift1=document.getElementById("doubleshift1");
  const doubleshift2=document.getElementById("doubleshift2");
  const doubleshift3=document.getElementById("doubleshift3");
  const doubleshift4=document.getElementById("doubleshift4");
//   const morning_closedhmr=document.getElementById("morning_closedhmr");
//   const closedkmr=document.getElementById("closedkmr");
//   const night_hmr_start=document.getElementById("night_hmr_start");
//   const night_start_km=document.getElementById("night_start_km");

  if (shift_dd.value === 'Double') {
    doubleshift1.style.display = 'flex';
    doubleshift2.style.display = 'flex';
    doubleshift3.style.display = 'flex';
    doubleshift4.style.display = 'flex';

    // night_hmr_start.value = morning_closedhmr.value || ''; // Assign morning_closedhmr value or empty string
    // night_start_km.value = closedkmr.value || '';
  }
    else{
    doubleshift1.style.display='none';
    doubleshift2.style.display='none';
    doubleshift3.style.display='none';
    doubleshift4.style.display='none';

  }

 }

