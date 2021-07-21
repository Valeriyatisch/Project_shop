let validate = require('./validate');

let product_form = document.forms.productform;

let errorFlag;
let elems = product_form.querySelectorAll("input[type=text], input[type=number], select, textarea");
let file = product_form.querySelectorAll("input[type=file]");

product_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(product_form);

    console.log(elems);
    elems = validate.trimElem(elems);
    errorFlag = validate.checkField(elems, errorFlag);
    errorFlag = validate.checkField(file, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch('/product-form', {
                method: 'POST',
                body: new FormData(product_form)
            });
            const answer = await response.text();
            console.log("ответ сервера " + answer);
            responseHandler(answer);

        } catch (error) {
            console.log("ошибка", error);
        }
    }
});

function responseHandler(answer)
{
    if(answer === '1')
        window.location.replace('/account/addto');
    else if(answer === '0')
        alert('Ошибка добавления данных!');
    else
        alert(answer);
}
