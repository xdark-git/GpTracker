/*--------------------------------------------
   SUBMIT SORT FORM ON CLICK 
 --------------------------------------------*/
$(function () {
 
    const sortSelect = $("#filter-select");

    // Listen for changes to the sort select
    sortSelect.on("change", function() {
        // Get the selected value
        const selectedSort = sortSelect.val();

        // Build the new URL with the selected sort value
        const newUrl = updateUrlParameter(window.location.href, "room_sort[sort]", selectedSort);

        // Redirect to the new URL
        window.location.href = newUrl;
    });

    // Function to update a parameter in the URL
    function updateUrlParameter(url, key, value) {
        const urlObj = new URL(url);
        urlObj.searchParams.set(key, value);
        return urlObj.toString();
    }
});
