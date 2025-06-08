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
        const fields = [
            { id: "#capacity", value: selectedItem?.capacity },
            { id: "#unit", value: selectedItem?.unit },
            { id: "#jiblength", value: selectedItem?.jib_length },
            { id: "#boomlength", value: selectedItem?.boom_length },
            { id: "#luffinglength", value: selectedItem?.luffing_length },
            { id: "#yom", value: selectedItem?.yom },
            { id: "#equimentlocation", value: selectedItem?.project_location },
            { id: "#fuel", value: selectedItem?.fuel_norms },
            { id: "#make", value: selectedItem?.make },
            { id: "#model", value: selectedItem?.model },
            { id: "#bedlength", value: selectedItem?.bedlength },
            { id: "#fuel", value: selectedItem?.fuelEficiency },
            { id: "#adbluedd", value: selectedItem?.adblue },
            { id: "#equimentlocation", value: selectedItem?.equipmentLocation },
            { id: "#fuelunit1", value: selectedItem?.unit },
            { id: "#unit1", value: selectedItem?.fuelUnit }
        ];
    
        fields.forEach(field => {
            const $input = $(field.id);
            const $trialContainer = $input.closest(".trial1");
    
            // Always show fields other than boomlength, jiblength, luffinglength, and bedlength
            if (!["#boomlength", "#jiblength", "#luffinglength", "#bedlength"].includes(field.id)) {
                $input.val(field.value || ""); // Set the value or empty string if undefined
                $trialContainer.show(); // Always show the container
            } else {
                // Hide boomlength, jiblength, luffinglength, and bedlength if empty
                if (selectedItem && field.value) {
                    $input.val(field.value); // Set the value
                    $trialContainer.show(); // Show the container if it has a value
                } else {
                    $input.val(''); // Clear the input
                    $trialContainer.hide(); // Hide the container if the input is empty
                }
            }
        });
    
        // Adjust widths for boom, jib, and luffing inputs
        adjustFlexWidths(".outer02 .specific-container");
    
    }
    
    function adjustFlexWidths(containerClass) {
        const $container = $(containerClass);
        const $visibleInputs = $container.find(".trial1:visible"); // Get visible inputs
    
        // Calculate the width for each visible input
        const width = 100 / $visibleInputs.length;
    
        // Apply the width to each visible input
        $visibleInputs.css("flex", `1 1 ${width}%`);
    }

    // Function to populate different form fields based on selected item for asset_code2
function populateFormFieldsForSecond(selectedItem) {
    const fields = [
        { id: "#capacity_second", value: selectedItem?.capacity },
        { id: "#jiblength_second", value: selectedItem?.jib_length },
        { id: "#boomlength_second", value: selectedItem?.boom_length },
        { id: "#luffinglength_second", value: selectedItem?.luffing_length },
        { id: "#yom_second", value: selectedItem?.yom },
        { id: "#bedlength_second", value: selectedItem?.bedlength },

        { id: "#fuel_second", value: selectedItem?.fuelEficiency},
        { id: "#adbluedd2", value: selectedItem?.adblue },
        { id: "#equipmentlocation2", value: selectedItem?.equipmentLocation},
        { id: "#unit2", value: selectedItem?.fuelUnit }


    ];

    fields.forEach(field => {
        const $input = $(field.id);
        const $trialContainer = $input.closest(".trial1");

        // Always show fields other than jiblength, boomlength, luffinglength, and fuel
        if (!["#jiblength_second", "#boomlength_second", "#luffinglength_second", "#bedlength_second"].includes(field.id)) {
            $input.val(field.value || ""); // Set the value or empty string if undefined
            $trialContainer.show(); // Always show the container
        } else {
            // Hide jiblength, boomlength, luffinglength, and fuel if empty
            if (selectedItem && field.value) {
                $input.val(field.value); // Set the value
                $trialContainer.show(); // Show the container if it has a value
            } else {
                $input.val(''); // Clear the input
                $trialContainer.hide(); // Hide the container if the input is empty
            }
        }
    });

    // Adjust widths for boom, jib, and luffing inputs
    adjustFlexWidths(".outer02 .specific-container");
}

