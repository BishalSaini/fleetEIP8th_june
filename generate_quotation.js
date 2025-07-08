function not_immediate(){
 const availability_dd=document.getElementById("availability_dd");
 const date_of_availability=document.getElementById("date_of_availability");
 if(availability_dd.value==="Not Immediate"){
    date_of_availability.style.display="block";
 }
 else{
    date_of_availability.style.display="none";
 }
}

    function purchase_option() {
    const options = document.getElementsByClassName('awp_options');
    const options1 = document.getElementsByClassName('cq_options');
    const options2 = document.getElementsByClassName('earthmover_options');
    const options3 = document.getElementsByClassName('mhe_options');
    const options4 = document.getElementsByClassName('gee_options');
    const options5 = document.getElementsByClassName('trailor_options');
    const options6 = document.getElementsByClassName('generator_options');

    const first_select = document.getElementById('oem_fleet_type');

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


}
function officetypedd(){
    const office_typenew=document.getElementById("office_typenew");
    const regandsitecontainerouter=document.getElementById("regandsitecontainerouter");
    const siteoffice=document.getElementById("siteoffice");
    const regionaloffice=document.getElementById("regionaloffice");
    if(office_typenew.value==='Regional Office'){
        regandsitecontainerouter.style.display='flex';
        regionaloffice.style.display='block';
        siteoffice.style.display='none';

    }
    else if(office_typenew.value==='Site Office'){
        regandsitecontainerouter.style.display='flex';
        siteoffice.style.display='block';
        regionaloffice.style.display='none';


    }
    else{
        regandsitecontainerouter.style.display='none';
        siteoffice.style.display='none';
        regionaloffice.style.display='none';


    }
}


function seco_equip() {
    const options1 = document.getElementsByClassName('awp_options1');
    const options11 = document.getElementsByClassName('cq_options1');
    const options21 = document.getElementsByClassName('earthmover_options1');
    const options31 = document.getElementsByClassName('mhe_options1');
    const options41 = document.getElementsByClassName('gee_options1');
    const options51 = document.getElementsByClassName('trailor_options1');
    const options61 = document.getElementsByClassName('generator_options1');

    const first_select1 = document.getElementById('oem_fleet_type1');

    // Set the display style for all elements at once
    const displayStyle00 = (first_select1.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options1).forEach(option => option.style.display = displayStyle00);

    const displayStyle1 = (first_select1.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options11).forEach(option => option.style.display = displayStyle1);

    const displayStyle2 = (first_select1.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options21).forEach(option => option.style.display = displayStyle2);

    const displayStyle3 = (first_select1.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options31).forEach(option => option.style.display = displayStyle3);

    const displayStyle4 = (first_select1.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options41).forEach(option => option.style.display = displayStyle4);

    const displayStyle5 = (first_select1.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options51).forEach(option => option.style.display = displayStyle5);

    const displayStyle6 = (first_select1.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options61).forEach(option => option.style.display = displayStyle6);


}
function updateAssetCode(selectElement) {
    // Get the selected fleet category and dropdown ID
    var fleetCategory = selectElement.value;
    var dropdownId = selectElement.getAttribute("data-dropdown");

    // Find the corresponding asset code dropdown
    var assetCodeDropdown = document.querySelector('.asset-code[data-dropdown="' + dropdownId + '"]');

    // Make an AJAX request to fetch asset codes based on the selected category
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_asset_codes.php?fleet_category=" + encodeURIComponent(fleetCategory), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);

                // Check if the response contains an error
                if (response.error) {
                    console.error("Error:", response.error);
                    return;
                }

                // Clear existing options
                assetCodeDropdown.innerHTML = '<option value="" disabled selected>Choose Asset Code</option><option value="New Equipment">Choose New Equipment</option>';

                // Append new options
                response.forEach(function (asset) {
    var option = document.createElement("option");
    option.value = asset.assetcode;
    option.text = asset.assetcode + " (" + asset.sub_type + " " + asset.make + " " + asset.model + " " + asset.capacity + " " + asset.unit + ") " + asset.status;

    // Set background color based on status
    if (asset.status.toLowerCase() === "idle") {
        option.style.backgroundColor = "lightgreen";
    } else if (asset.status.toLowerCase() === "working") {
        option.style.backgroundColor = "lightcoral"; // Light red
    }

    assetCodeDropdown.appendChild(option);
});
            } catch (e) {
                console.error("Failed to parse JSON response:", e);
                console.error("Response:", xhr.responseText);
            }
        }
    };
    xhr.send();
}
function newclient(){
    const companySelect=document.getElementById("companySelect");
    const contactSelect=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const companySelectouter=document.getElementById("companySelectouter");
        const newrentalclient=document.getElementById("newrentalclient");

    
        if(companySelect.value==='New Client'){
            companySelectouter.style.display='none';
            contactSelect.style.display='none';
            newrentalcontactperson.style.display='flex';
            newrentalclient.style.display='flex';
    
        }

}

function newcontactpersonfunction(){
    const contactSelect=document.getElementById("contactSelect");
    const contactSelectouter=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const quoteouter02=document.getElementById("quoteouter02");

    if(contactSelect.value==='New Contact Person'){
        contactSelectouter.style.display='none';
        newrentalcontactperson.style.display='flex';

    
        }


}

