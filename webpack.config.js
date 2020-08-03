const path = require('path');
const webpack = require('webpack');
const validator = require('validator');

module.exports = {
    // настройки webpack
    // точки входа
    entry: {
        productForm: './public/static/js/form-validate.js',
        regForm: './public/static/js/reg-validate.js',
        authForm: './public/static/js/auth-validate.js',
        updateForm: './public/static/js/account-validate.js'
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname + '/public/static/js/', 'dist')
    }
}