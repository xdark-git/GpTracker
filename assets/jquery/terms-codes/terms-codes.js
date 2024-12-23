import $ from "jquery";

/*---------------------------------------
    REDUCE HEADER HEIGHT ON SMOOTH SCROOL
 ------------------------------------------*/
$(function () {
    var $header = $("header");
    var $menu = $(
        "#gp-cu-menu-list, #gp-codeofconduct-menu-list, #measure-menu-list"
    );
    var $list = $menu.find("> li");

    var headerHeight = $header.outerHeight();

    $list.on("click", function (event) {
        // Prevent the default link behavior
        event.preventDefault();

        var target = $(this).find("a").attr("href");

        // Calculate the target position by subtracting the header height from the target element's offset
        var targetPosition = $(target).offset().top - (headerHeight + 20);

        $("html, body").animate(
            {
                scrollTop: targetPosition,
            },
            800
        );
    });
});
