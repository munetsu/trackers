$(function(){
    $('#nav_toggle').click(function(){
        $('#nav_toggle').toggleClass('open');
        $("nav").slideToggle(500);
    });
});