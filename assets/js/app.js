/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import '../css/dashboard.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

$('.clickable').on('load', () => {
    //$('h1').toggle();
    //$('h1').fadeOut();
    //$('h1').fadeIn();
    //$('h1').fadeToggle();
    //$('h1').slideToggle();//différents effets d'animation
    //$('h1').animate({
    //    opacity: .7,
     //   margin: 30
    //    
    //})
    //$('h1').slideUp().slideDown().animate({opacity : .7, margin: 10});
    $('#test').fadeIn();
   
})


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
