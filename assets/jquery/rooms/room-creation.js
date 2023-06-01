import $ from "jquery";

/*--------------------------------------
    FORM MULTI STEPS FUNCTIONALITIES
 --------------------------------------*/
$(function () {
    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        
        var $form = $("#roomCreationForm");
        var $tabs = $form.find(".tab");
        var $previousBtn = $form.find("#btn-previous");
        var $nextBtn = $form.find("#btn-next");
        var $previewBtn = $form.find("#btn-preview");
        var $submitBtn = $form.find("#btn-submit");

        $tabs.eq(n).removeClass("hidden");

        if (n == 0) {
            $previousBtn.addClass("hidden");
        } else {
            $previousBtn.removeClass("hidden");
        }
        if (n < $tabs.length - 1) {
            $nextBtn.removeClass("hidden");
            $previewBtn.addClass("hidden");
        } else {
            $nextBtn.addClass("hidden");
            $previewBtn.removeClass("hidden");
        }
    }

    function fixStepIndicator(n) {}
});
