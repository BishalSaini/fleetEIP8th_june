$(document).ready(function() {
    var aData = [];
    var companyname = $("#logicompanyname").val(); // Get company name from input field

    // Function to fetch data from server based on companyname
    function fetchData(companyname) {
        $.ajax({
            url: "get_logiclient.php",
            type: "GET",
            data: { companyname: companyname }, // Pass company name as a parameter
            dataType: "json",
            success: function(data) {
                console.log("Data from server:", data);
                aData = data;
                // Initialize form fields based on pre-selected values
                initializeFormFields();
            },
        });
    }

    // Function to initialize form fields based on selected values
    function initializeFormFields() {
        // Handle initial selection for consignor
        var initialConsignor = $("#consignor").val();
        if (initialConsignor) {
            var selectedItem = aData.find(function(item) {
                return item.client_name === initialConsignor;
            });
            populateConsignorFields(selectedItem);
        }

        // Handle initial selection for consignee_name
        var initialConsignee = $("#consignee_name").val();
        if (initialConsignee) {
            var selectedItem = aData.find(function(item) {
                return item.client_name === initialConsignee;
            });
            populateConsigneeFields(selectedItem);
        }

        // Handle initial selection for billing_party
        var initialBillingParty = $("#billing_party").val();
        if (initialBillingParty) {
            var selectedItem = aData.find(function(item) {
                return item.client_name === initialBillingParty;
            });
            populatebillingpartyFields(selectedItem);
        }
    }

    // Initial fetch data call
    fetchData(companyname);

    // Change event handler for dropdown with id consignor
    $("#consignor").change(function() {
        var selectedClient = $(this).val();
        console.log("Selected Client:", selectedClient);
        var selectedItem = aData.find(function(item) {
            return item.client_name === selectedClient;
        });

        // Populate form fields based on selected item
        populateConsignorFields(selectedItem);
    });

    // Change event handler for dropdown with id consignee_name
    $("#consignee_name").change(function() {
        var selectedClient = $(this).val();
        console.log("Selected 2nd Client:", selectedClient);
        var selectedItem = aData.find(function(item) {
            return item.client_name === selectedClient;
        });

        // Populate form fields based on selected item
        populateConsigneeFields(selectedItem);
    });

    // Change event handler for dropdown with id billing_party
    $("#billing_party").change(function() {
        var selectedClient = $(this).val();
        console.log("Selected Billing Client:", selectedClient);
        var selectedItem = aData.find(function(item) {
            return item.client_name === selectedClient;
        });

        // Populate form fields based on selected item
        populatebillingpartyFields(selectedItem);
    });

    // Function to populate consignor fields
    function populateConsignorFields(selectedItem) {
        if (selectedItem) {
            $("#consignorstate").val(selectedItem.clientstate || '');
            $("#address").val(selectedItem.address || '');
            $("#contactperson_consignor").val(selectedItem.contact_person1 || '');
            $("#contactemail_consignor").val(selectedItem.contact_email1 || '');
            $("#consignor_gst").val(selectedItem.gst || '');
            $("#consignor_contactperson_number").val(selectedItem.contact_number1 || '');
        } else { 
            $("#consignorstate").val('');
            $("#address").val('');
            $("#contactperson_consignor").val('');
            $("#contactemail_consignor").val('');
            $("#consignor_gst").val('');
            $("#consignor_contactperson_number").val('');
        }
    }

    // Function to populate consignee fields
    function populateConsigneeFields(selectedItem) {
        if (selectedItem) {
            $("#consignee_state").val(selectedItem.clientstate || '');
            $("#consignee_address").val(selectedItem.address || '');
            $("#consignee_contactperson").val(selectedItem.contact_person1 || '');
            $("#consignee_email").val(selectedItem.contact_email1 || '');
            $("#consignee_gst").val(selectedItem.gst || '');
            $("#consignee_contactperson_number").val(selectedItem.contact_number1 || '');
        } else { 
            $("#consignee_state").val('');
            $("#consignee_address").val('');
            $("#consignee_contactperson").val('');
            $("#consignee_email").val('');
            $("#consignee_gst").val('');
            $("#consignee_contactperson_number").val('');
        }
    }

    // Function to populate billing party fields
    function populatebillingpartyFields(selectedItem) {
        if (selectedItem) {
            $("#billingparty_address").val(selectedItem.address || '');
            $("#billingparty_contactperson").val(selectedItem.contact_person1 || '');
            $("#billingparty_contactemail").val(selectedItem.contact_email1 || '');
            $("#billingparty_contactnumber").val(selectedItem.contact_number1 || '');
            $("#billingparty_state").val(selectedItem.clientstate || '');
            $("#billingparty_gst").val(selectedItem.gst || '');
        } else { 
            $("#billingparty_address").val('');
            $("#billingparty_contactperson").val('');
            $("#billingparty_contactemail").val('');
            $("#billingparty_contactnumber").val('');
            $("#billingparty_state").val('');
            $("#billingparty_gst").val('');
        }
    }
});