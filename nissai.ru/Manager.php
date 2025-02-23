<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет менеджера</title>
    <link rel="stylesheet" href="Maket.CSS">
</head>
<body>
    <header class="headerCab">
        <div class="container">
            <img src="./Nissai_Name.png" class="header_logoCab">
            <img src="./Nissai_Logo.png" class="NissaiCab">

            <nav class="header__navCab">
                <ul class="header__listCab">
                  <li><a class="activeCab" href="#!">Главная</a></li>
                  <li><a class="activeCab" href="#!">О нас</a></li>
                  <li><a class="activeCab" href="#!">Наши предложения</a></li>
                  <li><a class="activeCab" href="#!">Услуги</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="add-data-section">
        <section class="add-data-section">
        <h2 class="heading"><span>Добавить информацию</span></h2>
        <div class="add-data-form">
            <form action="process_add_data.php" method="POST">
                <input type="text" name="client_name" placeholder="Имя клиента" required>
                <input type="text" name="order_name" placeholder="Название заказа" required>
                <input type="text" name="master_name" placeholder="Имя мастера" required>
                <input type="date" name="request_date" placeholder="Дата заявки" required>
                <input type="date" name="execution_date" placeholder="Срок исполнения" required>
                <input type="text" name="status" placeholder="Статус" required>
                <button type="submit">Добавить</button>
            </form>
        </div>
    </section>
        </div>
    </section>

    <section class="table-section">
        <h2 class="heading"><span>Рабочая зона</span></h2>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Поиск...">
        </div>
        <div class="table-container">
            <table id="managerTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Клиент</th>
                        <th onclick="sortTable(1)">Заказ</th>
                        <th onclick="sortTable(2)">Мастер</th>
                        <th onclick="sortTable(3)">Дата заявки</th>
                        <th onclick="sortTable(4)">Срок исполнения</th>
                        <th onclick="sortTable(5)">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 1. Создание соединения с базой данных
                    $servername = "localhost";
                    $username = "u2660002_NikitaN";
                    $password = "qL6rU0qP9idY8iZ2";
                    $dbname = "u2660002_Nissai";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Установка кодировки соединения с базой данных на UTF-8
                    $conn->set_charset("utf8mb4");
                    // Проверка соединения
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // 2. Выполнение запроса к базе данных
                    $sql = "SELECT id, client_name, order_name, master_name, request_date, execution_date, status FROM orders";
                    $result = $conn->query($sql);

                    // 3. Обработка результатов запроса и вывод данных в таблицу
                    if ($result->num_rows > 0) {
                        // Вывод данных каждой строки
                        while($row = $result->fetch_assoc()) {
                            echo "<tr data-id='" . $row["id"] . "'>";
                            echo "<td class='editable' data-column='client_name'>" . $row["client_name"] . "</td>";
                            echo "<td class='editable' data-column='order_name'>" . $row["order_name"] . "</td>";
                            echo "<td class='editable' data-column='master_name'>" . $row["master_name"] . "</td>";
                            echo "<td class='editable' data-column='request_date'>" . $row["request_date"] . "</td>";
                            echo "<td class='editable' data-column='execution_date'>" . $row["execution_date"] . "</td>";
                            echo "<td class='editable' data-column='status'>" . $row["status"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Нет данных</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const editableCells = document.querySelectorAll('.editable');

        editableCells.forEach(cell => {
            cell.setAttribute('contenteditable', 'true');
            cell.addEventListener('blur', function() {
                const newValue = this.textContent;
                const row = this.closest('tr');
                const id = row.getAttribute('data-id');
                const column = this.getAttribute('data-column');

                fetch('update_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        column: column,
                        value: newValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('отправленно успешно');
                    } else {
                        console.error('Ошибка при обновлении данных:', data.error);
                        alert('Ошибка при обновлении данных: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Поиск по таблице
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#managerTable tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));
                row.style.display = matches ? '' : 'none';
            });
        });

        // Сортировка таблицы
        function sortTable(columnIndex) {
            const table = document.getElementById('managerTable');
            const rows = Array.from(table.rows).slice(1);
            const isSortedAsc = table.querySelectorAll('th')[columnIndex].classList.contains('sorted-asc');
            const isSortedDesc = table.querySelectorAll('th')[columnIndex].classList.contains('sorted-desc');
            
            rows.sort((rowA, rowB) => {
                let cellA = rowA.cells[columnIndex].textContent.trim();
                let cellB = rowB.cells[columnIndex].textContent.trim();

                if (columnIndex === 3 || columnIndex === 4) {
                    // Сортировка по дате
                    cellA = new Date(cellA);
                    cellB = new Date(cellB);
                    return isSortedAsc ? cellA - cellB : cellB - cellA;
                } else {
                    // Сортировка по тексту
                    return isSortedAsc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                }
            });
            
            rows.forEach(row => table.tBodies[0].appendChild(row));
            
            table.querySelectorAll('th').forEach(th => th.classList.remove('sorted-asc', 'sorted-desc'));
            table.querySelectorAll('th')[columnIndex].classList.toggle('sorted-asc', !isSortedAsc && !isSortedDesc);
            table.querySelectorAll('th')[columnIndex].classList.toggle('sorted-desc', isSortedAsc);
        }
    });
    </script>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('.add-data-form form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        // Отправляем данные формы на сервер
        fetch('process_add_data.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Показываем сообщение об успешном добавлении
            location.reload(); // Перезагружаем страницу после добавления данных
        })
        .catch(error => console.error('Ошибка:', error));
         });
    });
    </script>
</body>
</html>