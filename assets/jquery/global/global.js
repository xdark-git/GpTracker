import $ from "jquery";
/*----------------------------------
    CONVERT ELEMENT TO DIV OR ANCHOR
 -----------------------------------*/
function convertElementToDivOrAnchor() {
    var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

    if (width <= 608) {
        let $container = $("#room-list-container");
        let $rooms = $container.find("> div.room");
        $rooms.each(function () {
            var attributes = {};
            $.each(this.attributes, function () {
                if (this.name !== "undefined" && this.value !== "undefined") {
                    attributes[this.name] = this.value;
                }
            });

            var content = $(this).html();
            var href = $(this).find("div.price-details > a.see-details").attr("href");
            var link = $("<a>").attr(attributes).attr("href", href).html(content);

            $(this).replaceWith(link);
        });
    } else {
        let $container = $("#room-list-container");
        let $rooms = $container.find("> .room");
        $rooms.each(function () {
            var tagName = $(this).prop("tagName");
            if (tagName === "A") {
                var attributes = {};

                $.each(this.attributes, function () {
                    if (this.name !== "href" && this.value !== undefined) {
                        attributes[this.name] = this.value;
                    }
                });

                var content = $(this).html();
                var div = $("<div>").attr(attributes).html(content);

                $(this).replaceWith(div);
            }
        });
    }
}

$(function () {
    convertElementToDivOrAnchor();
    $(window).on("resize", transformElement);
});
