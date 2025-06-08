$(document).ready(function() {
    var aData = [];
    var companyname = $("#logicompanyname").val(); // Get company name from input field

    // Function to fetch data from server based on companyname
    function fetchData(companyname) {
        $.ajax({
            url: "getchallan.php",
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

    // Change event handler for dropdown with id consignor
    $("#cnnumber").change(function() {
        var selectedcn = $(this).val();
        console.log("Selected Client:", selectedcn);
        var selectedItem = aData.find(function(item) {
            return item.cnnumber === selectedcn;
        });

        // Populate form fields based on selected item
        populateCnFields(selectedItem);
    });
    function populateCnFields(selectedItem) {
        if (selectedItem) {
            // $("#consignee_state").val(selectedItem.clientstate || '');
            $("#consignor").val(selectedItem.consignor || '');
            $("#source_station").val(selectedItem.booking_station || '');
            $("#consignee").val(selectedItem.consignee_name || '');
            $("#destination_station").val(selectedItem.consignee_booking_station || '');
            $("#no_of_package").val(selectedItem.no_of_package || '');
            $("#actual_weight").val(selectedItem.actual_weight || '');
            $("#charged_weight").val(selectedItem.charge_weight || '');
        } else { 
            $("#consignor").val('');
            $("#source_station").val('');
            $("#consignee").val('');
            $("#destination_station").val('');
            $("#no_of_package").val('');
            $("#actual_weight").val('');
            $("#charged_weight").val('');
        }
    }

});