<?php //var_dump($products);?>
<div class="content">
    <h1 class="headpage">Корзина</h1>

    <?php foreach ($products as $product): ?>
    <div id="<?php echo $product['id_product'] ?>" class="product-border">
    <div class="basket-product flex-row">
        <img src="/static/img/<?php echo $product["img_product"]?>">

        <div class="basket-lmargin card">
            <h4><?php echo $product["name_product"]?></h4>

            <p>Вес: <?php echo $product["weight_product"]?> кг</p>
            <p>Категория: <?php echo $product["category"]?></p>
            <p>Цена за шт: <?php echo $product["price_product"]?> руб.</p>
            <div class="flex-row">
                <button class="l-button">-</button>
                <p class="change" data-product-id="<?php echo $product['id_product'] ?>"><?php echo $product['current_count']?></p>
                <button class="r-button">+</button>
            </div>
        </div>

        <div class="product-price">
            <h4 class="price" data-price="<?php echo $product['id_product'] ?>"><?php echo $product["price_product"] * $product['current_count'] ?> руб.</h4>
            <a class="product-delete" data-delete="<?php echo $product['id_product'] ?>">Удалить</a>
        </div>


    </div>
    </div>
    <?php endforeach; ?>

    <div class="flex-row">
        <h4 id="result" class="product-price"></h4>
    </div>
</div>

