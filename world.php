<?php
// Database connection setup
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get the country and lookup query parameter
$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

// Initialize the results array
$results = [];

if ($lookup == 'cities' && !empty($country)) {
    // SQL Query to fetch cities for the country using JOIN
    $stmt = $conn->prepare("
        SELECT cities.name AS city_name, cities.district, cities.population 
        FROM cities 
        INNER JOIN countries 
        ON cities.country_code = countries.code 
        WHERE countries.name LIKE :country
    ");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output cities in a table
    if (!empty($results)) {
        echo "<table border='1'>";
        echo "<thead><tr><th>Name</th><th>District</th><th>Population</th></tr></thead>";
        echo "<tbody>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['city_name'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['district'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['population'] ?? '') . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p id='not-found' style='color: red;'>No cities found.</p>";
    }
} else {
    // If the country is empty, fetch all countries
    if (empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries"); // Fetch all countries if no country is specified
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            echo "<table border='1'>";
            echo "<thead><tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
            echo "<tbody>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['continent'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['independence_year'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['head_of_state'] ?? '') . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p id='not-found' style='color: red;'>No countries found.</p>";
        }
    } else {
        // If the country is not empty, search for the country
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            echo "<table border='1'>";
            echo "<thead><tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
            echo "<tbody>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['continent'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['independence_year'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['head_of_state'] ?? '') . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p id='not-found' style='color: red;'>No countries found.</p>";
        }
    }
}
?>
