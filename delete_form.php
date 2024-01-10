<?php

include 'dbconnect.php';

// Connect to database
$conn = connectToDatabase();

// Process form deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted with the delete button
    if(isset($_POST['delID']) && isset($_POST['delPlateNumber'])) {
        $delID = strtoupper($_POST['delID']);
        $delPlateNumber = strtoupper($_POST['delPlateNumber']);

        $sql = "SELECT * FROM car WHERE receiptId = ? AND plateNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $delID, $delPlateNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        // Execute the statement
        if ($result->num_rows > 0) {
            // If record exists
            $deleteSql = "DELETE FROM car WHERE receiptId = ? AND plateNumber = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("ss", $delID, $delPlateNumber);
            $deleteStmt->execute();

            // Check the affected rows
            if ($deleteStmt->affected_rows > 0) {
                $successMessage = "RECORD DELETED SUCCESSFULLY";
                // Send success message back to the JavaScript
                echo json_encode(array('status' => 'success', 'message' => $successMessage));
            } else {
                $errorMessage = "ERROR DELETING RECORD: " . $deleteStmt->error;
                // Send error message back to the JavaScript
                echo json_encode(array('status' => 'error', 'message' => $errorMessage));
            }

            $deleteStmt->close();
        } else {
            $invalidMessage = "NO RECORDS FOUND";
            // Send error message back to the JavaScript
            echo json_encode(array('status' => 'error', 'message' => $invalidMessage));
        }

        //close statement
        $stmt->close();
    }
    // close database c onnection
    $conn->close();
}

?>