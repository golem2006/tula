<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тульский Левша: Семейные традиции</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <?php
ini_set('log_errors', 1);
ini_set('error_log', './php/error.log');
set_exception_handler(function ($exception) {
    error_log($exception->getMessage());
});

    if (isset($_SESSION['admin'])) {
        if ($_SESSION['admin'] != 'true') { // Если запись в сессии админ не равна true
            header('Location: ./index.php');
            exit;
        }
    } else { // Если нет записи в сессии админ
        header('Location: ./index.php');
        exit;
    }
        require_once('./php/config.php');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $changeStatus = (int)($_POST['changeStatus'] ?? ''); // Айди записи в которой нужно изменить статус
            $status = trim($_POST['status'] ?? '');
            $count = (int)($_POST['count'] ?? '');
            $time = trim($_POST['time'] ?? ''); // Для изменения таблицы доступных мест мастер класса при подтверждении
            $title = trim($_POST['title'] ?? '');

            $changeUser = (int)($_POST['changeUser'] ?? ''); // Айди юзера, которого нужно изменить
            $ban = (int)($_POST['ban'] ?? ''); // Айди юзера, которого нужно забанить
            $deleteUser = (int)($_POST['deleteUser'] ?? ''); // Айди юзера, которого нужно удалить
            if ($changeStatus != '') {
                $stmt = $conn->prepare("UPDATE `orders` SET `status`= ? WHERE id = ?");
                $stmt->bind_param("si", $status, $changeStatus);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
                $stmt->close();
                if ($status == 'Подтверждена') {
                    $shortTime = preg_replace('/(\d+):\d+-(\d+):\d+/', '$1-$2', $time); // Убирает :00 для названия столбца в таблице
                    
                    $masterClasses = ['Прохоровская сласть', 'Театр Петрушки', 'Чаепитие у Левши']; // ! При изменении БД нужно будет изменить
                    // Либо добавить динамическую загрузку названий мастер классов сюда
                    $index = array_search($title, $masterClasses);
                    $index = $index + 1; // Получение Айди строки таблицы БД

                    $stmt = $conn->prepare("UPDATE `master-classes` SET `$shortTime` = `$shortTime` - ? WHERE `id` = ?");
                    $stmt->bind_param("ii", $count, $index);

                    if (!$stmt->execute()) {
                        echo '<script>alert("Ошибка")</script>';
                    }
                    $stmt->close();
                    $stmt = $conn->prepare('UPDATE `master-classes` SET `allEntries` = `9-10` + `10-11` + `11-12` + `12-13` + `13-14` + `14-15` + `15-16` + `16-17` + `17-18` + `18-19` + `20-21` WHERE `id` = ?');
                    $stmt->bind_param("i", $index);

                    if (!$stmt->execute()) {
                        echo '<script>alert("Ошибка")</script>';
                    }
                    $stmt->close();
                }
            }
            if ($changeUser != '') {
                $email = trim($_POST['email'] ?? '');
                $name = trim($_POST['name'] ?? '');
                $surname = trim($_POST['surname'] ?? '');
                $age = (int)($_POST['age'] ?? '');
                $gender = trim($_POST['gender'] ?? '');

                $stmt = $conn->prepare("UPDATE `participants` SET `email`=?,`name`=?,`surname`=?,`age`=?,`gender`=? WHERE id = ?");
                $stmt->bind_param("sssisi", $email, $name, $surname, $age, $gender, $changeUser);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
            }
            if ($ban != '') {

                $stmt = $conn->prepare("UPDATE `participants` SET `banned`= 1 WHERE id = ?");
                $stmt->bind_param("i", $ban);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
            }
            if ($deleteUser != '') {
                $photo = trim($_POST['photo_path'] ?? '');
                if ($photo != '') {
                    if ($photo != 'static/pfp.jpg') {
                        unlink('./php/'.$photo);
                    } // Удаление фото профиля если она есть
                }
                $stmt = $conn->prepare("DELETE FROM `participants` WHERE id = ?");
                $stmt->bind_param("i", $deleteUser);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
                
                $stmt->close();
            }
        }

        $orders = $conn->query('SELECT * FROM `orders` WHERE 1');
        $users = $conn->query('SELECT * FROM `participants` WHERE 1');
    ?>
    <div class="wrapper">
        <header class="col">
            <div class="row">
                <img src="./img/logo.jpg" alt="Логотип" class="logo">
                <div class="col">
                    <h1>Тульский Левша: Семейные традиции</h1>
                    <h2>Фестиваль</h2>
                </div>
            </div>
            
            <nav class="row">
                <a href="./index.php">Главная</a>
                <a href="#">Расписание</a>
                <a href="./index.php#about">О фестивале</a>
                <a href="./index.php#master-class">Мастер классы</a>
                <a href="./index.php#search">Поиск</a>
                <a href="./index.php#contacts">Контакты</a>
                <span id="darkBtn">☼</span>
                <?php if (isset($_SESSION['admin'])) { ?>
                    <div class="margLeftAuto">
                        <a href="./php/exit.php">Выйти</a>
                    </div>
                <?php
                }
                ?>
            </nav>
        </header>
        <main>
        <section>
            <h2>Панель администратора</h2>
            <h2>Все пользователи</h2>
            <?php while ($row = $users->fetch_assoc()) { ?>
                <div class="stylishRow row gap10">
                    <form action="" method="POST" class="row gap10">
                        <div class="col">ID: 
                            <?php echo htmlspecialchars($row['id']) ?>
                        </div>
                        <div class="col">Email:
                            <input type="mail" name="email" value="<?php echo htmlspecialchars($row['email']) ?>">
                        </div>
                        <div class="col">Имя:
                            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']) ?>">
                        </div>
                        <div class="col">Фамилия:
                            <input type="text" name="surname" value="<?php echo htmlspecialchars($row['surname']) ?>">
                        </div>
                        <div class="col">Возраст:
                            <input type="number" name="age" value="<?php echo htmlspecialchars($row['age']) ?>">
                        </div>
                        <div class="col">
                            <label for="gender">Пол*: </label>
                            <select name="gender" id="gender" required>
                                <option value="муж." <?php if ($row['gender'] == 'муж.') {echo 'selected';} ?>>Мужской</option>
                                <option value="жен." <?php if ($row['gender'] == 'жен.') {echo 'selected';} ?>>Женский</option>
                            </select>
                        </div>
                        
                        <div class="col">Создан:
                            <p><?php echo htmlspecialchars($row['created_at']) ?></p>
                        </div>

                        <input type="hidden" value="<?php echo htmlspecialchars($row['id']) ?>" name="changeUser">
                        <input class="cursor" type="submit" value="Изменить">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['id']) ?>" name="ban">
                        <input class="cursor" type="submit" value="Заблокировать">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['id']) ?>" name="deleteUser">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['photo_path']) ?>" name="photo_path">
                        <input class="cursor" type="submit" value="Удалить">
                    </form>

                </div>
            <?php } ?>
        </section>
        
        <section>
            <h2>Все заявки пользователей</h2>
            <?php while ($row = $orders->fetch_assoc()) { ?>
                <div class="stylishRow row">
                    <div>
                        <?php echo htmlspecialchars($row['title']) ?>
                    </div>
                    <div>User ID:
                        <?php echo htmlspecialchars($row['userId']) ?>
                    </div>
                    <div>Время:
                        <?php echo htmlspecialchars($row['time']) ?>
                    </div>
                    <div>Количество участников:
                        <?php echo htmlspecialchars($row['count']) ?>
                    </div>
                    <form action="" method="POST" class="row">
                    <div>
                        <label for="status">Статус: </label>
                        <select name="status" id="status" required>
                            <option value="" disabled selected><?php echo htmlspecialchars($row['status']) ?></option>
                            <option value="Новая">Новая</option>
                            <option value="Подтверждена">Подтверждена</option>
                            <option value="Отклонена">Отклонена</option>
                        </select>
                    </div>

                        <input type="hidden" value="<?php echo htmlspecialchars($row['id']) ?>" name="changeStatus">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['count']) ?>" name="count">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['time']) ?>" name="time">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['title']) ?>" name="title">
                        <input class="cursor" type="submit" value="Изменить статус">
                    </form>
                </div>
            <?php } ?>
        </section>
        <section>
            <form action="admin.php" class="newsForm col gap10" method="POST">
                <h2>Добавить расписание</h2>
                <div class="row">
                    <label for="newTitle">Название:</label>
                    <input type="text" id="newTitle" name="newTitle" required >
                </div>
                <div class="row">
                    <label for="newDescr">Описание:</label>
                    <textarea name="newDescr" id="newDescr"></textarea>
                </div>

                <div class="row">
                    <label for="date">Дата:</label>
                    <input type="date" id="date" name="date" value="2025-07-12" min="2025-07-12" max="2025-07-12" required readonly>
                </div>

                <div class="row">
                    <label for="time">Время:</label>
                    <select name="time" id="time" required>
                        <option value="" disabled selected>Выберите время</option>
                        <option value="9:00-10:00">9:00-10:00</option>
                        <option value="10:00-11:00">10:00-11:00</option>
                        <option value="11:00-12:00">11:00-12:00</option>
                        <option value="12:00-13:00">12:00-13:00</option>
                        <option value="13:00-14:00">13:00-14:00</option>
                        <option value="14:00-15:00">14:00-15:00</option>
                        <option value="15:00-16:00">15:00-16:00</option>
                        <option value="16:00-17:00">16:00-17:00</option>
                        <option value="17:00-18:00">17:00-18:00</option>
                        <option value="18:00-19:00">18:00-19:00</option>
                        <option value="19:00-20:00">19:00-20:00</option>
                        <option value="20:00-21:00">20:00-21:00</option>
                    </select>
                </div>

                <div class="row">
                    <label for="count">Количество участников:</label>
                    <input type="number" id="count" name="count" min="1" max="10" value="1" required>
                </div>
                <input type="submit" value="Записаться">
            </form>
        </section>
        <footer>
            <nav class="row">
                <a href="+7 (4872) 55-66-77">+7 (4872) 55-66-77</a>
                <a href="info@tula-levsha.ru">info@tula-levsha.ru</a>
                 <?php
                    if (!isset($_SESSION['id'])) { ?>
                    <a href="./reg.php">Регистрация</a>
                    <a href="#auth">Авторизация</a>
                <?php } ?>
                <a href="./account.php">Личный кабинет</a>
                <a href="#master-class">Мастер классы</a>
            </nav>
        </footer>
            </main>
        </div>
        <script src="./js/darkMode.js"></script>
</body>
<?php $conn->close(); ?>
</html>