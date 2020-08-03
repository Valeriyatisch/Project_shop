//let validate = require('./validate');
let dataPhp_1 = document.querySelector('.data-php').getAttribute('data-id');
let dataPhp_2 = document.querySelector('.data').getAttribute('data-name');

let comment_form = document.forms.comm;

//let errorFlag;
//let elem = comment_form.querySelectorAll("textarea");

comment_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    try{
        const response = await fetch(`/account/${dataPhp_2}/${dataPhp_1}`, {
            method: 'POST',
            body: new FormData(comment_form)
        });
        const answer = await response.text();
        console.log("ответ сервера " + answer);
        //validate.responseHandler(answer);
    } catch (error) {
        console.log("ошибка", error);
    }

    /*errorFlag = false;
    validate.removeError(product_form);

    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {

    }*/
});