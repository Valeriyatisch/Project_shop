<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $page_title?></title>
    <link rel="shortcut icon" href="/static/img/cake-pop.png">
    <link rel="stylesheet" href="/static/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<header>
    <div class="flex-row content">
    <ul class="flex-10 flex-row menu flex-xs-column flex-xxs-column right">
        <li><a href="/ ">Главная</a></li>
        <li class="show">
            <a href="/catalog/all">Каталог</a>
            <ul class="submenu">
                <li><a href="/catalog">Торты</a></li>
                <li><a href="/catalog">Пирожные</a></li>
                <li><a href="/catalog">Пироги</a></li>
                <li><a href="/catalog">Печенье</a></li>
            </ul>
        </li>
        <li><a href="#">Доставка и оплата</a></li>
        <li><a href="#">Контакты</a></li>
    </ul>

    <ul class="flex-2 flex-row menu left">
        <li class="show"><a href="/account/addto"><img src="/static/img/user.png"/></a>
            <ul class="submenu decoration">
                <?php if(isset($_SESSION['email'])): ?>
                <li><a href="/account/addto">Личный кабинет</a></li>
                <li><a href="/logout">Выйти</a></li>
                <?php else: ?>
                <li><a href="/registration">Зарегестрироваться</a></li>
                <li><a href="/login">Войти</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <li><a href="#"><img src="/static/img/basket.png" /></a></li>
    </ul>
    </div>


    <ul class="container flex-xs-column flex-xxs-column vertmenu">
        <li class="show_2"><a href="#">Меню</a>
            <ul class="hide">
                <li><a href="index.html">Главная</a></li>
                <li class="show">
                    <a href="catalog.html">Каталог</a>
                    <ul class="submenu">
                        <li><a href="catalog.html">Торты</a></li>
                        <li><a href="catalog.html">Пирожные</a></li>
                        <li><a href="catalog.html">Пироги</a></li>
                        <li><a href="catalog.html">Печенье</a></li>
                    </ul>
                </li>
                <li><a href="index.html#paydel">Доставка и оплата</a></li>
                <li><a href="index.html#cont">Контакты</a></li>
                <li><a href="blog.html">Блог</a></li>
                <li class="basket"><a href="#"><img src="/static/img/basket.png" /></a></li>
            </ul>
        </li>
    </ul>
</header>

<section class="container">
<?php include_once $content; ?>
</section>

<footer>
    <div class="content flex-row flex-xs-column flex-xxs-column">
        <ul class="flex-4 menu down">
            <li><a href="catalog.html">Каталог</a></li>
            <li><a href="index.html#paydel">Доставка и оплата</a></li>
            <li><a href="blog.html">Контакты</a></li>
        </ul>

        <div class="flex-4 flex-row social flex-xs-column">
            <a href="#"><img src="/static/img/inst.png" /></a>
            <a href="#"><img src="/static/img/vk.png" /></a>
            <a href="#"><img src="/static/img/tel.png" /></a>
        </div>
    </div>
</footer>
</body>
</html>

