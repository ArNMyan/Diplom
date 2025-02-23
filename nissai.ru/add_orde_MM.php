<?php
// Подключение к базе данных
$servername = "localhost";
$username = "u2660002_NikitaN";
$password = "qL6rU0qP9idY8iZ2";
$dbname = "u2660002_Nissai";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Установка кодировки соединения с базой данных на UTF-8
$conn->set_charset("utf8mb4");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных формы заказа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $order_type = $_POST["order_type"];
    $order_status = $_POST["order_status"];
    $master_name = $_POST["master_name"];

    // Вставка данных заказа в таблицу
    $sql = "INSERT INTO orders (customer_name, order_type, order_status, master_name, order_date)
            VALUES ('$customer_name', '$order_type', '$order_status', '$master_name', CURDATE())";

    if ($conn->query($sql) === TRUE) {
        echo "Заказ успешно добавлен!";
    } else {
        echo "Ошибка при добавлении заказа: " . $conn->error;
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>