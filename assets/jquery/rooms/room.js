/*--------------------------------------------
   SUBMIT SORT FORM ON CLICK
 --------------------------------------------*/
$(function () {
    // Get the select element
    var $sortForm = $('#sort-form');
    var $searchForm = $('#search-form');
    var $select = $("#filter-select");

    // Listen for change event on select
    $select.on("change", function () {
        // Submit the form when an option is selected
        $sortForm.trigger('submit');
        $searchForm.trigger('submit');
    });
});
