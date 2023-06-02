import $ from "jquery";
import { isValidPhoneNumber, isPossibleNumber } from "libphonenumber-js";

/*--------------------------------------
    FORM MULTI STEPS FUNCTIONALITIES
 --------------------------------------*/
$(function () {
    var currentTab = 0;
    showTab(currentTab);

    var $form = $("#roomCreationForm");
    var $nextBtn = $form.find("#btn-next");
    var $previousBtn = $form.find("#btn-previous");

    $nextBtn.on("click", function () {
        // move to the next tab
        currentTab = nextPrevious(currentTab);
        showTab(currentTab);
    });
    $previousBtn.on("click", function () {
        // return to the previous tab
        if (currentTab > 0) {
            currentTab--;
            showTab(currentTab);
        }
    });
});

function showTab(n) {
    var $form = $("#roomCreationForm");
    var $tabs = $form.find(".tab");
    var $previousBtn = $form.find("#btn-previous");
    var $nextBtn = $form.find("#btn-next");
    var $previewBtn = $form.find("#btn-preview");
    var $submitBtn = $form.find("#btn-submit");

    // Show the current tab and hide other tabs
    $tabs.each(function () {
        if ($tabs.index(this) == n) {
            $(this).removeClass("hidden");
        } else {
            $(this).addClass("hidden");
        }
    });
    // Show or Hide the previous button on the first tab
    if (n == 0) {
        $previousBtn.addClass("hidden");
    } else {
        $previousBtn.removeClass("hidden");
    }
    if (n < $tabs.length - 1) {
        // Show the next button and hide the preview button on tabs before the last one
        $nextBtn.removeClass("hidden");
        $previewBtn.addClass("hidden");
    } else {
        // Hide the next button and show the preview button on the last tab
        $nextBtn.addClass("hidden");
        $previewBtn.removeClass("hidden");
    }

    fixStepIndicator(n);
}

function nextPrevious(n) {
    var $form = $("#roomCreationForm");
    var $tabs = $form.find(".tab");

    if (validForm(n, $tabs)) {
        // Increment the currentTab variable if the form is valid and not on the last tab
        return n < $tabs.length - 1 ? (n = n + 1) : n;
    } else {
        return n;
    }
}

function validForm(n, $tabs) {
    var valid = true;
    var $inputs = $tabs.eq(n).find("input");
    $inputs.each(function () {
        // Check if the input is required and has an empty value
        if ($(this).prop("required") && $(this).val() == "") {
            $(this).siblings("label").addClass("error");
            valid = false;
        } else {
            $(this).siblings("label").removeClass("error");
        }
        
        // Check if the input type is "tel" and it has a non-empty value
        if ($(this).attr("type") == "tel" && $(this).val() != "") {
            const phoneNumber = isPossibleNumber($(this).val());
            if (!phoneNumber) {
                $(this).siblings("label").addClass("error");
            } else {
                $(this).siblings("label").removeClass("error");
            }
        }
    });
    return valid;
}

function fixStepIndicator(n) {
    var $nav = $("main .gp-room-creation > .content").find("> .nav");
    var $navList = $nav.find("li");
    var $stepIndicator = $("#roomCreationForm").find("> .form-title .step");

    $navList.each(function () {
        if ($navList.index(this) == n && !$(this).hasClass("current")) {
            // Add "current" class to the current step in the navigation
            $(this).addClass("current");
            // Update the step indicator with the current step and total steps
            $stepIndicator.html(n + 1 + "/" + $navList.length + " :");
        } else if ($navList.index(this) == n && $(this).hasClass("current")) {
            $stepIndicator.html(n + 1 + "/" + $navList.length + " :");
        } else {
            // Remove "current" class from other steps in the navigation
            $(this).removeClass("current");
        }
    });
}
