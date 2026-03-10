<?php
    require 'connect.php';
    header('Content-Type: application/json');
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Get the posted data
    $postdata = file_get_contents("php://input");

    if (isset($postdata) && !empty($postdata)) {
        $request = json_decode($postdata);

        // Validate required fields
        if (trim($request->data->firstName) == '' || trim($request->data->lastName) == '' ||
            trim($request->data->emailAddress) == '' || trim($request->data->phoneNumber) == '' ||
            trim($request->data->status) == '' || trim($request->data->dob) == '') {
                http_response_code(400);
                echo json_encode(['message' => 'missing required fields.']);
                exit;
        }

        // Sanitize
        $firstName = mysqli_real_escape_string($con, trim($request->data->firstName));
        $lastName = mysqli_real_escape_string($con, trim($request->data->lastName));
        $emailAddress = mysqli_real_escape_string($con, trim($request->data->emailAddress));
        $phoneNumber = mysqli_real_escape_string($con, trim($request->data->phoneNumber));
        $status = mysqli_real_escape_string($con, trim($request->data->status));
        $dob = mysqli_real_escape_string($con, trim($request->data->dob));

        // Check duplicate email
        $checkEmailSql = "SELECT 1 FROM contacts WHERE emailAddress = '{$emailAddress}'";
        $checkEmailResult = mysqli_query($con, $checkEmailSql);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            http_response_code(409);
            echo json_encode(['message' => 'Duplicate email address.']);
                exit;
        }

        
    }

?>