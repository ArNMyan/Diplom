<?php
$servername = "localhost";
$username = "u2660002_NikitaN";
$password = "qL6rU0qP9idY8iZ2";
$dbname = "u2660002_Nissai";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// подключение char-8
$conn->set_charset("utf8mb4");

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$client_name = $_POST['client_name'];
$order_name = $_POST['order_name'];
$request_date = $_POST['request_date'];
$execution_date = $_POST['execution_date'];
$status = $_POST['status'];

// Подготовленный запрос для предотвращения SQL-инъекций
$stmt = $conn->prepare("INSERT INTO orders (client_name, order_name, request_date, execution_date, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $client_name, $order_name, $request_date, $execution_date, $status);

if ($stmt->execute()) {
    echo "Новая запись успешно добавлена!";
} else {
    echo "Ошибка при добавлении записи: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>