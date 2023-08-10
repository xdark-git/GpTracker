import $ from "jquery";
/*----------------------------------
    SLIDER FUNCTIONALITY
 -----------------------------------*/
$(function () {
    const $sliderSection = $("#slideshow-container");
    const $sliders = $sliderSection.find(".my-slides");
    const $slidersButtons = $sliderSection.find(".buttons");
    const $dotsContainer = $slidersButtons.find("ul");
    let $dots = $dotsContainer.find(".dot");
    let currentIndex = 0;
    let slideInterval;
    const intervalTime = 7000;
    const $pausePlayButton = $(".pause-play");
    const $pauseIcon = $pausePlayButton.find(".fa-pause");
    const $playIcon = $pausePlayButton.find(".fa-play");
    const $backButton = $(".back");
    const $nextButton = $(".next");

    // Add/retrieve dots if the number of dots is not equal to the number of sliders
    if ($sliders.length !== $dots.length) {
        const dotsToAdd = $sliders.length - $dots.length;
        if (dotsToAdd > 0) {
            for (let i = 0; i < dotsToAdd; i++) {
                $dotsContainer.append('<li class="dot"></li>');
            }
        } else {
            for (let i = 0; i > dotsToAdd; i--) {
                $dotsContainer.children().last().remove();
            }
        }
        $dots = $dotsContainer.find(".dot");
    }

    // show slide at currentIndex
    function showSlide() {
        $sliders.removeClass("show");
        $dots.removeClass("active");
        $sliders.eq(currentIndex).addClass("show");
        $dots.eq(currentIndex).addClass("active");
        stopSlider();
        startSlider();
    }

    // Move to next slide
    function moveToNext() {
        currentIndex++;
        if (currentIndex === $sliders.length) {
            currentIndex = 0;
        }
        showSlide();
    }

    // Move to previous slide
    function moveToPrev() {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = $sliders.length - 1;
        }
        showSlide();
    }

    // Start slider
    function startSlider() {
        slideInterval = setInterval(moveToNext, intervalTime);
        $pauseIcon.removeClass("hidden");
        $playIcon.addClass("hidden");
    }

    // Stop slider
    function stopSlider() {
        clearInterval(slideInterval);
        $pauseIcon.addClass("hidden");
        $playIcon.removeClass("hidden");
    }

    // Pause/play button click event
    $pausePlayButton.on("click", function () {
        if ($pauseIcon.hasClass("hidden")) {
            startSlider();
        } else {
            stopSlider();
        }
    });

    // Back button click event
    $backButton.on("click", function () {
        stopSlider();
        moveToPrev();
    });

    // Next button click event
    $nextButton.on("click", function () {
        stopSlider();
        moveToNext();
    });

    // Dot click event
    $dots.on("click", function () {
        stopSlider();
        currentIndex = $dots.index(this);
        showSlide();
    });

    // Start the slider
    startSlider();
});

/*----------------------------------
    SEARCH ROOM SECTION FUNCTIONALITY
 -----------------------------------*/
$(function () {
    const $form = $(".container > .search-salon > .content");
    const $inputs = $form.find("input");

    $inputs.each(function () {
        // Show Xmark icon if the input has a value
        if ($(this).val().length > 0) {
            $(this).siblings(".fa-xmark").show();
        }
    });

    // Show/hide Xmark icon based on input value
    $inputs.on("input", function () {
        if ($(this).val().length > 0) {
            $(this).siblings(".fa-xmark").show();
        } else {
            $(this).siblings(".fa-xmark").hide();
        }
    });

    // Clear input when Xmark icon is clicked
    var $xMarks = $form.find(".fa-xmark");
    $xMarks.on("click", function () {
        $(this).siblings("input").val("");
        $(this).hide();
    });
});
