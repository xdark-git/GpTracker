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

$(function() {
    const deleteButton = $("#btn-delete");
    const confirmationModal = $("#confirmationModal");
    const confirmDeleteButton = $("#confirmDelete");
    const cancelDeleteButton = $("#cancelDelete");
    console.log(deleteButton.length);
    deleteButton.on("click", function() {
        confirmationModal.removeClass('hidden');
        
    });

    confirmDeleteButton.on("click", function() {
        
        confirmationModal.addClass('hidden');
    });

    cancelDeleteButton.on("click", function() {
        confirmationModal.addClass('hidden');
    });    
});


