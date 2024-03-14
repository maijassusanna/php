<?php

include_once 'config/db_config.php';
session_start();

// Tarkista, onko käyttäjä kirjautunut sisään
if (!isset($_SESSION['user_id'])) {
    // Ohjaa kirjautumissivulle, jos käyttäjä ei ole kirjautunut sisään
    header('Location: index.php');
    exit;
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Fetch the current hash of the latest block
$sql = "SELECT current_hash FROM blockchain3_table ORDER BY block_index DESC LIMIT 1";
$result = $conn->query($sql);

// Initialize the previous hash based on existing blocks or set a default value
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $previous_hash = $row['current_hash'];
} else {
    // If there are no existing blocks, set an initial hash (genesis hash)
    $previous_hash = 'genesis_hash';  // You can customize this initial value
}

// Get input data
$sql = "SELECT MAX(block_index) AS max_index FROM blockchain3_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $blockchain_index = $row['max_index'] + 1;
} else {
    // If there are no existing blocks, set the block index to 1
    $blockchain_index = 1;
}

$timestamp = date("Y-m-d H:i:sa");
$giver = $_SESSION['user_name']; // Assume the user giving feedback is the current user
$teacher = $_POST['teacher'];
$feedback = $_POST['feedback'];
$data = ''; // You can customize this value based on your requirements

// Calculate the current hash
$current_hash = hash("sha256", $blockchain_index . $timestamp . $previous_hash . $giver . $feedback . $data . $teacher);

// Insert data into the database
$sql = "INSERT INTO blockchain3_table (block_index, timestamp, giver, feedback, data, previous_hash, current_hash, teacher) 
        VALUES ('$blockchain_index', '$timestamp', '$giver', '$feedback', '$data', '$previous_hash', '$current_hash', '$teacher')";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

echo "<div style='margin-top: 10px; padding: 10px; background-color: #dff0d8; border: 1px solid #3c763d; color: #3c763d;'>";
echo "Thank you, $user_name! Your feedback has been successfully recorded.";
echo "</div>";
echo "<br><br>";

// Retrieve and display the blockchain from the database
$sql2 = "SELECT block_index, timestamp, giver, feedback, data, previous_hash, current_hash, teacher FROM blockchain3_table";
$result2 = $conn->query($sql2);


echo "<style>

    body {
        font-family: 'Arial', sans-serif;
        
    }

    table {
        width: 95%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        font-family: 'Arial', sans-serif;
        margin: 0 auto;
    }


    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        white-space: normal;
        word-wrap: break-word;
        max-width: 430px;
        box-sizing: border-box;
    }

    td {
        font-size: 13px;
    }

    th {
        background: #330867;
        min-width: 105px;
        box-sizing: border-box;
        color: #fff;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    h3 {
        text-align: center;
        font-size: 28px;
        background: linear-gradient(to right, #30CFD0 0%, #330867 100%);
        background-clip: text;
        color: transparent;
    }
</style>";

// Display the blockchain data in a table
echo "<table>";
echo "<h3>All Feedbacks</h3>";
echo "<tr>
        <th>Block Index</th>
        <th>Timestamp</th>
        <th>Giver</th>
        <th>Teacher</th>
        <th>Feedback</th>
 
      </tr>";

while ($row = mysqli_fetch_array($result2)) {
    echo "<tr>";
    echo "<td>" . $row['block_index'] . "</td>";
    echo "<td>" . $row['timestamp'] . "</td>";
    echo "<td>" . $row['giver'] . "</td>";
    echo "<td>" . $row['teacher'] . "</td>";
    echo "<td>" . $row['feedback'] . "</td>";

    echo "</tr>";
}

echo "</table>";


// Close the database connection
$conn->close();

?>

<p>You are logged in as <?php echo $user_name; ?> <a href="logout.php">Logout</a></p>