
    <div class="content">
    <h1 class="headpage">Авторизация</h1>

    <form id="auth" name="auth">
        <div class="add">
            <label for="email">E-mail: </label><br />
            <input id="email" name="email" type="email" required placeholder="email@gmail.com"/>
        </div>

        <div class="add">
            <label for="pwd">Пароль: </label><br />
            <input id="pwd" name="pwd" type="password" min="5" max="10" required>
        </div>

        <div class="add">
            <input type="submit" value="Войти" />
        </div>
    </form>
    </div>


<script src="/static/js/dist/authForm.js"></script>