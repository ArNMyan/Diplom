<?php
// Получение данных из запроса
$data = json_decode(file_get_contents("php://input"), true);

error_log("Received update request: " . json_encode($data));

if (isset($data['id']) && isset($data['column']) && isset($data['value'])) {
    // Подключение к базе данных
    $servername = "localhost";
    $username = "u2660002_NikitaN";
    $password = "qL6rU0qP9idY8iZ2";
    $dbname = "u2660002_Nissai";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    $conn->set_charset("utf8mb4");
     
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $data['id'];
    $column = $data['column'];
    $value = $data['value'];

    // Массив допустимых столбцов
    $allowed_columns = ["client_name", "order_name", "master_name", "request_date", "execution_date", "status"];

    if (in_array($column, $allowed_columns)) {
        // Используем подготовленные выражения для предотвращения SQL-инъекций
        $stmt = $conn->prepare("UPDATE orders SET $column = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $id);

        $response = array();
        
        if ($stmt->execute()) {
            $response['success'] = true;
            error_log("Update successful: ID=$id, Column=$column, New Value=$value");
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
            error_log("Update failed: " . $stmt->error);
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Invalid column';
        error_log("Invalid column: $column");
    }

    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    error_log("Invalid input: " . json_encode($data));
}
?>