function third_vehicle(){
    const thirdvehicledetail=document.getElementById("thirdvehicledetail");
    const third_addequipbtn=document.getElementById("third_addequipbtn");
    thirdvehicledetail.style.display="flex";
    third_addequipbtn.style.display="none";

}
function fourth_quotation(){
    const fouthvehicledata=document.getElementById("fouthvehicledata");
    const fourth_addequipbtn=document.getElementById("fourth_addequipbtn");
    fouthvehicledata.style.display="flex";
    fourth_addequipbtn.style.display="none";

}

function fifth_quotation(){
    const fifthvehicledata=document.getElementById("fifthvehicledata");
    const fifth_addequipbtn=document.getElementById("fifth_addequipbtn");
    fifthvehicledata.style.display="flex";
    fifth_addequipbtn.style.display="none";

}



function filterClients() {
    const input = document.getElementById('clientSearch');
    const filter = input.value.toLowerCase();
    const suggestions = document.getElementById('suggestions');
    const select = document.getElementById('companySelect');
    const options = select.getElementsByTagName('option');

    suggestions.innerHTML = ''; // Clear previous suggestions
    let hasVisibleItems = false;

    for (let i = 0; i < options.length; i++) {
        const optionText = options[i].textContent || options[i].innerText;
        if (optionText.toLowerCase().includes(filter) && filter) {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'suggestion-item';
            suggestionItem.textContent = optionText;
            suggestionItem.onclick = function() {
                select.value = options[i].value; // Set the select value
                input.value = optionText; // Set the input value
                suggestions.style.display = 'none'; // Hide suggestions
                updateContactPerson(); // Call the onchange function
                newclient(); // Call the newclient function
            };
            suggestions.appendChild(suggestionItem);
            hasVisibleItems = true;
        }
    }

    // If no suggestions found, show "New Client" option
    if (!hasVisibleItems) {
        const newClientItem = document.createElement('div');
        newClientItem.className = 'suggestion-item';
        newClientItem.textContent = 'New Client';
        newClientItem.onclick = function() {
            select.value = 'New Client'; // Set the select value
            input.value = 'New Client'; // Set the input value
            suggestions.style.display = 'none'; // Hide suggestions
            updateContactPerson(); // Call the onchange function
            newclient(); // Call the newclient function
        };
        suggestions.appendChild(newClientItem);
        suggestions.style.display = 'block'; // Show the suggestions
    } else {
        suggestions.style.display = 'block'; // Show suggestions if there are any
    }
}

function showDropdown() {
    const suggestions = document.getElementById('suggestions');
    suggestions.style.display = 'block';
}

// Close suggestions when clicking outside
document.addEventListener('click', function(event) {
    const suggestions = document.getElementById('suggestions');
    const input = document.getElementById('clientSearch');
    if (!suggestions.contains(event.target) && event.target !== input) {
        suggestions.style.display = 'none';
    }
}); 


// --- Auto-select fleet category in new equipment section when "Choose New Equipment" is selected ---
document.addEventListener('DOMContentLoaded', function() {
    // Map dropdown index to new equipment fleet category select IDs
    const newEquipFleetCategoryIds = {
        1: 'oem_fleet_type',
        2: 'oem_fleet_type1',
        3: 'oem_fleet_type3',
        4: 'oem_fleet_type4',
        5: 'oem_fleet_type5'
    };

    // Map dropdown index to fleet type onchange handler
    const fleetTypeOnChangeFns = {
        1: window.purchase_option,
        2: window.seco_equip,
        3: window.third_equipment ? window.third_equipment : function(){},
        4: window.fourth_equipment ? window.fourth_equipment : function(){},
        5: window.fifth_equipment ? window.fifth_equipment : function(){}
    }; 

    //Auto-select fleet category when "Choose New Equipment" is selected.........

    document.querySelectorAll('.asset-code').forEach(function(assetCodeSelect) {
        assetCodeSelect.addEventListener('change', function() {
            const selectedOption = assetCodeSelect.value;
            const dropdownId = assetCodeSelect.getAttribute('data-dropdown');
            if (selectedOption === 'New Equipment') {
                // Find the fleet category select for this section
                const fleetCategorySelect = document.querySelector('.fleet-category[data-dropdown="' + dropdownId + '"]');
                const newEquipFleetCategoryId = newEquipFleetCategoryIds[dropdownId];
                const newEquipFleetCategorySelect = document.getElementById(newEquipFleetCategoryId);
                if (fleetCategorySelect && newEquipFleetCategorySelect) {
                    // Set value and trigger change
                    newEquipFleetCategorySelect.value = fleetCategorySelect.value;
                    // Trigger the correct onchange handler for fleet type options
                    if (typeof newEquipFleetCategorySelect.onchange === "function") {
                        newEquipFleetCategorySelect.onchange();
                    }
                    // Also call the mapped function if available (for sections 2-5)
                    if (fleetTypeOnChangeFns[dropdownId]) {
                        fleetTypeOnChangeFns[dropdownId]();
                    }
                }
            }
        });
    });
});