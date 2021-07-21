<div class="content">
    <h1 class="headpage">Кабинет администратора</h1>
    <ul class="flex-row cat_menu">
        <li class="addto"><a href="/account/addto">Добавить продукт</a></li>
        <li class="remove"><a href="/account/remove">Удалить продукт</a></li>
    </ul>
    <div class="data-php" data-attr="<?=$cat_admin; ?>"></div>

    <?php if($cat_admin === 'addto'): ?>
    <form name="productform" enctype="multipart/form-data">
        <div class="add">
            <label for="category">Категория: </label><br />
            <select id="category" name="category" required>
                <?php foreach ($data['category'] as $category): ?>
                    <option value="<?php echo $category['id_category']?>"><?php echo $category['name_category']?></option>
                <?php endforeach;  ?>
            </select>
        </div>

        <div class="add">
            <label for="provider">Поставщик: </label><br />
            <select id="provider" name="provider" required>
                <?php foreach ($data['provider'] as $provider): ?>
                    <option value="<?php echo $provider['id_provider']?>"><?php echo $provider['name_provider']?></option>
                <?php endforeach;  ?>
            </select>
        </div>

        <div class="add">
            <label for="title">Наименование: </label><br />
            <input id="title" name="title" type="text" /> <!--minlength="5" maxlength="50" required-->
        </div>

        <div class="add">
            <label for="description">Описание: </label><br />
            <textarea id="description" name="description"></textarea> <!--minlength="10" maxlength="300" required-->
        </div>

        <div class="add">
            <label for="weight">Вес: </label><br />
           <input type="text" id="weight" name="weight"> <!-- required-->
        </div>

        <div class="add">
            <label for="price">Цена:</label><br />
            <input id="price" name="price" type="text"> <!--min="50" max="10000" required-->
        </div>

        <div class="add">
            <label for="amount">Количество:</label><br />
            <input id="amount" name="amount" type="number" min="1" required>
        </div>

        <div class="add">
            <label for="sale">Скидка: </label><br />
            <input id="sale" name="sale" type="number" value="0"> <!--min="0" max="20"-->
        </div>

        <div class="add">
            <label for="img">Фото товара:</label><br />
            <input id="img" type="file" name="img"> <!--accept="image/*" required-->
        </div>

        <div class="add">
            <input type="submit" value="Добавить" />
        </div>
    </form>
    <script src="/static/js/dist/productForm.js"></script>

<?php elseif ($cat_admin === 'remove'): ?>
    <div id="cakes" class="content">
        <div class="grid caption">
            <?php for($i = 0; $i < count($products); $i++): ?>
                <div>
                    <div class="product <?php echo ($i + 1) % 3 === 1 ? 'box1' : (($i + 1) % 3 === 2 ? 'box2' : 'box3'); ?>">
                        <img src="/static/img/<?php echo $products[$i]['img_product'];?>" />
                        <h5><?php echo $products[$i]['name_product']; ?></h5>
                        <?php if ($products[$i]['sale_product'] !== '0'): ?>
                            <div class="flex-row up cent">
                                <p class="line m-left"> <?php echo $products[$i]['price_product']; ?> руб.</p>
                                <p class="m-left"><?php echo (float) $products[$i]['price_product'] - ((float) $products[$i]['price_product'] *  ( (float) $products[$i]['sale_product'])/100); ?> руб.</p>
                            </div>
                        <?php else: ?>
                            <p><?php echo $products[$i]['price_product']; ?> руб.</p>
                        <?php endif; ?>
                        <div class="button">
                        <a href="/account/remove/<?php echo $products[$i]['id_product'] ?>">Удалить</a>
                        </div>
                    </div>
                </div>
            <?php endfor;?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="/static/js/choose-category.js"></script>



