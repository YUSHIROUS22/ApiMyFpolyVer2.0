<?php

// http://localhost/myfplserver/apis/register.php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connection.php";
include_once "../mail/sendmail.php";
include_once "../utils/helper.php";

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;
$name = $data->name;

$passwordHash = md5($password);

// check mail tôn tại chưa
$result = $conn->query("SELECT * FROM students WHERE email = '$email'");
if ($result->num_rows > 0) {
    $response = array(
        "statusCode" => 400,
        "message" => "Email đã tồn tại"
    );
    echo json_encode($response);
    return;
} else {
    $response = array();

    $idStudent = getIdStudentByEmail($email);
    if ($idStudent == '') {
        $response = array(
            "statusCode" => 404,
            "message" => "Email không hợp lệ! Nhập chính xác email của sinh viên"
        );
    } else {
        // tạo otp
        $otp = strval(rand(1000, 9999));
        // gửi mail
        // sendMail($email, $otp);
    
        // lưu thông tin đăng ký vào database
        $resultRegister = $conn->query("INSERT INTO students VALUES (NULL, '$idStudent', '$email', '$passwordHash', '$name', '', '', '$otp', '0', '1')");
        // trả về kết quả
        if ($resultRegister) {
            $response = array(
                "statusCode" => 200,
                "message" => "Đăng ký thành công",
                "email" => $email,
            );
        } else {
            $response = array(
                "statusCode" => 400,
                "message" => "Đăng ký thất bại"
            );
        }
    }

    echo json_encode($response);
    return;
}
?>