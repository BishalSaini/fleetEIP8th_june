$(document).ready(function() {
    var aData = [];
    var companyname = $("#logistics_need_rental").val(); // Assuming this input field contains the company name

    // Function to fetch sender's details based on company name
    function fetchData(companyname) {
        $.ajax({
            url: "get_data_contactperson.php",
            type: "GET",
            data: { companyname: companyname },
            dataType: "json",
            success: function(data) {
                aData = data;
                populateSenderDropdown(aData);
                // Don't auto-select any option
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Call fetchData when the client name changes
    $("#logistics_need_rental").change(function() {
        var companyname = $(this).val();
        if (companyname) {
            fetchData(companyname);
        }
    });

    // Populate the sender dropdown with fetched data
    function populateSenderDropdown(data) {
        var $senderDropdown = $("#contactperson_logistic_need");
        $senderDropdown.empty(); // Clear existing options
        $senderDropdown.append('<option value="">Select Sender</option>'); // Default option

        // Append new options based on the fetched data
        data.forEach(function(item) {
            $senderDropdown.append('<option value="' + item.name + '">' + item.name + '</option>');
        });
    }

    // Change event handler for dropdown with id contactperson_logistic_need
    $("#contactperson_logistic_need").change(function() {
        var selectedSenderName = $(this).val();

        // Find the selected sender's details from the data
        var selectedItem = aData.find(function(item) {
            return item.name === selectedSenderName; // Adjust property name if necessary
        });

        // Populate form fields based on selected sender
        populateFormFields(selectedItem);
    });

    // Function to populate form fields based on selected sender
    function populateFormFields(selectedItem) {
        if (selectedItem) {
            $("#contact_person_number").val(selectedItem.mob_number || '');
            $("#contact_person_email").val(selectedItem.email || '');
        } else {
            $("#contact_person_number").val('');
            $("#contact_person_email").val('');
        }
    }

    // Initial fetch data call if company name is preselected
    if (companyname) {
        fetchData(companyname);
    }
});

// Update Contact Person function
function updateContactPerson() {
    var companyName = document.getElementById('companySelect').value;
    var selfName = document.getElementById('comp_name_trial').value;

    // Make sure a company is selected
    if (companyName) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_contacts.php?companyName=' + encodeURIComponent(companyName) + '&selfName=' + encodeURIComponent(selfName), true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                var response = JSON.parse(xhr.responseText);
                var contactSelect = document.getElementById('contactSelect');
                var handledBySelect = document.getElementById('contactperson_logistic_need'); // Sender name select element
                var workingDaysSelect = document.getElementById('working_days_select'); // Working days select element
                var engineHourSelect = document.getElementById('engine_hour_select'); 


                // Clear existing options for the contact select
                contactSelect.innerHTML = '';

                // Add default option for contactSelect
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Contact Person';
                defaultOption.selected = true; // Make it selected by default
                contactSelect.appendChild(defaultOption);

                // Add "New Contact Person" option
                var newOption = document.createElement('option');
                newOption.value = 'New Contact Person';
                newOption.textContent = 'New Contact Person';
                contactSelect.appendChild(newOption);

                // Populate new options for contactSelect
                response.forEach(function(contact) {
                    var contactOption = document.createElement('option');
                    contactOption.value = contact.name; // Use a unique identifier
                    contactOption.textContent = contact.name; // Display the contact name
                    contactSelect.appendChild(contactOption);
                });

                // Clear any pre-selected option for handledBySelect
                handledBySelect.value = '';

                // Auto-select the 'handled_by' value in the sender name select if available
                if (response.length > 0 && response[0].handled_by) {
                    handledBySelect.value = response[0].handled_by; // Auto-select the handled_by field in sender select

                    // Trigger change event to populate contact details
                    $('#contactperson_logistic_need').val(response[0].handled_by).change();
                }
                if (response.length > 0 && response[0].working_days) {
                    workingDaysSelect.value = response[0].working_days; // Set the value of the working_days select

                    $('#working_days_select').val(response[0].working_days).change();
                } 
                if (response.length > 0 && response[0].engine_hours) {
                    engineHourSelect.value = response[0].engine_hours; 
                    $('#engine_hour_select').val(response[0].engine_hours).change();
                }
            
            }
        };
        xhr.send();
    }
}
