import $ from "jquery";
/*---------------------------------
    ADDING * IN ALL REQUIRED LABEL
---------------------------------*/

$(function() {
    const $contactForm = $("#contact-form");

    $contactForm.find('input[required], textarea[required]').each(function() {
      var label = $('label[for="' + $(this).attr('id') + '"]');
      label.append(' *');
    });
  });