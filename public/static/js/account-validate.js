let validate = require('./validate');

let data_form = document.forms.dataform;

let errorFlag;
let elems = data_form.querySelectorAll("input[type=text], input[type=date], input[type=email], input[type=password]");

data_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(data_form);

    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch('/account', {
                method: 'POST',
                body: new FormData(data_form)
            });
            const answer = await response.text();
            console.log("ответ сервера " + answer);
            validate.responseHandler(answer);
        } catch (error) {
            console.log("ошибка", error);
        }
    }
});