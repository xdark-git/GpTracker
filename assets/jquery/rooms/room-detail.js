import $ from "jquery";

/*--------------------------------------------
   DROPDOWN MENU
 --------------------------------------------*/

$(document).ready(function () {
    const dropdownBtn = $("#dropdown-btn");
    const dropdownContent = $(".dropdown-content");

    dropdownBtn.on("click", function () {
        dropdownContent.toggleClass("show");
    });

    $(window).on("click", function (event) {
        if (!$(event.target).hasClass("dropdown-btn")) {
            if (dropdownContent.hasClass("show")) {
                dropdownContent.removeClass("show");
            }
        }
    });
});

/*--------------------------------------------
    MODAL
 --------------------------------------------*/

$(document).ready(function() {
    const deleteButton = $(".del-btn");
    const confirmationModal = $("#confirmationModal");
    const confirmDeleteButton = $("#confirmDelete");
    const cancelDeleteButton = $("#cancelDelete");

    deleteButton.on("click", function() {
        confirmationModal.css("display", "block");
    });

    confirmDeleteButton.on("click", function() {
        
        confirmationModal.css("display", "none");
    });

    cancelDeleteButton.on("click", function() {
        confirmationModal.css("display", "none");
    });

    
    
});


