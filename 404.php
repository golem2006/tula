<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тульский Левша: Семейные традиции</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
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
               <h2>Страница не найдена</h2>
               <img class="img404" src="./img/404samovar.png" alt="404 picture">
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
</html>