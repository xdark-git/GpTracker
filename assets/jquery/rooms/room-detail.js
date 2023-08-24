import $ from "jquery";

/*--------------------------------------------
   DROPDOWN MENU
 --------------------------------------------*/

$(function () {
    const dropdownBtn = $("#dropdown-btn");
    const dropdownContent = $(".dropdown-content");

    dropdownBtn.on("click", function () {
        dropdownContent.toggleClass("hidden");
    });

    $(window).on("click", function (event) {
        if (!$(event.target).hasClass("dropdown-btn")) {
            if (dropdownContent.hasClass("hidden")) {
                dropdownContent.toggleClass("hidden");
            }
        }
    });
});

/*--------------------------------------------
    MODAL
 --------------------------------------------*/

$(function () {
    const deleteButton = $("#btn-delete");
    const confirmationModal = $("#confirmationModal");
    const confirmDeleteButton = $("#confirmDelete");
    const cancelDeleteButton = $("#cancelDelete");

    deleteButton.on("click", function () {
        confirmationModal.removeClass("hidden");
    });

    confirmDeleteButton.on("click", function () {
        confirmationModal.addClass("hidden");
    });

    cancelDeleteButton.on("click", function () {
        confirmationModal.addClass("hidden");
    });
});

/*------------------------------------------
    COPY LINK ON CLICK 
--------------------------------------------*/
$(function () {
    $("#copyButton").on("click", function () {
        var link = window.location.href;
        var $confirmationMessage = $("#copied-confirmation");
        navigator.clipboard
            .writeText(link)
            .then(function () {
                $confirmationMessage.removeClass("hidden");
                setTimeout(function () {
                    $confirmationMessage.addClass("hidden");
                }, 1500);
            })
            .catch(function (error) {
                // Clipboard write failed
                // console.error("Unable to copy link to clipboard: ", error);
            });
    });
});
