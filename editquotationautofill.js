$(document).ready(function() {
    var aData = [];
    var companyname = $("#comp_name_trial").val(); // Get company name from input field

    // Function to fetch data from server based on companyname
    function fetchData(companyname) {
        $.ajax({
            url: "get_data.php",
            type: "GET",
            data: { companyname: companyname }, // Pass company name as a parameter
            dataType: "json",
            success: function(data) {
                console.log("Data from server:", data);
                aData = data;
            },
        });
    }

    // Initial fetch data call
    fetchData(companyname);

    // Change event handler for dropdown with id assetcode
    $("#assetcode").change(function() {
        var selectedAssetCode = parseInt($(this).val()); // Convert to integer
        console.log("Selected asset code:", selectedAssetCode);
        var selectedItem = aData.find(function(item) {
            return parseInt(item.assetcode) === selectedAssetCode; // Compare as integers
        });

        // Populate form fields based on selected item
        populateFormFields(selectedItem);
    });

    // Change event handler for dropdown with id asset_code2
    $("#choose_Ac2").change(function() {
        var selectedAssetCode = parseInt($(this).val()); // Convert to integer
        console.log("Selected asset code for asset_code2:", selectedAssetCode);
        var selectedItem = aData.find(function(item) {
            return parseInt(item.assetcode) === selectedAssetCode; // Compare as integers
        });

        // Populate different form fields based on selected item for asset_code2
        populateFormFieldsForSecond(selectedItem);
    });

    $("#choose_Ac3").change(function() {
        var selectedAssetCode = parseInt($(this).val()); // Convert to integer
        console.log("Selected asset code for asset_code3:", selectedAssetCode);
        var selectedItem = aData.find(function(item) {
            return parseInt(item.assetcode) === selectedAssetCode; // Compare as integers
        });

        // Populate different form fields based on selected item for asset_code3
        populateFormFieldsForThird(selectedItem);
    });

    $("#choose_Ac4").change(function() {
        var selectedAssetCode = parseInt($(this).val()); // Convert to integer
        console.log("Selected asset code for asset_code4:", selectedAssetCode);
        var selectedItem = aData.find(function(item) {
            return parseInt(item.assetcode) === selectedAssetCode; // Compare as integers
        });

        // Populate different form fields based on selected item for asset_code4
        populateFormFieldsForFourth(selectedItem);
    });

    $("#choose_Ac5").change(function() {
        var selectedAssetCode = parseInt($(this).val()); // Convert to integer
        console.log("Selected asset code for asset_code5:", selectedAssetCode);
        var selectedItem = aData.find(function(item) {
            return parseInt(item.assetcode) === selectedAssetCode; // Compare as integers
        });

        // Populate different form fields based on selected item for asset_code5
        populateFormFieldsForFifth(selectedItem);
    });



    

    // Function to populate form fields based on selected item
    function populateFormFields(selectedItem) {
        if (selectedItem) {
            $("#capacity").val(selectedItem.capacity || '');
            $("#unit").val(selectedItem.unit || '');
            $("#jiblength").val(selectedItem.jib_length || '');
            $("#boomlength").val(selectedItem.boom_length || '');
            $("#luffinglength").val(selectedItem.luffing_length || '');
            $("#yom").val(selectedItem.yom || '');
            $("#equimentlocation").val(selectedItem.project_location || '');
            $("#fuel").val(selectedItem.fuel_norms || ''); 
            $("#make").val(selectedItem.make || '');
            $("#model").val(selectedItem.model || '');
            $("#oem_fleet_type").val(selectedItem.category || '');
            $("#fleet_sub_type").val(selectedItem.sub_type || '');

        } else { 
            $("#capacity").val('');
            $("#unit").val('');
            $("#jiblength").val('');
            $("#boomlength").val('');
            $("#luffinglength").val('');
            $("#yom").val('');
            $("#equimentlocation").val('');
            $("#fuel").val(''); 
            $("#make").val('');
            $("#model").val('');
            $("#oem_fleet_type").val('');
            $("#fleet_sub_type").val('');
        }
    }

    // Function to populate different form fields based on selected item for asset_code2
    function populateFormFieldsForSecond(selectedItem) {
        if (selectedItem) {
            $("#capacity_second").val(selectedItem.capacity || '');
            $("#jiblength_second").val(selectedItem.jib_length || '');
            $("#boomlength_second").val(selectedItem.boom_length || '');
            $("#luffinglength_second").val(selectedItem.luffing_length || '');
            $("#yom_second").val(selectedItem.yom || '');
            $("#oem_fleet_type1").val(selectedItem.category || '');
            $("#fleet_sub_type1").val(selectedItem.sub_type || '');
            $("#2ndvehiclemake").val(selectedItem.make || '');
            $("#2ndvehiclemodel").val(selectedItem.model || '');
            // $("#equimentlocation").val(selectedItem.project_location || '');
            $("#fuel_second").val(selectedItem.fuel_norms || '');
            $("#2ndequipmentunit").val(selectedItem.unit || '');
        } else {
            $("#capacity_second").val('');
            $("#jiblength_second").val('');
            $("#boomlength_second").val('');
            $("#luffinglength_second").val('');
            $("#yom_second").val('');
            // $("#equimentlocation").val('');
            $("#fuel_second").val('');
            $("#oem_fleet_type1").val('');
            $("#fleet_sub_type1").val('');
            $("#2ndvehiclemake").val('');
            $("#2ndvehiclemodel").val('');
            $("#2ndequipmentunit").val('');
        }
    };

    function populateFormFieldsForThird(selectedItem) {
        if (selectedItem) {


            $("#oem_fleet_type3").val(selectedItem.category || '');
            $("#fleet_sub_type3").val(selectedItem.sub_type || '');
            $("#3rdequipmentmake").val(selectedItem.make || '');
            $("#3rdequipmentmodel").val(selectedItem.model || '');
            $("#capacity_third").val(selectedItem.capacity || '');
            $("#3rdequipmentunit").val(selectedItem.unit || '');
            $("#yom3").val(selectedItem.yom || '');
            $("#boom3").val(selectedItem.boom_length || '');
            $("#jib3").val(selectedItem.jib_length || '');
            $("#luffing3").val(selectedItem.luffing_length || '');
            $("#fuel_third").val(selectedItem.fuel_norms || '');
        } else {

            $("#oem_fleet_type3").val('');
            $("#fleet_sub_type3").val('');
            $("#3rdequipmentmake").val('');
            $("#3rdequipmentmodel").val('');
            $("#capacity_third").val('');
            $("#3rdequipmentunit").val('');
            $("#yom3").val('');
            $("#boom3").val('');
            $("#jib3").val('');
            $("#luffing3").val('');
            $("#fuel_third").val('');



        }
    };

    function populateFormFieldsForFourth(selectedItem) {
        if (selectedItem) {
            $("#oem_fleet_type4").val(selectedItem.category || '');
            $("#fleet_sub_type4").val(selectedItem.sub_type || '');
            $("#4thmake").val(selectedItem.make || '');
            $("#4thmodel").val(selectedItem.model || '');
            $("#4thcap").val(selectedItem.capacity || '');
            $("#4thunit").val(selectedItem.unit || '');
            $("#4thyom").val(selectedItem.yom || '');
            $("#4thboom").val(selectedItem.boom_length || '');
            $("#4thjib").val(selectedItem.jib_length || '');
            $("#4thluffing").val(selectedItem.luffing_length || '');
            $("#fuel_fourth").val(selectedItem.fuel_norms || '');
        } else {

            $("#oem_fleet_type4").val('');
            $("#fleet_sub_type4").val('');
            $("#4thmake").val('');
            $("#4thmodel").val('');
            $("#4thcap").val('');
            $("#4thunit").val('');
            $("#4thyom").val('');
            $("#4thboom").val('');
            $("#4thjib").val('');
            $("#4thluffing").val('');
            $("#fuel_fourth").val('');



        }
    };

    function populateFormFieldsForFifth(selectedItem) {
        if (selectedItem) {
            $("#oem_fleet_type5").val(selectedItem.category || '');
            $("#fleet_sub_type5").val(selectedItem.sub_type || '');
            $("#5thmake").val(selectedItem.make || '');
            $("#5thmodel").val(selectedItem.model || '');
            $("#5thcap").val(selectedItem.capacity || '');
            $("#5thunit").val(selectedItem.unit || '');
            $("#5thyom").val(selectedItem.yom || '');
            $("#5thboom").val(selectedItem.boom_length || '');
            $("#5thjib").val(selectedItem.jib_length || '');
            $("#5thluffing").val(selectedItem.luffing_length || '');
            $("#fuel_fifth").val(selectedItem.fuel_norms || '');
        } else {

            $("#oem_fleet_type5").val('');
            $("#fleet_sub_type5").val('');
            $("#5thmake").val('');
            $("#5thmodel").val('');
            $("#5thcap").val('');
            $("#5thunit").val('');
            $("#5thyom").val('');
            $("#5thboom").val('');
            $("#5thjib").val('');
            $("#5thluffing").val('');
            $("#fuel_fifth").val('');



        }
    };




});