<div class="content">
    <h1 class="headpage">Регистрация</h1>

    <form id="reg" name="registration">
        <div class="add">
            <label for="uname">Имя: </label><br />
            <input id="uname" name="uname" type="text" placeholder="Иван"/> <!--minlength="2" maxlength="50" required-->
        </div>

        <div class="add">
            <label for="surname">Фамилия: </label><br />
            <input id="surname" name="surname" type="text" placeholder="Иванов">
<!--            minlength="1" maxlength="50" required-->
        </div>

        <div class="add">
            <label for="phone">Телефон: </label><br />
            <input type="text" id="phone" name="phone" placeholder="+79999999999">
        </div>

        <div class="add">
            <label for="email">E-mail: </label><br />
            <input id="email" name="email" type="email" placeholder="email@gmail.com">
        </div>

        <div class="add">
            <label for="pwd">Пароль: </label><br />
            <input id="pwd" name="pwd" type="password">
<!--            min="5" max="10" required-->
        </div>

        <div class="add">
            <label for="bith">Дата рождения: </label><br />
            <input id="bith" name="bith" type="date" placeholder="01.01.2001">
        </div>

        <div class="add">
            <label for="address">Адрес:</label><br />
            <input id="address" name="address" type="text" maxlength="200" placeholder="г. Санкт-Петербург, Невский пр-т 44">
        </div>

        <div class="add">
            <input type="submit" value="Зарегестрироваться" />
        </div>
    </form>
</div>

<script src="/static/js/dist/regForm.js"></script>
