<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тульский Левша: Семейные традиции</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body class="dark">
    <?php
    require_once ('./php/config.php');
    $masterClasses = $conn->query('SELECT * FROM `master-classes` WHERE 1');
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
                <a href="#">Главная</a>
                <?php if (!isset($_SESSION['id'])) { ?>
                <a href="./reg.php">Регистрация</a>
                <a href="#auth">Авторизация</a>
                <?php } ?>
                <a href="./schedule.php">Расписание</a>
                <a href="#about">О фестивале</a>
                <a href="#master-class">Мастер классы</a>
                <a href="#search">Поиск</a>
                <a href="#contacts">Контакты</a>
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
            <!-- Слайдер -->
               <section class="slider-container">
                    <div class="slider-wrapper">
                        <div class="slider">
                            <div class="slide" data-slide-index="0">
                                <div class="slide-content">
                                    <img src="./img/plyashem-ot-pechki.jpg" alt="Мастер-класс по росписи пряника">
                                    <div class="info darkBg">
                                        <h3>Интерактивная программа «Прохоровская сласть»</h3>
                                        <p class="description">цикл программ «Пляшем от печки» и знакомит с укладом и бытом ремесленников-кустарей</p>
                                        <div class="row">
                                            <div class="rating">
                                                Рейтинг: 
                                                <span class="star active">★</span>
                                                <span class="star active">★</span>
                                                <span class="star active">★</span>
                                                <span class="star active">★</span>
                                                <span class="star">★</span>
                                            </div>
                                            <a href="./master-class.php?id=1" class="more margLeftAuto">подробнее</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Навигация: Стрелки -->
                        <button class="nav-arrow prev">&lt;</button>
                        <button class="nav-arrow next">&gt;</button>
                    
                        <!-- Навигация: Точки -->
                        <div class="dots-container">
                            <span class="dot active" data-dot-index="0"></span>
                            <span class="dot" data-dot-index="1"></span>
                            <span class="dot" data-dot-index="2"></span>
                        </div>
                    </div>
                </section>
                <section id="auth">
                    <!-- Форма входа -->
                     <div class="formWrapper row nogap">
                        <div class="formImg">
                            <img src="./img/samovar.jpg" alt="Самовар" >
                        </div>
                        
                        <form action="./php/auth.php" method="post" class="gap10 form col">
                            <h2>Вход</h2>
                            <input type="text" placeholder="почта*" name="mail">
                            <input type="password" placeholder="пароль*" name="passw">
                            <input type="submit" value="войти">
                            <i class="smal">Админ: admin@mail.ru 123456</i>
                        </form>
                     </div>
                </section>
                <section id="about">
                    <img class="rightImg" src="./img/masterskaya.jpg" alt="Мастерская">
                           <p class="hightlight">Фестиваль «Тульский Левша: Семейные традиции»: Всей семьей в историю!</p>
                           <p class="smal">Тула всегда славилась своими умельцами. Фестиваль «Тульский Левша: Семейные традиции» — это уникальная возможность прикоснуться
                             к истории и почувствовать дух изобретательства, который веками живет в нашем городе. Мы собрали лучшие традиции тульских 
                             мастеров, чтобы передать их вам и вашим детям.</p>
                             <p class="marb0 hightlight">Программа мероприятия: &nbsp;</p>
                             <p class="smal">• Экскурс в историю. <span class="hightlight">Театрализованное представление</span>, где мастера прошлого встретятся с современниками, чтобы поговорить о творчестве и вдохновении. В программе использованы подлинные предметы быта и современные <span class="hightlight">арт-объекты</span>.</p>
                            <p class="smal">• Ярмарка мастеров. Выставка-продажа работ художников, оружейников и кузнецов, где можно увидеть современное прочтение <span class="hightlight">традиционных ремесел</span>.</p>
                            <p class="smal">• Интерактивная зона «Кузница счастья». Самый завораживающий мастер-класс фестиваля. Под руководством опытных кузнецов гости смогут не только узнать секреты работы с металлом, но и собственноручно выковать небольшой сувенир .</p>
                            <p class="smal">• Музей самоваров под открытым небом. Выставка раритетных и современных самоваров. Кульминация — <span class="hightlight">дегустация</span> ароматного травяного чая «с дымком» из настоящего жарового самовара, растопленного по старинной технологии .</p>
                            <p class="smal">• Детская зона «Секреты резного наличника». Самые маленькие гости узнают, как украшали дома тульские мастера, и смогут <span class="hightlight">собрать свой узор</span> из деревянных элементов .</p>
                            <p class="smal">Специальный гость: <span class="hightlight">Михаил Шуфутинский</span></p>
                        
                </section>
                <section>
                    <video src="./video/XI_Международный_фестиваль_народных_промыслов_Город_ремёсел_торжественно_открылся_в_Вологде.mp4" controls></video>
                </section>
                <section id="master-class">
                    <h2>Мастер-классы</h2>
                    <?php while ($row = $masterClasses->fetch_assoc()) { ?>
                    <div class="card">
                        <h3 class="hightlight"><?php echo htmlspecialchars($row['header']) ?></h3>
                        <img src="<?php echo htmlspecialchars($row['img']) ?>" alt="<?php echo htmlspecialchars($row['img']) ?>">
                        <?php echo ($row['descr']) ?>
                        <div class="row marb30">
                            <div class="col nogap">
                                <p class="smal">Оставшиеся места: </p>
                                <div class="valueEntries"><?php echo htmlspecialchars($row['allEntries']) ?></div>
                            </div>
                            
                            <p class="c-rate">
                                <?php $rate = (int) $row['rate'] ?>
                                <span class="star <?php if ($rate > 0) {echo 'active'; $rate--;} ?>">★</span>
                                <span class="star <?php if ($rate > 0) {echo 'active'; $rate--;} ?>">★</span>
                                <span class="star <?php if ($rate > 0) {echo 'active'; $rate--;} ?>">★</span>
                                <span class="star <?php if ($rate > 0) {echo 'active'; $rate--;} ?>">★</span>
                                <span class="star <?php if ($rate > 0) {echo 'active'; $rate--;} ?>">★</span>
                            </p>
                        </div>
                        <a class="more" href="./master-class.php?id=<?php echo htmlspecialchars($row['id']) ?>">Подробнее</a>
                    </div>
                    <?php } ?>
                </section>
                <section id="search">
                    <h2>Поиск</h2>
                    <input type="text">
                </section>
                <section class="testimonials">
	<div class="container">
        <h2>Отзывы</h2>

      <div class="row">
        <div class="col-sm-12">
          <div id="customers-testimonials" class="owl-carousel row">

            <!--TESTIMONIAL 1 -->
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="/img/pfp.webp" alt="Ава">
                <p>Невероятное, теплое, приветливое место для детей всех возрастов! Тренер Павел Александрович - лучший из лучших, отличный профессионал, любящий детей и свое дело. Ребята очень хорошие, дружные, спортивные.<br>
                <i>19.02.2026</i></p>
              </div>
              <div class="testimonial-name">Иван Иваныч</div>
            </div>
            <!--END OF TESTIMONIAL 1 -->
            <!--TESTIMONIAL 2 -->
            <div class="owl-item active center">
                <div class="item">
                  <div class="shadow-effect">
                    <img class="img-circle" src="/img/pfp.webp" alt="Ава">
                    <p>Очень приятно там находиться, ребенок с первой тренировки влюбился в это место. Успехов вам и побед!<br>
                <i>19.02.2026</i></p>
                  </div>
                  <div class="testimonial-name">Владимир Владимирович</div>
                </div>
            </div>
            
            <!--END OF TESTIMONIAL 2 -->
            <!--TESTIMONIAL 3 -->
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="/img/pfp.webp" alt="Ава">
                <p>Поездка в город Тула, на экскурсию 'Тула- Город Мастеров", прошла замечательно! Организация и сопровождение на отлично!<br>
                <i>19.02.2026</i></p>
              </div>
              <div class="testimonial-name">Пётр Петрович</div>
            </div>
            <!--END OF TESTIMONIAL 3 -->
            
          </div>
        </div>
      </div>
      </div>
    </section>
    <section>
        <form action="" class="newsForm col gap10">
            <h2>Подписаться на новости</h2>
            <input type="email" placeholder="почта*" name="mail">
            <input type="submit" value="Подписаться">
        </form>
    </section>
    <footer id="contacts">
        <nav class="row">
            <a href="+7 (4872) 55-66-77">+7 (4872) 55-66-77</a>
            <a href="info@tula-levsha.ru">info@tula-levsha.ru</a>
            <?php
                if (!isset($_SESSION['id'])) { ?>
                <a href="./reg.php">Регистрация</a>
                <a href="#auth">Авторизация</a>
            <?php } ?>
            <a href="./account.phpphp">Личный кабинет</a>
            <a href="#master-class">Мастер классы</a>
        </nav>
    </footer>
        </main>
    </div>
    <script src="./js/darkMode.js"></script>
</body>
</html>