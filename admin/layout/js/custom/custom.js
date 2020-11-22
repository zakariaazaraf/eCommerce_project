$(function(){ // JQUERY FUNCTION WHISH REMOVES PLACEHOLDER TEXT ON FOCUS

    $('[placeholder]').focus(function(){

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function(){

        $(this).attr('placeholder', $(this).attr('data-text'));

    });
});




/* // SAME FUNCTION BUT WITH VANILA JS

const inputs = document.querySelector('.login .form-control')

let inputValue 

inputs.addEventListener('focus', (e) =>{

    inputValue = e.target.getAttribute('placeholder')

    e.target.setAttribute('placeholder', '')

    console.log("focus From console " + inputValue)

});

inputs.addEventListener('blur', (e) =>{

    console.log("Blur from console " + inputValue)

    e.target.setAttribute('placeholder', inputValue);

}) */