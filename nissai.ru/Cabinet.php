<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

$user_id = $_SESSION['user_id'];

// Загрузка данных заказа
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$order_data = [
    'id' => '',
    'client_name' => '',
    'order_name' => '',
    'status' => '',
    'master_name' => ''
];

if ($result->num_rows > 0) {
    $order_data = $result->fetch_assoc();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет пользователя</title>
    <link rel="stylesheet" href="Maket.CSS">
</head>
<body>
    <!-- Шапка -->
    <header class="header">
        <div class="container">
            <img src="./Nissai_Name.png" class="header_logoCab">
            <img src="./Nissai.png" class="NissaiCab">
            <nav class="header__navCab">
                <ul class="header__listCab">
                    <li><a class="active" href="Maket.html">Главная</a></li>
                    <li><a class="active" href="Maket.html#company">О нас</a></li>
                    <li><a class="active" href="Maket.html#custums">Наши предложения</a></li>
                    <li><a class="active" href="Maket.html#product">Услуги</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="contacts">
        <h2 class="heading"><span>Личный кабинет</span></h2>
        <div class="row">
            <div class="img">
                <img src="/profileuser.png" class="imgform">
            </div>
            <form action="add_order.php" method="POST">
                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_data['id']; ?>">
                
                <span>Имя клиента</span>
                <input type="text" name="client_name" id="client_name" class="box" required placeholder="Имя клиента" autocomplete="off" value="<?php echo $order_data['client_name']; ?>">
                
                <span>Статус заказа</span>
                <input type="text" name="status" id="status" class="box" required placeholder="Статус заказа" autocomplete="off" value="<?php echo $order_data['status']; ?>">
                
                <span>Мастер</span>
                <input type="text" name="master_name" id="master_name" class="box" required placeholder="Имя мастера" autocomplete="off" value="<?php echo $order_data['master_name']; ?>">
            
                <span>Выбрать услугу</span>
                <select name="order_name" id="order_name" class="box" required>
                    <option value="" disabled <?php echo ($order_data['order_name'] == '' ? 'selected' : ''); ?>>Выбрать услугу</option>
                    <option value="Разработка сайта" <?php echo ($order_data['order_name'] == 'Разработка сайта' ? 'selected' : ''); ?>>Разработка сайта</option>
                    <option value="Доработка сайта" <?php echo ($order_data['order_name'] == 'Доработка сайта' ? 'selected' : ''); ?>>Доработка сайта</option>
                    <option value="Рекламирование сайта" <?php echo ($order_data['order_name'] == 'Рекламирование сайта' ? 'selected' : ''); ?>>Рекламирование сайта</option>
                </select>
                
                <input type="submit" value="Сохранить" class="btn btn__small" name="submit">
            </form>
        </div>
    </section>   
</body>
</html>