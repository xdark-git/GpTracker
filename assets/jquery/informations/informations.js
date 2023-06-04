import $ from "jquery";
import "./contents/account.informations.js";

/*----------------------------------------
    DISPLAY INFORMATION CONTENT ON CLICK
 ---------------------------------------*/
$(function () {
    var $container = $("main > div.gp-informations section.nav-content");
    var $nav = $container.find("> div.nav");
    var $content = $container.find("> div.content");
    var $menuItems = $nav.find("> ul > li");

    function displayOnlyContent() {
        $nav.hide();
        $content.css("display", "flex");
    }

    function hideElement() {
        var width = window.innerWidth > 0 ? window.innerWidth : screen.width;
        if (width <= 960) {
            var pageURL = window.location.href;
            var origin = window.location.origin;
            var pathname = window.location.pathname;

            const startWithOrigin = new RegExp("^" + origin);

            var matchedAnUrl = false;
            // const startWithPageUrl = new RegExp("^" + window.location.href);

            for (let i = 0; i < $menuItems.length; i++) {
                var $href = $($menuItems[i]).find(" > a").attr("href");
                var cleanURL = $href.replace(/[#?].*$/, "");

                if ($href.match(startWithOrigin) && cleanURL === pageURL) {
                    displayOnlyContent();
                    matchedAnUrl = true;
                    break;
                }
                if (!$href.match(startWithOrigin) && cleanURL === pathname) {
                    displayOnlyContent();
                    matchedAnUrl = true;
                    break;
                }
            }

            if (!matchedAnUrl) {
                $nav.show();
                $content.css("display", "none");
            }
        } else {
            $nav.show();
            $content.css("display", "flex");
        }
    }
    hideElement();
    $(window).resize(hideElement);
    
});
