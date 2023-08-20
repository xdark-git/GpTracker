import $ from "jquery";
/*---------------------------------
    ADDING * IN ALL REQUIRED LABEL
---------------------------------*/

$(function() {
    $('input[required], textarea[required]').each(function() {
      var label = $('label[for="' + $(this).attr('id') + '"]');
      label.append(' *');
    });
  });