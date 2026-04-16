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

    if (!isset($_SESSION['id'])) {
        header('Location: ./index.php#auth');
    }
        require_once('./php/config.php');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $masterclass = trim($_POST['masterclass'] ?? '');
            $time = trim($_POST['time'] ?? '');
            $count = (int)($_POST['count'] ?? 0);
            $id = (int) $_SESSION['id'];

            $delete = (int)($_POST['delete'] ?? ''); // Айди записи которую нужно удалить
            if ($masterclass != '' && $time != '' && !($count < 1 || $count > 10)) {
                $stmt = $conn->prepare("INSERT INTO `orders`(`userId`, `title`, `time`, `count`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issi", $id, $masterclass, $time, $count);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
                
                $stmt->close();
            }
            if ($delete != '') {
                $stmt = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
                $stmt->bind_param("i", $delete);

                if (!$stmt->execute()) {
                    echo '<script>alert("Ошибка")</script>';
                }
                
                $stmt->close();
            }
        }

        $stmt = $conn->prepare('SELECT * FROM `orders` WHERE userId = ?');
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
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
                <?php if (!isset($_SESSION['id'])) { ?>
                <a href="./reg.php">Регистрация</a>
                <a href="./index.php#auth">Авторизация</a>
                <?php } ?>
                <a href="#">Расписание</a>
                <a href="./index.php#about">О фестивале</a>
                <a href="./index.php#master-class">Мастер классы</a>
                <a href="./index.php#search">Поиск</a>
                <a href="./index.php#contacts">Контакты</a>
                <span id="darkBtn">☼</span>
                <?php if (isset($_SESSION['id'])) { ?>
                    <div class="col nogap">
                        <div class="row just">
                            <?php
                            echo htmlspecialchars($_SESSION['name'])
                            ?>
                            <img src="./php/<?php echo htmlspecialchars($_SESSION['photo']) ?>" class="pfp">
                        </div>
                
                        <a href="./account.php">Личный кабинет</a>
                    </div>
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
                <h2>Аккаунт</h2>
        <form action="account.php" class="newsForm col gap10" method="POST">
            <h2>Записаться на мастер класс</h2>
            <div class="row">
                <label for="masterclass">Мастер-класс:</label>
                <select name="masterclass" id="masterclass" required>
                    <option value="" disabled selected>Выберите мастер-класс</option>
                    <option value="Прохоровская сласть">Прохоровская сласть</option>
                    <option value="Театр Петрушки">Театр Петрушки</option>
                    <option value="Чаепитие у Левши">Чаепитие у Левши</option>
                </select>
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
    <section>
        <h2>Мои заявки</h2>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="stylishRow row">
                <div>
                    <?php echo htmlspecialchars($row['title']) ?>
                </div>
                <div>Время:
                    <?php echo htmlspecialchars($row['time']) ?>
                </div>
                <div>Количество участников:
                    <?php echo htmlspecialchars($row['count']) ?>
                </div>
                <div>Статус:
                    <?php echo htmlspecialchars($row['status']) ?>
                </div>
                <?php
                if ($row['status'] == 'Новая') { // Удалить заявку можно только если её не обработал админ
                ?>
                    <form action="" method="POST">
                        <input type="hidden" value="<?php echo htmlspecialchars($row['id']) ?>" name="delete">
                        <input class="cursor" type="submit" value="Отменить">
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
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