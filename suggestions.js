const input = document.getElementById('autocomplete-input');
const suggestionsBox = document.getElementById('suggestions');
let suggestions = [];

// Fetch suggestions from the PHP script
fetch('fetch_suggestions.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        suggestions = data; // Store fetched suggestions
    })
    .catch(error => console.error('Error fetching suggestions:', error));

// Listen for user input
input.addEventListener('input', () => {
    const query = input.value.toLowerCase(); // Get the current input value
    suggestionsBox.innerHTML = ''; // Clear previous suggestions

    if (query) {
        // Filter suggestions based on input
        const filteredSuggestions = suggestions.filter(item =>
            item.toLowerCase().includes(query)
        );

        // Display filtered suggestions
        if (filteredSuggestions.length > 0) {
            suggestionsBox.classList.add('show'); // Show the suggestions box
        } else {
            suggestionsBox.classList.remove('show'); // Hide if no suggestions
        }

        filteredSuggestions.forEach(item => {
            const div = document.createElement('div'); // Create a new suggestion
            div.textContent = item; // Set the text for the suggestion
            div.classList.add('suggestion-item'); // Add a class for styling

            // Click event to select suggestion
            div.addEventListener('click', () => {
                input.value = item; // Set the input value
                suggestionsBox.innerHTML = ''; // Clear suggestions
                suggestionsBox.classList.remove('show'); // Hide suggestions
            });

            suggestionsBox.appendChild(div); // Add suggestion to the box
        });
    } else {
        suggestionsBox.classList.remove('show'); // Hide suggestions if input is empty
    }
});
