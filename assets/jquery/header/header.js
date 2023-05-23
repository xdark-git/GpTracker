import $ from "jquery";

/*----------------------------------
    RESPONSIVE HEADER
 -----------------------------------*/
$(function () {
    var $header = $(".gp-header");
    var $section1 = $header.find("section.section-1");
    var $section2 = $header.find("section.section-2");
    var $headerNav = $header.find("#gp-header-nav");
    var $toggleButton = $header.find("#toggle-menu");
    var $closeMenu = $headerNav.find("i.fa-xmark");
    // var $laguageSwitcher = $section1.find("div.language-switcher");
    var $responsiveLanguageSwitcher = $headerNav.find("li.language-switcher");

    function responsiveNav() {
        var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

        if (width <= 960) {
            $closeMenu.show();
            $toggleButton.show();
            $responsiveLanguageSwitcher.css("display", "flex");
        } else {
            $closeMenu.hide();
            $responsiveLanguageSwitcher.hide();
            $toggleButton.hide();
        }
    }

    responsiveNav();
    $(window).resize(responsiveNav);

    // Show/hide section 2
    $toggleButton.click(function () {
        $section2.toggle();
    });

    // Hide section 2 when clicking xmark or outside the ul
    $(document).on("click", function (event) {
        if ($(event.target).is($closeMenu) || $(event.target).is($section2)) {
            return $section2.hide();
        }
    });
    // Show/hide language options on click
    var $currentLanguage = $headerNav.find("#current-language");
    var $options = $headerNav.find(".options");
    $currentLanguage.click(function () {
        $options.toggle();
    });

    // Hide language options when clicking elsewhere
    $(document).on("click", function (event) {
        if (!$(event.target).closest("#current-language").length) {
            $options.hide();
        }
    });
});

/*----------------------------------
    UPDATE MAIN ELEMENT PADDING TOP
 -----------------------------------*/
$(function () {
    function resizeMainPaddingTop() {
        // Get the height of the header element
        var headerHeight = $("header").outerHeight();

        // Update the padding-top of the main element to match the header height
        $("main").css("padding-top", headerHeight);
    }

    // Initial call to set the padding-top
    resizeMainPaddingTop();

    var resizeObserver = new ResizeObserver(function (entries) {
        // Iterate through the entries
        entries.forEach(function (entry) {
            // Check if the observed target is the header element
            if (entry.target === $("header")[0]) {
                resizeMainPaddingTop();
            }
        });
    });

    // Start observing the header element
    resizeObserver.observe($("header")[0]);
});

/*----------------------------------
            HIDE BANNER
 -----------------------------------*/
$(function () {
    const $banner = $("header").find("section.notification");
    const $xMark = $banner.find("i.fa-xmark");

    setTimeout(function () {
        $banner.hide();
    }, 7000);

    $xMark.click(function () {
        $banner.hide();
    });
});
