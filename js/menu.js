$(document).ready(function(){
	$('.me2').click(function () {
		$('.subMenu2').slideDown('fast');
        $('.subMenu3').slideUp('fast');
        $('.subMenu4').slideUp('fast');
        $('.subMenu5').slideUp('fast');
        $('.subMenu6').slideUp('fast');
        $('.subMenu7').slideUp('fast');
	});
	$('.me3').click(function () {
		$('.subMenu2').slideUp('fast');
		$('.subMenu3').slideDown('fast');
        $('.subMenu4').slideUp('fast');
        $('.subMenu5').slideUp('fast');
        $('.subMenu6').slideUp('fast');
        $('.subMenu7').slideUp('fast');
	});
    $('.me4').click(function () {
        $('.subMenu2').slideUp('fast');
        $('.subMenu3').slideUp('fast');
        $('.subMenu4').slideDown('fast');
        $('.subMenu5').slideUp('fast');
        $('.subMenu6').slideUp('fast');
        $('.subMenu7').slideUp('fast');
    });
    $('.me5').click(function () {
        $('.subMenu2').slideUp('fast');
        $('.subMenu3').slideUp('fast');
        $('.subMenu4').slideUp('fast');
        $('.subMenu5').slideDown('fast');
        $('.subMenu6').slideUp('fast');
        $('.subMenu7').slideUp('fast');
    });
    $('.me6').click(function () {
        $('.subMenu2').slideUp('fast');
        $('.subMenu3').slideUp('fast');
        $('.subMenu4').slideUp('fast');
        $('.subMenu5').slideUp('fast');
        $('.subMenu6').slideDown('fast');
        $('.subMenu7').slideUp('fast');
    });
    $('.me7').click(function () {
        $('.subMenu2').slideUp('fast');
        $('.subMenu3').slideUp('fast');
        $('.subMenu4').slideUp('fast');
        $('.subMenu5').slideUp('fast');
        $('.subMenu6').slideUp('fast');
        $('.subMenu7').slideDown('fast');
    });
    // ----------- MENU EVENTS --------------------------------------
var hasClass = $( "#topButton" ).hasClass( "menuShowButton" );

    $( ".menuHideButton" ).click(function() {
        if (hasClass == false){

            $( ".leftSide" ).animate({
                left: "-=220",
            }, 1000, function() {
                // Animation complete.
            });
            $( ".menuHideButton" ).animate({
                right: "-=30",
            }, 1000, function() {
                // Animation complete.
            });
            $( ".menuHideButton" ).addClass('menuShowButton');
            $( ".menuShowButton" ).empty();
            $( ".menuShowButton" ).append('>>');

            hasClass = $( "#topButton" ).hasClass( "menuShowButton" );
        } else {

            $( ".leftSide" ).animate({
                left: "+=220",
            }, 1000, function() {
                // Animation complete.
            });

            $( ".menuHideButton" ).animate({
                right: "+=30",
            }, 1000, function() {
                // Animation complete.
            });
            $( ".menuHideButton" ).removeClass('menuShowButton');
            $( ".menuHideButton" ).empty();
            $( ".menuHideButton" ).append('<<');

            hasClass = $( "#topButton" ).hasClass( "menuShowButton" );
        }

    });

});