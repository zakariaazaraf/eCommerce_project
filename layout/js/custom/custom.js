$(()=>{ // JQUERY FUNCTION WHISH REMOVES PLACEHOLDER TEXT ON FOCUS

    $('[placeholder]').focus(function(){

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function(){

        $(this).attr('placeholder', $(this).attr('data-text'));

    });



    // CONVERT PASSWORD TYPE TO TEXT TYPE
    $('.show-pass').hover(function(){
        
        $('.password').attr('type', 'text');

    }, function(){

        $('.password').attr('type', 'password');

    });

    // CONFIRM DELETION OF A {MEMBER, CATEGORY, ...}
    $('.confirm').click(function(){

        return confirm("You're Going To Delete a Member !");

    });

    $('form p span').click(function(){

        // Toggle Between Login And Signup
        $('form.' + $(this).data('class')).addClass('hide').siblings().removeClass('hide');
        
    });

    $(".ads-form input[name=item]").keyup((e)=>{
        $(".card .card-body .card-title").text(e.target.value)
    })

    $(".ads-form textarea").keyup((e)=>{
        $(".card .card-body .card-text:first").text(e.target.value)
    })

    $(".ads-form input[name=made]").keyup((e)=>{
        $(".card .card-body .card-text .text-muted").text(e.target.value)
    })

    $(".ads-form input[name=price]").keyup((e)=>{
        $(".card .price").text("$" + e.target.value)
    })

    
    
    
    
    
    
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


