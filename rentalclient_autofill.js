$(document).ready(function() {
    // Change event handler for the name dropdown
    $("#fleeteipclientlist").change(function() {
        var selectedName = $(this).val(); // Get selected name
        
        // Log the selected name (for debugging purposes)
        console.log("Selected name:", selectedName);

        if (selectedName) {
            // Make an AJAX request to fetch client data
            $.ajax({
                url: "get_rentalclientdata.php", // PHP file to handle the request
                type: "GET",
                data: { name: selectedName }, // Pass selected name
                dataType: "json",
                success: function(data) {
                    // Log the server response for debugging
                    console.log("Data from server:", data);
                    
                    if (data.hq) {
                        // Autofill the HQ address field
                        $("#hqaddressclient").val(data.hq);
                    } else {
                        // Clear the field if client not found
                        $("#hqaddressclient").val('');
                    }

                    if (data.website) {
                        // Autofill the website field
                        $("#clientwebsite").val(data.website);
                    } else {
                        // Clear the field if client not found
                        $("#clientwebsite").val('');
                    }

                    if (data.type) {
                        // Autofill the client type dropdown
                        $("#clienttype").val(data.type);
                    } else {
                        // Clear the dropdown if not found
                        $("#clienttype").val('');
                    }

                    if (data.state) {
                        // Autofill the client state dropdown
                        $("#clientstate").val(data.state);
                    } else {
                        // Clear the dropdown if not found
                        $("#clientstate").val('');
                    }
                    if (data.gst) {
                        // Autofill the client state dropdown
                        $("#gstnumber").val(data.gst);
                    } else {
                        // Clear the dropdown if not found
                        $("#gstnumber").val('');
                    }
                },
                error: function(xhr, status, error) {
                    // Log any AJAX errors
                    console.error("AJAX error:", error);
                }
            });
        } else {
            // Clear the fields if no name is selected
            $("#hqaddressclient").val('');
            $("#clientwebsite").val('');
            $("#clienttype").val('');
            $("#clientstate").val('');
            $("#gstnumber").val('');
        }
    });
});