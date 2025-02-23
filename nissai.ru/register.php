<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $servername = "Localhost";
    $username = "u2660002_NikitaN";
    $password = "qL6rU0qP9idY8iZ2";
    $dbname = "u2660002_Nissai";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="Maket.CSS">
</head>
<body>
    <section class="contacts">
        <h2 class="heading"><span>Регистрация</span></h2>
        <div class="row">
            <form action="register.php" method="POST">
                <span>Имя пользователя</span>
                <input type="text" name="username" class="box" required placeholder="Имя пользователя" autocomplete="off">
                
                <span>Email</span>
                <input type="email" name="email" class="box" required placeholder="Email" autocomplete="off">
                
                <span>Пароль</span>
                <input type="password" name="password" class="box" required placeholder="Пароль" autocomplete="off">
                
                <input type="submit" value="Регистрация" class="btn btn__small" name="register">
            </form>
        </div>
    </section>
</body>
</html>