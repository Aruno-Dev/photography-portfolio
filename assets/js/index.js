import $ from 'jquery';

$('.menu-toggle').click(function() {

  $('ul').toggleClass('opening');
  $(this).toggleClass('open');

})
