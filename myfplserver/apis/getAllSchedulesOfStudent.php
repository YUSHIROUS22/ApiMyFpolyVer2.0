<?php

// http://localhost/myfplserver/apis/getAllSchedulesOfStudent.php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connection.php";

$date = date('Y-m-d', time()); // ngay hien tai

$data = json_decode(file_get_contents("php://input"));
$idStudent = $data->idStudent;
$time = $data->time;
$dateResult = date('Y-m-d', $millisecondsResult / 1000); // chuyen milliseconds sang dinh dang ngay thang

if ($time < 0) {
    $temp = $date;
    $date = $dateResult;
    $dateResult = $temp;
}

$result = $conn->query("SELECT sc.idSchedule, sc.room, sc.period, sc.date, 
                        sc.teacher, sc.class, su.idSubject as idSubject, su.name as nameSubject 
                        FROM schedules sc 
                        JOIN subjects su 
                        ON sc.idSubject = su.id
                        AND sc.idStudent = '$idStudent'
                        AND sc.isStudying = 1
                        WHERE sc.date BETWEEN '$date' AND '$dateResult'");
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
        'message' => 'Không tìm thấy lịch học',
    );
}
$conn->close();
echo json_encode($response);
?>