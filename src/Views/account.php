<div class="content">
    <h1 class="headpage">Личный кабинет</h1>
    <ul class="account-menu flex-row flex-center">
        <li><a href="#">Мои данные</a></li>
    </ul>

    <div>
        <form name="dataform">
            <div class="add">
                <label for="uname">Имя: </label><br />
                <input id="uname" name="uname" type="text" minlength="2" maxlength="50" required value="<?php echo $user['name_user'] ?>"/>
            </div>

            <div class="add">
                <label for="surname">Фамилия: </label><br />
                <input id="surname" name="surname" type="text" minlength="1" maxlength="50" required value="<?php echo $user['surname_user'] ?>">
            </div>

            <div class="add">
                <label for="phone">Телефон: </label><br />
                <input type="text" id="phone" name="phone" required value="<?php echo $user['phone_user'] ?>">
            </div>

            <div class="add">
                <label for="email">E-mail: </label><br />
                <input id="email" name="email" type="email" required value="<?php echo $user['email_user'] ?>">
            </div>

            <div class="add">
                <label for="pwd">Старый пароль: </label><br />
                <input id="pwd" name="pwd" type="password" min="5" max="10" required>
            </div>

            <div class="add">
                <label for="newpwd">Новый пароль: </label><br />
                <input id="newpwd" name="newpwd" type="password" min="5" max="10" required>
            </div>

            <div class="add">
                <label for="bith">Дата рождения: </label><br />
                <input id="bith" name="bith" type="date" value="<?php echo $user['bith_user'] ?>" required>
            </div>

            <div class="add">
                <label for="address">Адрес:</label><br />
                <input id="address" name="address" type="text" maxlength="200" value="<?php echo $user['address_user'] ?>">
            </div>

            <div class="add">
                <input type="submit" value="Изменить" />
            </div>
        </form>
    </div>
</div>

<script src="/static/js/dist/updateForm.js"></script>
