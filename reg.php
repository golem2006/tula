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
                <?php
                if (!isset($_SESSION['id'])) { ?>
                <a href="./reg.php">Регистрация</a>
                <a href="./index.php#auth">Авторизация</a>
                <?php } else {
                    echo htmlspecialchars($_SESSION['name'])
                    ?>
                    <img src="./php/<?php echo htmlspecialchars($_SESSION['photo']) ?>" class="pfp">
                    <a href="./account.php">Личный кабинет</a>
                <?php
                }
                ?>
                <a href="./schedule.php">Расписание</a>
                <a href="./index.php#about">О фестивале</a>
                <a href="./index.php#master-class">Мастер классы</a>
                <a href="./index.php#search">Поиск</a>
                <a href="./index.php#contacts">Контакты</a>
                <span id="darkBtn">☼</span>
            </nav>
        </header>
        <main>
    <section>
        <form action="./php/register.php" method="POST" class="newsForm col gap10" enctype="multipart/form-data" id="registrationForm">
                    <h2>Регистрация на фестиваль</h2>

                    <!-- Main participant fields -->
                    <input type="email" placeholder="почта*" name="email" required>
                    <input type="text" placeholder="имя*" name="name" required>
                    <input type="text" placeholder="фамилия*" name="surname" required>

                    <div class="age-input">
                        <input type="number" placeholder="возраст*" name="age" id="ageInput" min="1" max="120" value="18" required>
                        <div class="age-controls">
                            <button type="button" id="ageDecrement">-</button>
                            <button type="button" id="ageIncrement">+</button>
                        </div>
                    </div>

                    <label for="gender">Пол*: </label>
                    <select name="gender" id="gender" required>
                        <option value="муж." selected>Мужской</option>
                        <option value="жен.">Женский</option>
                    </select>

                    <input type="password" name="password" placeholder="пароль*" required>
                    <input type="password" name="password_confirm" placeholder="повторите пароль*" required>

                    <label for="photo">Семейная фотография:</label><br>
                    <input type="file" id="photo" name="photo" accept="image/*"><br>

                    <div class="row">
                        <label for="agreement">Согласие на обработку данных:</label><br>
                        <input type="checkbox" name="agreement" id="agreement" required> Я согласен(-на)<br>
                    </div>

                    <!-- Family members section -->
                    <div class="family-members">
                        <h3>Члены семьи</h3>
                        <div class="family-member" data-member="1">
                            <input type="text" placeholder="фамилия" name="family[1][surname]">
                            <input type="text" placeholder="имя" name="family[1][name]">
                            <input type="number" placeholder="возраст" name="family[1][age]" min="1" max="120">
                            <select name="family[1][gender]">
                                <option value="муж.">Мужской</option>
                                <option value="жен.">Женский</option>
                            </select>
                            <button type="button" class="remove-family-member">Удалить</button>
                        </div>
                    </div>
                    <button type="button" id="addFamilyMember">Добавить члена семьи</button>

                    <input type="submit" value="Зарегистрироваться">
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
    <script src="./js/reg.js"></script>
    <script>
        
        // Age controls
        document.getElementById('ageIncrement').addEventListener('click', function() {
            const ageInput = document.getElementById('ageInput');
            ageInput.value = parseInt(ageInput.value) + 1;
        });

        document.getElementById('ageDecrement').addEventListener('click', function() {
            const ageInput = document.getElementById('ageInput');
            if (parseInt(ageInput.value) > 1) {
                ageInput.value = parseInt(ageInput.value) - 1;
            }
        });

        // Family members management
        let familyMemberCount = 1;

        document.getElementById('addFamilyMember').addEventListener('click', function() {
            familyMemberCount++;
            const familyMembersContainer = document.querySelector('.family-members');

            const newMember = document.createElement('div');
            newMember.className = 'family-member';
            newMember.setAttribute('data-member', familyMemberCount);
            newMember.innerHTML = `
                <input type="text" placeholder="фамилия" name="family[${familyMemberCount}][surname]">
                <input type="text" placeholder="имя" name="family[${familyMemberCount}][name]">
                <input type="number" placeholder="возраст" name="family[${familyMemberCount}][age]" min="1" max="120">
                <select name="family[${familyMemberCount}][gender]">
                    <option value="муж.">Мужской</option>
                    <option value="жен.">Женский</option>
                </select>
                <button type="button" class="remove-family-member">Удалить</button>
            `;

            familyMembersContainer.appendChild(newMember);
        });

        // Remove family member
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-family-member')) {
                e.target.parentElement.remove();
            }
        });

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const passwordConfirm = document.querySelector('input[name="password_confirm"]').value;

            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Пароли не совпадают!');
                return;
            }

            if (!document.getElementById('agreement').checked) {
                e.preventDefault();
                alert('Вы должны согласиться на обработку данных!');
                return;
            }
        });
    </script>
    <script src="./js/darkMode.js"></script>
</body>
</html>