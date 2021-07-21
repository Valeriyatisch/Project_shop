let validate = require('./validate');

let reg_form = document.forms.registration;

let errorFlag;
let elems = reg_form.querySelectorAll("input[type=text], input[type=date], input[type=email], input[type=password]");

reg_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(reg_form);

    elems = validate.trimElem(elems);
    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch('/registration', {
                method: 'POST',
                body: new FormData(reg_form)
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
    if(answer === validate.REGISTRATION_SUCCESS)
    {
        window.location.replace('/login');
    }
    else if(answer === validate.USER_EXISTS)
    {
        alert(validate.USER_EXISTS);
    }
    else if(answer === validate.REGISTRATION_ERROR)
    {
        alert(validate.REGISTRATION_ERROR);
    }
    else
    {
        alert(answer);
    }
}