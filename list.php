<?php
    require 'connect.php';

    $contacts = [];

    $sql = "SELECT contactID, firstName, lastName, emailAddress, phoneNumber, status, dob FROM contacts";

    if ($result = mysqli_query($con, $sql))
    {
        $count = 0;

        while ($row = mysqli_fetch_assoc($result))
        {
            $contacts[$count]['contactID'] = $row['contactID'];
            $contacts[$count]['firstName'] = $row['firstName'];
            $contacts[$count]['lastName'] = $row['lastName'];
            $contacts[$count]['emailAddress'] = $row['emailAddress'];
            $contacts[$count]['phoneNumber'] = $row['phoneNumber'];
            $contacts[$count]['status'] = $row['status'];
            $contacts[$count]['dob'] = $row['dob'];

            $count++;
        }

        echo json_encode(['data'=>$contacts]);
    }
    else
    {
        http_response_code(404);
    }

?>