<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="quotationForm">
        <label for="assetcode">Asset Code:</label>
        <select id="assetcode" name="assetcode">
            <option value="">Select Asset Code</option>
            <option value="1">ASSET001</option>
            <option value="121">ASSET121</option>
            <!-- Add more options as needed -->
        </select><br><br>
        
        <label for="capacity">Capacity:</label>
        <input type="text" id="capacity" name="capacity" readonly><br><br>
        
        <label for="yom">Year of Manufacture:</label>
        <input type="text" id="yom" name="yom" readonly><br><br>
        
        <!-- Other input fields for the form -->
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var assetcodeSelect = document.getElementById('assetcode');

            assetcodeSelect.addEventListener('change', function() {
                var assetcode = assetcodeSelect.value;
                if (assetcode.trim() !== '') {
                    // AJAX request to fetch data
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'fetch_asset_data.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var data = JSON.parse(xhr.responseText);
                            if (data.success) {
                                // Populate the fields
                                document.getElementById('capacity').value = data.capacity;
                                document.getElementById('yom').value = data.yom;
                                // You can add more fields to populate here
                            } else {
                                // Handle errors if necessary
                                console.log(data.message);
                            }
                        }
                    };
                    xhr.send('assetcode=' + encodeURIComponent(assetcode));
                }
            });
        });
    </script>
</body>
</html>
