document.getElementById('lookup').addEventListener('click', function() {
    // Get the country name from the input field
    let country = document.getElementById('country').value.trim(); // Remove extra spaces

    // Create a new XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Prepare the URL with the country name as a query parameter
    let url = 'world.php?country=' + encodeURIComponent(country);

    // If no country is entered, we fetch all countries
    if (country === '') {
        url = 'world.php'; // No country specified, fetch all countries
    }

    // Set up the request
    xhr.open('GET', url, true);

    // Define what to do when the request completes
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse the JSON response
            let results = JSON.parse(xhr.responseText);

            // Get the result div
            let resultDiv = document.getElementById('result');
            resultDiv.innerHTML = ''; // Clear previous results

            if (results.length > 0) {
                // Loop through the results and display them
                results.forEach(function(row) {
                    let listItem = document.createElement('p');
                    listItem.textContent = row.name + ' is ruled by ' + row.head_of_state;
                    resultDiv.appendChild(listItem);
                });
            } else {
                resultDiv.innerHTML = 'No results found.';
            }
        } else {
            console.error('Request failed with status: ' + xhr.status);
        }
    };

    // Send the request
    xhr.send();
});
