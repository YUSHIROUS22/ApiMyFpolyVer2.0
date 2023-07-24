<?php

// http://localhost/myfplserver/apis/verifyAccount.php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connection.php";

$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$otp = $data->otp;

$result = $conn->query("SELECT * FROM students WHERE email = '$email' AND verifyCode = '$otp'");
$response = array();
if ($result->num_rows > 0) {
    $resultVerify = $conn->query("UPDATE students SET verifyCode = '', active = '1' WHERE email = '$email'");
    if ($resultVerify) {
        $response = array(
            "statusCode" => 200,
            "message" => "Xác thực thành công"
        );
    } else {
        $response = array(
            "statusCode" => 400,
            "message" => "Xác thực thất bại"
        );
    }
} else {
    $response = array(
        "statusCode" => 400,
        "message" => "Xác thực thất bại"
    );
}

$conn->close();
echo json_encode($response);