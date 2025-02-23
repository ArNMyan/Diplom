<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
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

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: Cabinet.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="Maket.CSS">
</head>
<body>
    <section class="contacts">
        <h2 class="heading"><span>Вход</span></h2>
        <div class="row">
            <form action="login.php" method="POST">
                <span>Имя пользователя</span>
                <input type="text" name="username" class="box" required placeholder="Имя пользователя" autocomplete="off">
                
                <span>Пароль</span>
                <input type="password" name="password" class="box" required placeholder="Пароль" autocomplete="off">
                
                <input type="submit" value="Вход" class="btn btn__small" name="login">
                <a href="register.php" class="btn btn__small">Регистрация</a>
            </form>
        </div>
    </section>
</body>
</html>