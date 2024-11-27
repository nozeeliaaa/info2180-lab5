<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
//$stmt = $conn->query("SELECT * FROM countries");
$country = $_GET['country'];
$lookUp = $_GET['country'];


if (isset($lookUp) || !empty($lookUp)) {

    $stmt = $conn->query("SELECT cities.name, cities.district, cities.population FROM cities INNER JOIN countries ON countries.code=cities.country_code");
    $cityResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

}





if (isset($country) || !empty($country)) {

    $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    

}




?>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Continent</th>
            <th>Independence</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['continent']; ?></td>
            <td><?= $row['independence_year']; ?></td>
            <td><?= $row['head_of_state']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cityResult as $row): ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['district']; ?></td>
            <td><?= $row['population']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>