function populateFormFieldsForThird(selectedItem) {
    const fields = [
        { id: "#capacity_third", value: selectedItem?.capacity },
        { id: "#jiblength_third", value: selectedItem?.jib_length },
        { id: "#boomlength_third", value: selectedItem?.boom_length },
        { id: "#luffinglength_third", value: selectedItem?.luffing_length },
        { id: "#yom_third", value: selectedItem?.yom },
        { id: "#bedlength_third", value: selectedItem?.bedlength },
        // { id: "#fuel_third", value: selectedItem?.fuel_norms }

        { id: "#fuel_third", value: selectedItem?.fuelEficiency },
        { id: "#adbluedd3", value: selectedItem?.adblue },
        { id: "#equiplocation03", value: selectedItem?.equipmentLocation},
        { id: "#unit3", value: selectedItem?.fuelUnit }



    ];

    fields.forEach(field => {
        const $input = $(field.id);
        const $trialContainer = $input.closest(".trial1");

        // Always show fields other than jiblength, boomlength, luffinglength, and fuel
        if (!["#jiblength_third", "#boomlength_third", "#luffinglength_third", "#bedlength_third"].includes(field.id)) {
            $input.val(field.value || ""); // Set the value or empty string if undefined
            $trialContainer.show(); // Always show the container
        } else {
            // Hide jiblength, boomlength, luffinglength, and fuel if empty
            if (selectedItem && field.value) {
                $input.val(field.value); // Set the value
                $trialContainer.show(); // Show the container if it has a value
            } else {
                $input.val(''); // Clear the input
                $trialContainer.hide(); // Hide the container if the input is empty
            }
        }
    });

    // Adjust widths for boom, jib, and luffing inputs
    adjustFlexWidths(".outer02 .specific-container");
}

function populateFormFieldsForFourth(selectedItem) {
    const fields = [
        { id: "#capacity_fourth", value: selectedItem?.capacity },
        { id: "#jiblength_fourth", value: selectedItem?.jib_length },
        { id: "#boomlength_fourth", value: selectedItem?.boom_length },
        { id: "#luffinglength_fourth", value: selectedItem?.luffing_length },
        { id: "#yom_fourth", value: selectedItem?.yom },

        { id: "#bedlength_fourth", value: selectedItem?.bedlength },
        { id: "#equiplocation04", value: selectedItem?.equipmentLocation },
        { id: "#adbluedd4", value: selectedItem?.adblue },


        { id: "#fuel_fourth", value: selectedItem?.fuelEficiency },
        { id: "#unit4", value: selectedItem?.fuelUnit }

    ];

    fields.forEach(field => {
        const $input = $(field.id);
        const $trialContainer = $input.closest(".trial1");

        // Always show fields other than jiblength, boomlength, luffinglength, and fuel
        if (!["#jiblength_fourth", "#boomlength_fourth", "#luffinglength_fourth", "#bedlength_fourth"].includes(field.id)) {
            $input.val(field.value || ""); // Set the value or empty string if undefined
            $trialContainer.show(); // Always show the container
        } else {
            // Hide jiblength, boomlength, luffinglength, and fuel if empty
            if (selectedItem && field.value) {
                $input.val(field.value); // Set the value
                $trialContainer.show(); // Show the container if it has a value
            } else {
                $input.val(''); // Clear the input
                $trialContainer.hide(); // Hide the container if the input is empty
            }
        }
    });

    // Adjust widths for boom, jib, and luffing inputs
    adjustFlexWidths(".outer02 .specific-container");
}

function populateFormFieldsForFifth(selectedItem) {
    const fields = [
        { id: "#capacity_fifth", value: selectedItem?.capacity },
        { id: "#jiblength_fifth", value: selectedItem?.jib_length },
        { id: "#boomlength_fifth", value: selectedItem?.boom_length },
        { id: "#luffinglength_fifth", value: selectedItem?.luffing_length },
        { id: "#yom_fifth", value: selectedItem?.yom },
        { id: "#bedlength_fifth", value: selectedItem?.bedlength },
        { id: "#equiplocation05", value: selectedItem?.equipmentLocation },
        { id: "#adbluedd5", value: selectedItem?.adblue },
        { id: "#fuel_fifth", value: selectedItem?.fuelEficiency },
        { id: "#unit5", value: selectedItem?.fuelUnit }

    ];

    fields.forEach(field => {
        const $input = $(field.id);
        const $trialContainer = $input.closest(".trial1");

        // Always show fields other than jiblength, boomlength, luffinglength, and fuel
        if (!["#jiblength_fifth", "#boomlength_fifth", "#luffinglength_fifth", "#bedlength_fifth"].includes(field.id)) {
            $input.val(field.value || ""); // Set the value or empty string if undefined
            $trialContainer.show(); // Always show the container
        } else {
            // Hide jiblength, boomlength, luffinglength, and fuel if empty
            if (selectedItem && field.value) {
                $input.val(field.value); // Set the value
                $trialContainer.show(); // Show the container if it has a value
            } else {
                $input.val(''); // Clear the input
                $trialContainer.hide(); // Hide the container if the input is empty
            }
        }
    });

    // Adjust widths for boom, jib, and luffing inputs
    adjustFlexWidths(".outer02 .specific-container");
}

// function adjustFlexWidths(containerClass) {
//     const $container = $(containerClass);
//     const $visibleInputs = $container.find(".trial1:visible"); // Get visible inputs

//     // Calculate the width for each visible input
//     const width = 100 / $visibleInputs.length;

//     // Apply the width to each visible input
//     $visibleInputs.css("flex", `1 1 ${width}%`);
// }


});