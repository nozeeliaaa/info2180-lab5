<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';

// Initialize empty arrays for results
$results = [];

// If a country is provided, search for it in the database
if (!empty($country)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// If no country is provided, fetch all countries
if (empty($country)) {
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if results are found
if (!empty($results)) {
    echo "<table>";
    echo "<thead><tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead><tbody>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
        echo "<td>" . htmlspecialchars($row['independence_year']) . "</td>";
        echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    // If no results, show a "not found" message
    echo "<p id='not-found' style='color: red;'>No countries found.</p>";
}
?>
