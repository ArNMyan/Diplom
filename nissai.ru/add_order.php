<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Подключение к базе данных
    $servername = "localhost";
    $username = "u2660002_NikitaN";
    $password = "qL6rU0qP9idY8iZ2";
    $dbname = "u2660002_Nissai";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Установка кодировки соединения с базой данных на UTF-8
    $conn->set_charset("utf8mb4");

    $order_id = $conn->real_escape_string($_POST['order_id']);
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $status = $conn->real_escape_string($_POST['status']);
    $master_name = $conn->real_escape_string($_POST['master_name']);
    $order_name = $conn->real_escape_string($_POST['order_name']);
    $user_id = $_SESSION['user_id'];

    // Вставка или обновление данных заказа
    if (!empty($order_id)) {
        $sql = "UPDATE orders SET client_name='$client_name', status='$status', master_name='$master_name', order_name='$order_name' WHERE id='$order_id' AND user_id='$user_id'";
    } else {
        $sql = "INSERT INTO orders (user_id, client_name, status, master_name, order_name) VALUES ('$user_id', '$client_name', '$status', '$master_name', '$order_name')";
    }

    if ($conn->query($sql) === TRUE) {
        // Перенаправление обратно в кабинет после успешного сохранения
        header("Location: Cabinet.php");
        exit();
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Если данные не отправлены через форму, перенаправляем обратно в кабинет
    header("Location: Cabinet.php");
    exit();
}
?>