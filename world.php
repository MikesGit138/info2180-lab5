<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if (isset($_GET['country'])) {
    $country = $_GET['country'];

    // Check if 'lookup' parameter exists and is set to 'cities'
    $isCityLookup = isset($_GET['lookup']) && $_GET['lookup'] == 'cities';

    if ($isCityLookup) {
        // SQL query for cities
        $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population 
                                FROM cities 
                                JOIN countries ON cities.country_code = countries.code 
                                WHERE countries.name LIKE :country");
    } else {
        // SQL query for country information
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state 
                                FROM countries 
                                WHERE name LIKE :country");
    }

    // Bind the 'country' parameter to the statement
    $stmt->bindValue(':country', "%$country%");

    // Execute the query
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results in an HTML table
    echo "<table border='1'>";
    if ($isCityLookup) {
        echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['district']) . "</td>
                    <td>" . htmlspecialchars($row['population']) . "</td>
                  </tr>";
        }
    } else {
        // Code for handling country information output
        echo "<tr><th>Name</th><th>Continent</th><th>Independence</th>
                <th>Head of State</th></tr>";
        foreach($results as $row){
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['continent']) . "</td>
                    <td>" . htmlspecialchars($row['independence_year']) . "</td>
                    <td>" . htmlspecialchars($row['head_of_state']) . "</td>
                  </tr>";
        }

    }
    echo "</table>";
} else {
    echo "No country specified";
}
?>
