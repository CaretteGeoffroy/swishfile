var imgs = [
    'http://localhost/transfer-system/media/8.jpg',
    'http://localhost/transfer-system/media/2.jpg',
    'http://localhost/transfer-system/media/3.jpg',
    'http://localhost/transfer-system/media/4.jpg',
    'http://localhost/transfer-system/media/5.jpg',
    'http://localhost/transfer-system/media/6.jpg',
    'http://localhost/transfer-system/media/7.jpg',]

var imgNext = document.getElementById("imgNext");
var imgPrev = document.getElementById("imgPrev");
var currentImg = -1;
var MAX_IMAGES = 7;
var CYCLE_DELAY = 20000;
var FADE_DELAY = 2000;

imgNext.onload = function () {
    // When finished loading:
    $(this).fadeIn(FADE_DELAY, function() {
        // When fadeIn ends:
        imgPrev.src = imgs[currentImg]; // Send current image to back
    }); // Fade in loaded image
    window.setTimeout('cycleImages()', CYCLE_DELAY + FADE_DELAY); // Set next cycle
};

cycleImages = function () {
    currentImg++;
    if (currentImg == MAX_IMAGES) currentImg = 0;
    imgNext.style.display = "none"; // Hide before loading
    imgNext.src = imgs[currentImg]; // Load new image. 
    // After imgNext finish loading, onload above will be called
}

cycleImages(); // Call the first cycle
