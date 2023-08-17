import $ from "jquery";
import { formatNumber, isPossibleNumber } from "libphonenumber-js";
import currencyCode from "currency-codes";
/*--------------------------------------------
    FORM INPUTS TYPE DATE START DATE && ENDS
 --------------------------------------------*/
$(function () {
    const $dateInput = $(".gp-room-datepicker");

    // Get today's date and add one month
    const today = new Date();
    const oneMonthFromToday = new Date(today);
    oneMonthFromToday.setMonth(oneMonthFromToday.getMonth() + 1);

    // Format dates to 'YYYY-MM-DD' (required for the input's 'min' and 'max' attributes)
    const todayFormatted = today.toISOString().split("T")[0];
    const oneMonthFromTodayFormatted = oneMonthFromToday
        .toISOString()
        .split("T")[0];

    $dateInput.attr("min", todayFormatted);
    $dateInput.attr("max", oneMonthFromTodayFormatted);
});

/*--------------------------------------
    FORM MULTI STEPS FUNCTIONALITIES
 --------------------------------------*/
$(function () {
    var currentTab = 0;
    showTab(currentTab);

    var $form = $("#roomCreationForm");
    var $nextBtn = $form.find("#btn-next");
    var $previousBtn = $form.find("#btn-previous");
    var $submitBtn = $form.find("#btn-submit");
    var $previewBtn = $form.find("#btn-preview");

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

    $previewBtn.on("click", function () {
        if (validForm(null, $form)) {
            displayPreviewDialog();
        } else {
            // display the first element where the error was found
            var $element = $form.find("*:has(label.error):first");
            var $elementTab = $element.closest(".tab");
            var $tabs = $form.find(".tab");
            currentTab = $tabs.index($elementTab);
            showTab(currentTab);
        }
    });

    $submitBtn.on("click", function () {
        if (validForm(null, $form)) {
            $form.trigger("submit");
        } else {
            // display the first element where the error was found
            var $element = $form.find("*:has(label.error):first");
            var $elementTab = $element.closest(".tab");
            var $tabs = $form.find(".tab");
            currentTab = $tabs.index($elementTab);
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
        // $submitBtn.addClass("hidden");
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

function validForm(n = null, $tabs) {
    var valid = true;
    var $inputs = n !== null ? $tabs.eq(n).find("input") : $tabs.find("input");
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

        if ($input.attr("type") === "checkbox" && !$input.is(":checked")) {
            $label.addClass("error");
            valid = false;
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

        if (
            $input.attr("id") === "currency" &&
            !currencyCode.code(inputValue)
        ) {
            $label.addClass("error");
            valid = false;
        } else if (
            $input.attr("id") === "currency" &&
            currencyCode.code(inputValue)
        ) {
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

function displayPreviewDialog() {
    var $previewDialog = $("#previewDialog");
    var $form = $("#roomCreationForm");
    var $inputPlaceholders = $previewDialog.find("[id^='for-']");

    $inputPlaceholders.each(function () {
        var placeholderId = $(this).attr("id");
        var inputId = placeholderId.substring(4); // Remove "for-" prefix
        var $input = $("#" + inputId);

        var inputValue;

        if ($input.is("select")) {
            inputValue = $input.find("option:selected").text();
        } else if ($input.is("input[type='date']")) {
            var dateValue = $input.val();
            var date = new Date(dateValue);
            inputValue = date.toLocaleDateString();
        } else {
            inputValue = $input.val();
        }

        if (inputId === "unit-price") {
            let currency = $form
                .find("#currency")
                .find("option:selected")
                .text();
            inputValue = inputValue + " " + currency.split("-")[0];
        }
        if (inputId === "bag-size") {
            inputValue = inputValue + " Kg";
        }

        // Use the inputValue as needed
        $(this).text(inputValue);
    });

    $previewDialog.removeClass("hidden");

    var $closeDialog = $previewDialog.find("> div > .header i.fa-xmark");
    $closeDialog.on("click", function () {
        $previewDialog.addClass("hidden");
    });
}
