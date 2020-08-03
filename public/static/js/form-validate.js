let validate = require('./validate');

let product_form = document.forms.productform;

let errorFlag;
let elems = product_form.querySelectorAll("input[type=text], input[type=number], input[type=file], select, textarea");

product_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(product_form);

    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch('/product-form', {
                method: 'POST',
                body: new FormData(product_form)
            });
            const answer = await response.text();
            console.log("ответ сервера " + answer);
            validate.responseHandler(answer);
        } catch (error) {
            console.log("ошибка", error);
        }
    }
});