<?php

include 'dbconnect.php';

// Connect to database
$conn = connectToDatabase();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Generate a unique ID with a receipt-like format
        do {
            $receiptId = generateReceiptId();
        } while (isReceiptIDExists($conn, $receiptId));

        // Insert data into the database
        insertQuery($conn, $receiptId);

    // Close the database connection
    $conn->close();
}


function generateReceiptId() {
    $prefix = "RCPT";
    $date = date("Ymd");       // Get the date today with format ('YEAR, MONTH, DAY')
    $randomNum = mt_rand(100000, 999999);

    return $prefix . "_" .  $date . "_" . $randomNum;
}


function isReceiptIDExists($conn, $receiptId) {        
    // CHECK IF ID EXIST
    $sql = "SELECT COUNT(*) FROM car WHERE receiptId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receiptId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $stmt->close();
    return $count > 0;        
}


function insertQuery($conn, $receiptId) {
    for ($floor = 1; $floor <= 4; $floor++) {
        $sqlCount = "SELECT COUNT(*) AS count FROM car WHERE floor = $floor";
        $resultCount = $conn->query($sqlCount);
        $rowCount = $resultCount->fetch_assoc()['count'];

        if($rowCount == 40) {
            if ($floor == 4){
                return;
            }
            continue;
        }
    
        // Retrieve form data
        $plateNumber = strtoupper($_POST['plateNumber']);
        $vehicleType = strtoupper($_POST['vehicleType']);
        $brand = strtoupper($_POST['brand']);
        $model = strtoupper($_POST['model']);

        $sql = "INSERT INTO car (receiptId, plateNumber, vehicleType, brand, model, floor) VALUES ('$receiptId', '$plateNumber', '$vehicleType', '$brand', '$model', '$floor')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "RECORD SUBMITTED";
            // Send success message back to the JavaScript
            echo json_encode(array('status' => 'success', 'message' => $successMessage));
            
            break;
        } else {
            $errorMessage = "ERROR DELETING RECORD: " . $deleteStmt->error;
            // Send error message back to the JavaScript
            echo json_encode(array('status' => 'error', 'message' => $errorMessage));
        }
    }
}


// Retrieving data for table display
function fetchData($floor, $conn) {
    $sql = "SELECT * FROM car WHERE floor = $floor";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['receiptId'] . "</td>";
            echo "<td>" . $row['plateNumber'] . "</td>";
            echo "<td>" . $row['vehicleType'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td><button onclick=\"editTableRow(this)\">Edit</button></td>";
            echo "</tr>";
        }
    }
}
?>