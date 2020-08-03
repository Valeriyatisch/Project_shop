<div class="content">
    <h1 class="headpage">Каталог</h1>
    <ul class="flex-row cat_menu">
        <?php foreach ($category as $cat): ?>
        <li class="<?php echo $cat['id_category']; ?>"><a href="/catalog/<?php echo $cat['id_category']; ?>"><?php echo $cat['name_category']; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="data-php" data-attr="<?=$category_name; ?>"></div>

<div id="cakes" class="content">
    <div class="grid caption">
        <?php for($i = 0; $i < count($products); $i++): ?>
        <div>
            <div class="product <?php echo ($i + 1) % 3 === 1 ? 'box1' : (($i + 1) % 3 === 2 ? 'box2' : 'box3'); ?>">
                <img src="/static/img/<?php echo $products[$i]['img_product'];?>" />
                <h5><?php echo $products[$i]['name_product']; ?></h5>
                <p><?php echo $products[$i]['price_product']; ?> руб.</p>
                <a href="/catalog/<?php echo $category_name ?>/<?php echo $products[$i]['id_product'] ?>">Подробнее...</a>
            </div>
        </div>
        <?php endfor;?>
    </div>
</div>
</div>

<script src="/static/js/choose-category.js"></script>