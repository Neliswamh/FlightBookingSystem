let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("slide");

    // Clear the active class from all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }

    // Increment the slide index
    slideIndex++;

    // If the slide index exceeds the number of slides, reset it to 1
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    // Add the active class to the current slide
    slides[slideIndex - 1].classList.add("active");

    // Start the timer for the next slide transition
    setTimeout(showSlides, 10000);
}