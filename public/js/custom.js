jQuery(function($) {
$(document).ready( function() {

  $('.grid-item .overlay').each(function() {
    color = Math.floor((Math.random() * 4) + 1);
    $(this).addClass('color-'+color);
  });

  $('.grid').packery({
    itemSelector: '.grid-item'
  });
});
});
