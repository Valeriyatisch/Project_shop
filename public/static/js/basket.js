$(function ()
{
    let link = $('.product-link');
    let cardCount = $("#card-count");
    let deleteButtons = $('.product-delete');
    let minButtons = $('.l-button');
    let plusButtons = $('.r-button');

    minButtons.each(function () {
        $(this).bind('click', function () {
            let pCount = $(this).next();
            let id = pCount.attr('data-product-id');

            $.post( "/minus", { id: id })
                .done(function( data )
                {
                    let result = JSON.parse(data);
                    pCount.html(result.productCount);
                    $('#card-count').html(result.commonCount);

                    let price = $("[data-price=" + id +"]");
                    price.html((result.price * result.productCount) + ' руб.');

                    getCommonPrice();
                });
        });
    });

    plusButtons.each(function () {
        $(this).bind('click', function () {
            let pCount = $(this).prev();
            let id = pCount.attr('data-product-id');

            $.post( "/check", { id: id })
                .done(function( data )
                {
                    let result = JSON.parse(data);
                    pCount.html(result.productCount);
                    $('#card-count').html(result.commonCount);

                    let price = $("[data-price=" + id +"]");
                    price.html((result.price * result.productCount) + ' руб.');

                    getCommonPrice();
                });
        });
    });

    link.bind('click', function () {
        let id = $(this).attr('data-id');

        $.post( "/check", { id: id })
            .done(function( data ) {
                let result = JSON.parse(data);

                $('body').css('overflow-y', 'hidden');

                let count = cardCount.html();

                if(result.commonCount > count)
                {
                    let newElems = $('<div id="zatemnenie"><div id="okno">Товар добавлен в корзину!<br><a class="close">Закрыть</a></div></div>');
                    newElems.appendTo('.product');
                    cardCount.html(result.commonCount);
                }
                else
                {
                    let newElems = $('<div id="zatemnenie"><div id="okno">Товар закончился!<br><a class="close">Закрыть</a></div></div>');
                    newElems.appendTo('.product');
                }

                $('#zatemnenie').bind('click', function () {
                    $('body').css('overflow-y', '');
                    let message = $("#zatemnenie");
                    message.remove();
                })
            });
    });

    deleteButtons.each(function() {
        $(this).bind('click', function () {
            let product_id = $(this).attr('data-delete');

            $.post("/delete", {id: product_id})
                .done(function (data) {

                    if(data != 0)
                        cardCount.html(data);
                    else cardCount.html("");
                });
            $('#' + product_id).remove();
            getCommonPrice();
        })
    });

    function getPrice()
{
    let hPrice = $('.price');
    let price = 0;

}

    function getCommonPrice()
    {
        let prices = $('.price');
        let endPrice = 0;
        for(let elem of prices)
        {
            endPrice += parseInt(elem.innerHTML.split(' ')[0]);
        }

        if(endPrice)
        {
            $('#result').html("Итого: " + endPrice + " руб.");
        }
        else $('#result').html("");
    }

    getCommonPrice();

});