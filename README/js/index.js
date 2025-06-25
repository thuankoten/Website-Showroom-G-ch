$(document).ready(function(){
    let current = 0;
    const slides = $('#slideshow .slide');
    const total = slides.length;
    let interval;

    function showSlide(idx) {
        slides.removeClass('active');
        slides.eq(idx).addClass('active');
    }

    function nextSlide() {
        current = (current + 1) % total;
        showSlide(current);
    }

    function prevSlide() {
        current = (current - 1 + total) % total;
        showSlide(current);
    }

    function startAuto() {
        interval = setInterval(nextSlide, 2500);
    }

    function stopAuto() {
        clearInterval(interval);
    }

    $('.slide-btn.next').click(function(){
        stopAuto();
        nextSlide();
        startAuto();
    });

    $('.slide-btn.prev').click(function(){
        stopAuto();
        prevSlide();
        startAuto();
    });

    showSlide(current);
    startAuto();
});
