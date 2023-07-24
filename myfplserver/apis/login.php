<?php

// http://localhost/myfplserver/apis/login.php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connection.php";

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$passwordHash = md5($password);

$result = $conn->query("SELECT * FROM students WHERE email = '$email' AND password = '$passwordHash'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['active'] == 0) {
        $response = array(
            "statusCode" => 400,
            "message" => "Tài khoản của bạn chưa được xác thực!"
        );
    } else {
        $response = array(
            "statusCode" => 200,
            "message" => "Đăng nhập thành công",
            "data" => array(
                "id" => $row['id'],
                "idStudents" => $row['idStudents
                '],
                "name" => $row['name'],
                "email" => $row['email'],
                "longitude" => $row['longitude'],
                "latitude" => $row['latitude'],
            )
        );
    }
} else {
    $response = array(
        "statusCode" => 400,
        "message" => "Đăng nhập thất bại! Vui lòng kiểm tra lại."
    );
}
$conn->close();
echo json_encode($response);
?>