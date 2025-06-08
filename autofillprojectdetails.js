$(document).ready(function() {
    var aData = [];
    var companyname = $("#companynameepc").val(); // Get company name from input field

    // Function to fetch data from server based on companyname
    function fetchData(companyname) {
        $.ajax({
            url: "get_projectdata.php",
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
    $("#selectprojectcode").change(function() {
        var selectedAssetCode = ($(this).val()); 
        console.log("Selected asset code:", selectedAssetCode);

        var selectedItem = aData.find(function(item) {

            return (item.projectcode) === selectedAssetCode; // Compare as integers
        });

        // Populate form fields based on selected item
        populateFormFields(selectedItem);
    });

    function populateFormFields(selectedItem) {
        if (selectedItem) {
            $("#epcprojectname").val(selectedItem.projectname || '');
            $("#project_district").val(selectedItem.district || '');
            $("#state").val(selectedItem.state || '');
            $("#epcprojecttype").val(selectedItem.project_type || '');
        } else { 
            $("#epcprojectname").val('');
            $("#project_district").val('');
            $("#state").val('');
            $("#epcprojecttype").val('');
        }
    }

})