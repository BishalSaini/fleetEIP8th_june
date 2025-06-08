$(document).ready(function() {
    var aData = [];
    var companyname = $("#comp_name_trial").val(); 

    function fetchData(companyname) {
        $.ajax({
            url: "get_contactpersondetail.php",
            type: "GET",
            data: { companyname: companyname }, 
            dataType: "json",
            success: function(data) {
                console.log("Data from server:", data);
                aData = data;

            },
        });
    }
    fetchData(companyname);

    $("#contactSelect").change(function() {
        var contactSelected = $(this).val();
        console.log("Selected Person:", contactSelected);
        var selectedItem = aData.find(function(item) {
            return item.contact_person === contactSelected;
        });

        populateConsignorFields(selectedItem);
    });

    function populateConsignorFields(selectedItem) {
        if (selectedItem) {
            $("#contactpersonaddress").val(selectedItem.clientaddress || '');
            $("#clientcontactnumber").val(selectedItem.contact_number || '');
            $("#clientcontactemail").val(selectedItem.contact_email || '');
        } else { 
            $("#contactpersonaddress").val('');
            $("#clientcontactnumber").val('');
            $("#clientcontactemail").val('');
        }
    }

});