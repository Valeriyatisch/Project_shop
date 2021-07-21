let validate = require('./validate');

let data_form = document.forms.dataform;

let errorFlag;
let elems = data_form.querySelectorAll("input[type=text], input[type=date], input[type=email]");
let newPWD = data_form.querySelectorAll("input[type=password]");
let pwdFlag;

data_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    pwdFlag = false;
    validate.removeError(data_form);

    elems = validate.trimElem(elems);
    newPWD = validate.trimElem(newPWD);
    errorFlag = validate.checkField(elems, errorFlag);

    if(!validate.checkEmpty(newPWD[0].value))
    {
        let check = validate.functions.minLength(newPWD[0].value, 5);
        if(check)
        {
            validate.createError(check, newPWD[0]);
            pwdFlag = true;
        }

        check = validate.functions.maxLength(newPWD[0].value, 10);
        if(check)
        {
            validate.createError(check, newPWD[0]);
            pwdFlag = true;
        }
    }

    if(!errorFlag && !pwdFlag)
    {
        try{
            const response = await fetch('/account', {
                method: 'POST',
                body: new FormData(data_form)
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
    {
        alert('Данные сохранены');
    }
    else if(answer === '0')
    {
        alert('Неудалось обновить данные');
    }
    else
    {
        alert(answer);
    }
}