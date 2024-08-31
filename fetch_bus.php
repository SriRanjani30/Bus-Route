<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "Bus";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$route = trim($conn->real_escape_string($_POST['route']));
$stop = trim($conn->real_escape_string($_POST['stop']));
$time = trim($conn->real_escape_string($_POST['time']));
$conditions = [];
if (!empty($route)) {
    $conditions[] = "bus_no = '$route'";
}
if (!empty($stop)) {
    $conditions[] = "Start = '$stop'";
}
if (!empty($time)) {
    $conditions[] = "Timing = '$time'";
}
if (count($conditions) > 0) {
    $sql = "SELECT * FROM BusDetails WHERE " . implode(' OR ', $conditions);
} else {
    $sql = "SELECT * FROM BusDetails";
}
$result = $conn->query($sql);
$message = "";
if ($result->num_rows > 0) {
    $message .= "<h2>Bus Details:</h2>";
    while($row = $result->fetch_assoc()) {
        $message .= "<p><strong>Bus No:</strong> " . $row["bus_no"]. " | <strong>Start:</strong> " . $row["Start"]. " | <strong>End:</strong> " . $row["End"]. " | <strong>Timing:</strong> " . $row["Timing"]. "</p>";
    }
} else {
    $message = "No buses found for the given criteria.";
}
$conn->close();
file_put_contents('bus_display.html', "<html><body>" . $message . "</body></html>");
header("Location: bus_display.html");
exit();
