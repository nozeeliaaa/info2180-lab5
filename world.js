function searchList() {
    var result = document.getElementById("result");
    var countryInput = document.getElementById("country");
    var countryName = countryInput.value.trim(); // Get and clean the input value

    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState === XMLHttpRequest.DONE) {
            if (req.status === 200) {
                // If the request is successful, update the result div
                result.innerHTML = req.responseText;
            }
            if (req.responseText.includes('No results found')) {
                // If no results found, display a custom message
                result.innerHTML = `<p style="color: red; font-weight: bold;">No countries found</p>`;
            } else {
                console.log("There seems to be an error!");
            }
        }
    }

    // Send the request with the country name (trimmed of extra spaces)
    req.open("GET", `world.php?country=${encodeURIComponent(countryName)}`, true);
    req.send();
}

window.onload = function() {
    console.log("Page successfully loaded");
    var lookupButton = document.getElementById("lookup");
    lookupButton.addEventListener("click", searchList);

    var countryInput = document.getElementById("country");
    countryInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            searchList(); // Trigger the search function
        }
    });
};
