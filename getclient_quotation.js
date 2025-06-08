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

                // Auto-select the 'handled_by' value in the sender name select if available
                if (response.length > 0 && response[0].handled_by) {
                    handledBySelect.value = response[0].handled_by; // Auto-select the handled_by field in sender select
                }

                // Set the selected value of the working_days select
                if (response.length > 0 && response[0].working_days) {
                    workingDaysSelect.value = response[0].working_days; // Set the value of the working_days select
                } 
            }
        };
        xhr.send();
    }
}