$(document).ready(function() {
    var aData = [];
    var companyname = $("#logistics_need_rental").val(); // Get company name from input field

    // Function to fetch data from server based on companyname
    function fetchData(companyname) {
        $.ajax({
            url: "gettododata.php",
            type: "GET",
            data: { companyname: companyname }, // Pass company name as a parameter
            dataType: "json",
            success: function(data) {
                console.log("Data from server:", data);
                aData = data;
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Initial fetch data call
    fetchData(companyname);

    // Change event handler for dropdown with id assigntasktoname
    $("#assigntasktoname").change(function() {
        var selectedAssetCode = $(this).val(); // Get selected value (string)
        console.log("Selected Name:", selectedAssetCode);

        // Find selected item in aData
        var selectedItem = aData.find(function(item) {
            return item.name === selectedAssetCode; // Compare as strings
        });

        // Populate form fields based on selected item
        populateFormFields(selectedItem);
    });

    function populateFormFields(selectedItem) {
        if (selectedItem) {
            $("#todoemail").val(selectedItem.email || '');
        } else { 
            $("#todoemail").val('');
        }
    }
});
