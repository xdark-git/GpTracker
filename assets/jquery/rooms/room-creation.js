import $ from "jquery";
import { formatNumber, isPossibleNumber } from "libphonenumber-js";
import currencyCode from "currency-codes";
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
        $submitBtn.addClass("hidden");
    } else {
        // Hide the next button and show the preview button on the last tab
        $nextBtn.addClass("hidden");
        $previewBtn.removeClass("hidden");
        $submitBtn.removeClass("hidden");
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
    var departureDateInput;
    var arrivalDateInput;

    $inputs.each(function () {
        var $input = $(this);
        var inputValue = $input.val();
        var $label = $input.siblings("label");

        if ($input.prop("required") && inputValue === "") {
            $label.addClass("error");
            valid = false;
        } else {
            $label.removeClass("error");
        }

        if ($input.attr("type") === "tel" && inputValue !== "") {
            var phoneNumber = isPossibleNumber(inputValue);
            if (!phoneNumber) {
                $label.addClass("error");
                valid = false;
            } else {
                $(this).val(formatNumber(inputValue, "INTERNATIONAL"));
                $label.removeClass("error");
            }
        }

        if ($input.attr("id") === "departure-date") {
            departureDateInput = $input;
        }

        if ($input.attr("id") === "arrival-date") {
            arrivalDateInput = $input;
        }

        if (
            $input.attr("id") === "room-name" &&
            !($input.val().length >= 5 && $input.val().length <= 12)
        ) {
            $label.addClass("error");
            valid = false;
        }

        if ($input.attr("id") === "currency" && !currencyCode.code(inputValue)) {
            $label.addClass("error");
            valid = false;
        } else if ($input.attr("id") === "currency" && currencyCode.code(inputValue)) {
            $input.val(currencyCode.code(inputValue).code);
        }
    });

    if (departureDateInput && arrivalDateInput) {
        var departureDateValue = departureDateInput.val();
        var arrivalDateValue = arrivalDateInput.val();
        var departureDate = new Date(departureDateValue);
        var arrivalDate = new Date(arrivalDateValue);

        if (departureDate > arrivalDate) {
            departureDateInput.siblings("label").addClass("error");
            arrivalDateInput.siblings("label").addClass("error");
            valid = false;
        }
    }

    var $telInputs = $inputs.filter("[type='tel']");
    var firstTelValue = $telInputs.eq(0).val();
    var secondTelValue = $telInputs.eq(1).val();

    if (
        typeof firstTelValue !== "undefined" &&
        typeof secondTelValue !== "undefined" &&
        firstTelValue !== "" &&
        secondTelValue !== "" &&
        firstTelValue === secondTelValue
    ) {
        $telInputs.eq(1).siblings("label").addClass("error");
        valid = false;
    }

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
            $stepIndicator.next().html($(this).text());
        } else if ($navList.index(this) == n && $(this).hasClass("current")) {
            $stepIndicator.html(n + 1 + "/" + $navList.length + " :");
            $stepIndicator.next().html($(this).text());
        } else {
            // Remove "current" class from other steps in the navigation
            $(this).removeClass("current");
        }
    });
}
