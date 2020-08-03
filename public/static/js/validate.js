import validator from 'validator';

export const SUCCESS = 1;
export const ERROR = 0;
export const REGISTRATION_SUCCESS = 'Регистрация прошла успешно';
export const REGISTRATION_ERROR = 'Ошибка регистрации';
export const USER_EXISTS = 'Пользователь с таким логином уже существует';
export const AUTH_ERROR = 'Ошибка авторизации';
export const AUTH_OK = 'Авторизация прошла успешно';
export const PWD_ERROR = 'Неверный пароль';
export const UPDATE_SUCCESS = 'Данные обновлены';
export const UPDATE_ERROR = 'Ошибка обновления даанных';


export let rules = {
    "uname":{
        required: true,
        minLength: 2,
        maxLength: 50
    },
    "surname": {
        required: true,
        minLength: 1,
        maxLength: 50
    },
    "phone" : {
        required: true,
        type: "phone"
    },
    "email" : {
        required: true,
        type: "email"
    },
    "pwd" : {
        required: true,
        minLength: 5,
        maxLength: 10
    },
    "newpwd" : {
        required: true,
        minLength: 5,
        maxLength: 10
    },
    "bith": {
        required: true,
        type: "date"
    },
    "address": {
        maxLength: 200
    },
    "category":{
        required: true,
        type: "int"
    },
    "provider": {
        required: true,
        type: "int"
    },
    "title" : {
        required: true,
        minLength: 5,
        maxLength: 50
    },
    "description" : {
        required: true,
        minLength: 10,
        maxLength: 300
    },
    "weight" : {
        required: true,
        type: "float"
    },
    "price": {
        required: true,
        type: "float",
        min: 50,
        max: 10000
    },
    "amount": {
        required: true,
        type: "int",
        min: 1,
    },
    "sale": {
        required: true,
        type: "int",
        min: 0,
        max: 20
    },
    "img": {
        required: true,
        type: "img"
    }
};

export let functions = {
    required: function (value, rule) {
        if(rule)
        {
            if(validator.isEmpty(value, { ignore_whitespace: true }))
                return "Это поле обязательно для заполнения!";
        }
        return false;
    },
    minLength: function (value, rule) {
        let length = value.length;
        if(length < rule)
            return `Длина не может быть меньше ${rule}!`;
        return false;
    },
    maxLength: function (value, rule) {
        let length = value.length;
        if(length > rule)
            return `Длина не может быть больше ${rule}!`;
        return false;
    },
    min: function (value, rule) {
        if(value < rule)
            return `Значение не может быть меньше ${rule}!`;
        return false;
    },
    max: function (value, rule) {
        if(value > rule)
            return `Значение не может быть больше ${rule}!`;
        return false;
    },
    type: function (value, rule) {
        if(rule === "phone")
        {
            if(validator.isMobilePhone(value, validator.isMobilePhoneLocales, {strictMode: true}))
                return false;
            return "Некорректный номер телефона!";
        }

        if(rule === "email")
        {
            if(validator.isEmail(value))
                return false;
            return "Некорректный email!"
        }

        if(rule === "date")
        {
            if(validator.isDate(value))
                return false;
            return "Неверный формат даты!"
        }
        if(rule === "int")
        {
            if(!validator.isInt(value))
                return "Неправильное значение!";
            return false;
        }

        if(rule === "float")
        {
            if(!validator.isFloat(value))
                return "Неправильное значение!";
            return false;
        }

        if(rule === "img")
        {
            let ext = value.split('.')[1];
            if(ext !== "png" && ext !== "jpg")
            {
                return "Неверный формат файла!";
            }
            return false;
        }
    }
};

export function checkField(elems, errorFlag)
{
    for(let i = 0; i< elems.length; i++)
    {
        for (let key in rules[elems[i].name])
        {
            let returned = functions[key](elems[i].value, rules[elems[i].name][key]);

            if(returned)
            {
                createError(returned, elems[i]);
                errorFlag = true;
                break;
            }
        }
    }
    return errorFlag;
}

export function createError(text, elem)
{
    let error = document.createElement('p');
    error.className = 'error';
    error.innerHTML = text;
    elem.before(error);

}

export function removeError(form)
{
    let errors = form.querySelectorAll('.error');
    for(let i = 0; i < errors.length; i++)
        errors[i].remove();
}

export function responseHandler(answer)
{
    if (answer === ERROR)
    {
        alert("Ошибка добавления данных");
    }
    else if (answer === SUCCESS)
    {
        window.location.replace('/');
    }
    else if(answer === AUTH_OK)
    {
        window.location.replace('/');
    }
    else if(answer === AUTH_ERROR)
    {
        alert(AUTH_ERROR);
    }
    else if(answer === USER_EXISTS)
    {
        alert(USER_EXISTS);
    }
    else if(answer === REGISTRATION_SUCCESS)
    {
        window.location.replace('/login');
    }
    else if(answer === REGISTRATION_ERROR)
    {
        alert(REGISTRATION_ERROR);
    }
    else if(answer === PWD_ERROR)
    {
        alert(PWD_ERROR);
    }
    else if(answer === UPDATE_ERROR)
    {
        alert(UPDATE_ERROR);
    }
    else if(answer === UPDATE_SUCCESS)
    {
        alert(UPDATE_SUCCESS);
        window.location.replace('/account');
    }
}