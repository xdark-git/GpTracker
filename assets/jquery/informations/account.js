import $ from "jquery";

/*----------------------------------
    PREVIEW IMAGE ON CHANGE
 -----------------------------------*/
$(function () {
    var $form = $("main > div.gp-informations #user-informations");
    var $inputFile = $form.find("input#profile-picture");
    var $imageContainer = $form.find("img#profile-image-container");

    $inputFile.change(function () {
        var file = this.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $imageContainer.attr("src", e.target.result);
            };

            reader.readAsDataURL(file);
        }
    });
});
