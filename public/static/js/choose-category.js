
let dataPhp = document.querySelector('.data-php').getAttribute('data-attr');

if(dataPhp !== 'all')
{
    let elem = document.getElementsByClassName(dataPhp);
    elem[0].children[0].style.cssText = ` 
    color: #fe3432;
    text-decoration: underline;`;
}
