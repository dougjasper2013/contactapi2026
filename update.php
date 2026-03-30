<?php
    require 'connect.php';
    header('Content-Type: application.json');
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Parse form data
    $contactID = isset($_POST['contactID']) ? (int) $_POST['contactID'] : 0;
    $firstName = mysqli_real_escape_string($con, $_POST['firstName'] ?? '');
    $lastName = mysqli_real_escape_string($con, $_POST['lastName'] ?? '');
    $emailAddress = mysqli_real_escape_string($con, $_POST['emailAddress'] ?? '');
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber'] ?? '');
    $status = mysqli_real_escape_string($con, $_POST['status'] ?? '');
    $dob = mysqli_real_escape_string($con, $_POST['dob'] ?? '');

    // Validation
    if ($contactID < 1 || $firstName == '' || $lastName == '' || $emailAddress == '' ||
        $phoneNumber == '' || $status == '' || $dob == '')
        {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields.']);
            exit;
        }

    // Check for duplicate email excluding current contact
        $checkEmailSql = "SELECT contactID FROM contacts WHERE emailAddress = '{$emailAddress}' AND contactID != $contactID LIMIT 1";
        $checkEmailResult = mysqli_query($con, $checkEmailSql);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Duplicate email address.']);
                exit;
        }

    // Update contact
    $sql = " UPDATE contacts SET 
        firstName = '$firstName',
        lastName = '$lastName',
        emailAddress = '$emailAddress',
        phoneNumber = '$phoneNumber',
        status = '$status',
        dob = '$dob'
        WHERE contactID = $contactID LIMIT 1";

    if (mysqli_query($con, $sql)) {
        http_response_code(200);
        echo json_encode(['message' => 'Contact updated successfully.']);
    }
    else {
        http_response_code(500);
        echo json_encode(['error' => 'Database update failed.']);
    }

?>