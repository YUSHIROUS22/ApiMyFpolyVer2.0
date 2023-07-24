<?php

// http://localhost/myfplserver/apis/getCurrentExam.php?idStudent=1

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connection.php";

$date = date('Y-m-d', time());

$idStudent = $_GET['idStudent'];

$result = $conn->query("SELECT sc.idSchedule, sc.room, sc.period, sc.date, 
                        sc.teacher, sc.class, su.idSubject as idSubject, su.name as nameSubject 
                        FROM schedules sc 
                        JOIN subjects su 
                        ON sc.idSubject = su.id 
                        WHERE sc.date = '$date' 
                        AND sc.idStudent = '$idStudent'
                        AND sc.isStudying = 0");
$response = array();
if ($result->num_rows > 0) {
    $schedules = array();

    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    $response = array(
        'statusCode' => 200,
        'data' => $schedules,
    );
} else {
    $response = array(
        'statusCode' => 404,
        'message' => 'Hiện không có lịch thi',
    );
}
$conn->close();
echo json_encode($response);
?>