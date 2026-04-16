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
        require_once('./php/config.php');
        $result = $conn->query('SELECT * FROM `master-classes` WHERE 1');

        $date = $conn->query('SELECT date FROM `master-classes` WHERE 1');
        $date = $date->fetch_assoc();
        
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
        <h2>Расписание</h2>
        <h3>Расписание мастер классов с указанием оставшихся мест</h3>
        <h4>Дата: <?php echo htmlspecialchars($date['date']) ?></h4>
        <table class="table">
            <thead>
                    <tr>
                        <td>Название</td>
                        <th>9:00-10:00</th>
                        <th>10:00-11:00</th>
                        <th>11:00-12:00</th>
                        <th>12:00-13:00</th>
                        <th>13:00-14:00</th>
                        <th>14:00-15:00</th>
                        <th>15:00-16:00</th>
                        <th>16:00-17:00</th>
                        <th>17:00-18:00</th>
                        <th>18:00-19:00</th>
                        <th>19:00-20:00</th>
                        <th>20:00-21:00</th>
                    </tr>
                </thead>
                <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                
                    <tr>
                        <th><?php echo htmlspecialchars($row['title']); ?></th>
                        
                        <?php
                        $accessedTime = json_decode($row['accessedTime']);
                        // Временные интервалы с 9:00 до 21:00
                        $timeSlots = [
                            '9-10', '10-11', '11-12', '12-13',
                            '13-14', '14-15', '15-16', '16-17',
                            '17-18', '18-19', '19-20', '20-21'
                        ];
                    
                        foreach ($timeSlots as $slot) {
                            // Проверяем, есть ли такое поле в $row
                            $value = isset($row[$slot]) ? htmlspecialchars($row[$slot]) : '';
                            if (in_array($slot, $accessedTime)) {
                                echo "<td>$value</td>";
                            } else {
                                echo "<td>-</td>";
                            }
                            
                        }
                        ?>
                        
                    </tr>

            <?php } ?>
        </tbody>
        </table>
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