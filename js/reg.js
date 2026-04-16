document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#registrationForm');
    const familyMembersContainer = document.querySelector('.family-members');
// Валидация и отправка формы регистрации
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Отчистить предыдущие сообщения
        clearErrors();

        // Валидация на стороне клиента
        const isValid = validateForm();

        if (isValid) {
            submitForm();
        }
    });

    function validateForm() {
        let isValid = true;
        const email = form.querySelector('input[name="email"]');
        const name = form.querySelector('input[name="name"]');
        const surname = form.querySelector('input[name="surname"]');
        const age = form.querySelector('input[name="age"]');
        const password = form.querySelector('input[name="password"]');
        const passwordConfirm = form.querySelector('input[name="password_confirm"]');
        const agreement = form.querySelector('input[name="agreement"]');
        const photo = form.querySelector('input[name="photo"]');

        if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            showError(email, 'Пожалуйста, введите корректный email');
            isValid = false;
        }

        if (!name.value.trim()) {
            showError(name, 'Пожалуйста, введите ваше имя');
            isValid = false;
        }

        if (!surname.value.trim()) {
            showError(surname, 'Пожалуйста, введите вашу фамилию');
            isValid = false;
        }

        if (!age.value || age.value < 1 || age.value > 120) {
            showError(age, 'Пожалуйста, введите корректный возраст (1-120)');
            isValid = false;
        }

        if (!password.value || password.value.length < 6) {
            showError(password, 'Пароль должен содержать не менее 6 символов');
            isValid = false;
        }

        if (password.value !== passwordConfirm.value) {
            showError(passwordConfirm, 'Пароли не совпадают');
            isValid = false;
        }

        if (!agreement.checked) {
            showError(agreement, 'Вы должны согласиться на обработку данных');
            isValid = false;
        }

        if (photo.files.length > 0) {
            const file = photo.files[0];
            if (!file.type.match('image.*')) {
                showError(photo, 'Пожалуйста, загрузите изображение');
                isValid = false;
            }
        }

        const familyMembers = form.querySelectorAll('.family-member');
        familyMembers.forEach(member => {
            const memberName = member.querySelector('input[name*="[name]"]');
            const memberSurname = member.querySelector('input[name*="[surname]"]');
            const memberAge = member.querySelector('input[name*="[age]"]');

            if ((memberName.value || memberSurname.value || memberAge.value) &&
                (!memberName.value || !memberSurname.value || !memberAge.value)) {
                showError(member, 'Пожалуйста, заполните все поля для члена семьи или оставьте все пустыми');
                isValid = false;
            }

            if (memberAge.value && (memberAge.value < 1 || memberAge.value > 120)) {
                showError(memberAge, 'Некорректный возраст (1-120)');
                isValid = false;
            }
        });

        return isValid;
    }

    function showError(element, message) {
        if (element.type !== 'checkbox' && !element.classList.contains('family-member')) {
            const error = document.createElement('div');
            error.className = 'error-message';
            error.textContent = message;
            element.parentNode.insertBefore(error, element.nextSibling);
            element.classList.add('error');
        }
        else if (element.type === 'checkbox') {
            const error = document.createElement('div');
            error.className = 'error-message';
            error.textContent = message;
            element.parentNode.insertBefore(error, element.nextSibling);
        }
        else {
            const error = document.createElement('div');
            error.className = 'error-message';
            error.textContent = message;
            element.appendChild(error);
        }
    }

    function clearErrors() {
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());

        const errorFields = form.querySelectorAll('.error');
        errorFields.forEach(field => field.classList.remove('error'));
    }

    function submitForm() {
        const formData = new FormData(form);
        const submitBtn = form.querySelector('input[type="submit"]');
        const originalBtnText = submitBtn.value;

        // Отключение кнопки и показать состояние загрузки
        submitBtn.disabled = true;
        submitBtn.value = 'Отправка...';

        fetch('./php/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(data.message);
                form.reset();
                familyMembersContainer.innerHTML = `
                    <h3>Члены семьи</h3>
                    <div class="family-member" data-member="1">
                        <div class="family-member-fields">
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
                `;
                familyMemberCount = 1;
                location.href = './index.php';
            } else {
                showErrorMessage(data.message);
                if (data.errors) {
                    data.errors.forEach(error => {
                        console.error('Server error:', error);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.value = originalBtnText;
        });
    }

    function showSuccessMessage(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'form-message success';
        successDiv.textContent = message;
        form.insertBefore(successDiv, form.firstChild);

        // Удалить сообщение через 5 секунд
        setTimeout(() => {
            successDiv.remove();
        }, 5000);
    }

    function showErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'form-message error';
        errorDiv.textContent = message;
        form.insertBefore(errorDiv, form.firstChild);

        // Удалить сообщение через 5 секунд
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
});