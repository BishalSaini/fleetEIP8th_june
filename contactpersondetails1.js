$(document).ready(function() {
    var aData = [];
    var companyname = $("#logistics_need_rental").val(); // Changed to use your hidden field

    function fetchData(companyname) {
        $.ajax({
            url: "get_contactpersondetail.php",
            type: "GET",
            data: { companyname: companyname }, 
            dataType: "json",
            success: function(data) {
                console.log("Data from server:", data);
                aData = data;
                // Populate contact select dropdown
                populateContactSelect(data);
            },
        });
    }
    fetchData(companyname);

    // Function to populate contact select dropdown
    function populateContactSelect(data) {
        var $contactSelect = $("#contactSelect_todo");
        $contactSelect.empty(); // Clear existing options
        $contactSelect.append('<option value="" disabled selected>Select Contact Person</option>');
        $contactSelect.append('<option value="New Contact Person">New Contact Person</option>');
        
        if (data && data.length > 0) {
            data.forEach(function(item) {
                if (item.contact_person) {
                    $contactSelect.append('<option value="' + item.contact_person + '">' + item.contact_person + '</option>');
                }
            });
        }
    }

    $("#contactSelect_todo").change(function() {
        var contactSelected = $(this).val();
        console.log("Selected Person:", contactSelected);
        var selectedItem = aData.find(function(item) {
            return item.contact_person === contactSelected;
        });

        populateConsignorFields(selectedItem);
    });

    function populateConsignorFields(selectedItem) {
        if (selectedItem) {
            // Note: contactpersonaddress field doesn't exist in your form, so I've commented it out
            // $("#contactpersonaddress").val(selectedItem.clientaddress || '');
            $("#clientcontactnumber1").val(selectedItem.contact_number || '');
            $("#clientcontactemail1").val(selectedItem.contact_email || '');
        } else { 
            // $("#contactpersonaddress").val('');
            $("#clientcontactnumber1").val('');
            $("#clientcontactemail1").val('');
        }
    }

    // Update contact person when company is selected
    function updateContactPerson_todo() {
        var companySelected = $("#companySelect_todo").val();
        if (companySelected && companySelected !== 'New Client') {
            $.ajax({
                url: "get_contactpersondetail.php",
                type: "GET",
                data: { companyname: companySelected },
                dataType: "json",
                success: function(data) {
                    aData = data;
                    populateContactSelect(data);
                }
            });
        }
    }
});