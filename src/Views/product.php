<div class="content">
    <div class="flex-row product">
        <div class="flex-7 product_img">
            <img src="/static/img/<?php echo $product['img_product'];?>">
        </div>

        <div class="flex-5 info">
            <h2 class="title"><?php echo $product['name_product'];?></h2>
            <p class="description"><?php echo $product['description_product'];?></p>
            <p class="description">Поставщик: <?php echo $provider;?></p>
            <p class="description">Категоря: <a href="#"><?php echo $category;?></a></p>
            <p class="description">Вес: <?php echo $product['weight_product'];?> кг</p>
            <p class="description">Цена: <?php echo $product['price_product'];?> руб.</p>
            <p class="button top"><a href="#">В корзину</a></p>
        </div>
    </div>
    <div class="data-php" data-id="<?php echo $product['id_product']; ?>"></div>
    <div class="data" data-name="<?php echo $category_id; ?>"></div>
    <?php if($_SESSION['email']): ?>
    <div class="comment">
        <h1>Комментарии</h1>
        <?php foreach ($comments as $comment): ?>
        <div >
            <h2><?php echo $comment['name_user']?></h2>
            <p><?php echo $comment['text_comment']?></p>
        </div>
        <?php endforeach; ?>
        <div class="fcomment">
        <form name="comm">
            <div>
                <label for="weight">Оставьте комментарий: </label><br />
                <textarea id="comment" name="comment" required></textarea>
<!--                <input type="text" id="comment" name="comment" required>-->
            </div>
            <div class="add">
                <input type="submit" value="Отправить" />
            </div>
        </form>
        </div>
    </div>
    <script src="/static/js/add-comment.js"></script>
    <?php endif; ?>

</div>
