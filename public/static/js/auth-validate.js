let validate = require('./validate');

let auth_form = document.forms.auth;

let errorFlag;
let elems = auth_form.querySelectorAll("input[type=email], input[type=password]");

auth_form.addEventListener('submit', async (event)=>{
    event.preventDefault();

    errorFlag = false;
    validate.removeError(auth_form);

    errorFlag = validate.checkField(elems, errorFlag);

    if(!errorFlag)
    {
        try{
            const response = await fetch('/login', {
                method: 'POST',
                body: new FormData(auth_form)
            });
            const answer = await response.text();
            console.log("ответ сервера " + answer);
            validate.responseHandler(answer);
        } catch (error) {
            console.log("ошибка", error);
        }
    }
});
