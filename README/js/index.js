// Hiển thị footer
$(function () {
    $("#include-footer").load("footer.html");
});

// Slideshow chuyển động tịnh tiến 1->2->3->1
$(document).ready(function(){
    let current = 0;
    const slides = $('#slideshow .slide');
    const total = slides.length;
    setInterval(function(){
        slides.eq(current).removeClass('active');
        current = (current + 1) % total;
        slides.eq(current).addClass('active');
    }, 2500); // 2.5 giây đổi ảnh
});
