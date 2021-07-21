let validate = require('./validate');

let dataPhp_1 = document.querySelector('.data-php').getAttribute('data-id');
let dataPhp_2 = document.querySelector('.data').getAttribute('data-name');

let errorFlag;
let comment_form = document.forms.comm;
let elems = comment_form.querySelectorAll("textarea");

comment_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(comment_form);

    elems = validate.trimElem(elems);
    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch(`/account/${dataPhp_2}/${dataPhp_1}`, {
                method: 'POST',
                body: new FormData(comment_form)
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
        window.location.replace(`/catalog/${dataPhp_2}/${dataPhp_1}`);
    else if(answer === '0')
        alert('Ошибка добавления данных!');
    else
        alert(answer);
}