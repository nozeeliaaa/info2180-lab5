function searchList(type = 'country') {
    var result = document.getElementById("result");
    var countryInput = document.getElementById("country");
    var countryName = countryInput.value.trim(); // Get and clean the input value

    // Create the URL for the request based on the type (country or cities)
    var url = `world.php?country=${encodeURIComponent(countryName)}`;
    if (type === 'cities') {
        url += `&lookup=cities`;  // Add query parameter for cities lookup
    }

    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState === XMLHttpRequest.DONE) {
            if (req.status === 200) {
                // If the request is successful, update the result div
                result.innerHTML = req.responseText;
            } else {
                console.log("There seems to be an error!");
            }
        }
    };

    // Send the request to the server
    req.open("GET", url, true);
    req.send();
}

window.onload = function() {
    console.log("Page successfully loaded");

    // Country lookup button event listener
    var lookupButton = document.getElementById("lookup");
    lookupButton.addEventListener("click", function() {
        var countryInput = document.getElementById("country");
        var countryName = countryInput.value.trim();
        
        // Only trigger the search if the country input is empty
        if (countryName === "") {
            searchList('country');  // Trigger country search when search bar is empty
        } else {
            searchList('country');  // Trigger country search otherwise
        }
    });

    // Cities lookup button event listener
    var lookupCitiesButton = document.getElementById("lookup-cities");
    lookupCitiesButton.addEventListener("click", function() {
        var countryInput = document.getElementById("country");
        var countryName = countryInput.value.trim();

        // Trigger city search only if the country input is not empty
        if (countryName !== "") {
            searchList('cities');  // Trigger cities search
        } else {
            alert("Please enter a country name to look up cities.");
        }
    });

    // Allow the user to press 'Enter' for a country search
    var countryInput = document.getElementById("country");
    countryInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            var countryName = countryInput.value.trim();
            
            // If the country input is empty, perform a general country search
            if (countryName === "") {
                searchList('country');
            } else {
                searchList('country'); // Otherwise, perform the country search
            }
        }
    });
};
