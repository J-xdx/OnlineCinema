<?php
    switch($_GET['authorization_method'])
    {
        case 'signin': ?>
                            <div style="width: 90%;">
                                <h2>Вход в аккаунт</h2><input type="text" placeholder="Никнейм" id="nickname_field" />
            					<input type="text" placeholder="Пароль" id="password_field" />
            					<input type="button" style="position: relative;" value = "Войти" onclick="signin(document.getElementById('nickname_field').value, document.getElementById('password_field').value)" /><br>
            					<p style="position: relative; cursor: pointer;"><a onclick="authorization('register');"><i>ещё не зарегистрированы?</i></a></p>
        					</div>
        				<? break;
        case 'register': ?>
                            <div style="width: 90%;">
                                <h2>Форма регистрации</h2><input type="text" placeholder="Никнейм" id="nickname_field" />
            					<input type="text" placeholder="Пароль" id="password_field" />
            					<input type="text" placeholder="Ваше имя" id="name_field" />
            					<input type="text" placeholder="Ваша фамилия" id="surname_field" />
            					<input type="button" style="position: relative;" value="Регистрация" onclick="registration(document.getElementById('nickname_field').value, document.getElementById('password_field').value, document.getElementById('name_field').value, document.getElementById('surname_field').value)" />
            					<br>
            					<p style="position: relative; cursor: pointer;"><a onclick="authorization('signin');"><i>войти в аккаунт</i></a></p>
        					</div>
        				<? break;
    }
?>