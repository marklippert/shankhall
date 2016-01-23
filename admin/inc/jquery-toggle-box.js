$(document).ready(function() {
  // $('#admin-left').hide();

  $('.toggle-control')
  .addClass('clickable')
  .bind('click', function() {
    var $control = $(this);
    var $parent = $control.parents('.toggle-box');

    $parent.toggleClass('expanded');
    $parent.find('#admin-left').slideToggle("fast");

    // if control has HTML5 data attributes, use to update text
    if ($parent.hasClass('expanded')) {
      $control.html($control.attr('data-expanded-text'));
    } else {
      $control.html($control.attr('data-text'));
    }
  })
});