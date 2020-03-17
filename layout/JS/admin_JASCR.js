
$(document).ready(function() {

    var pass = $('.password_content');

    $('.show-pass').hover(function() {
        pass.attr('type' , 'text');
    } , function() {
        pass.attr('type' , 'password');
    });
    
});