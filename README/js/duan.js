let next = document.querySelector('.next')
let prev = document.querySelector('.prev')

// next.addEventListener('click', function(){
//     let items= document.querySelectorAll('.item')
//     document.querySelector('.mainduan').appendChild(items[0])
// })

// prev.addEventListener('click', function(){
//     let items= document.querySelectorAll('.item')
//     document.querySelector('.mainduan').prepend(items[items.length - 1])
// })
// // Chuyển slider dự án
// setInterval(() => {
//     let items = document.querySelectorAll('.item');
//     document.querySelector('.mainduan').appendChild(items[0]);
// }, 3000);
function nextSlide() {
    let items = document.querySelectorAll('.item');
    document.querySelector('.mainduan').appendChild(items[0]);
}

function prevSlide() {
    let items = document.querySelectorAll('.item');
    document.querySelector('.mainduan').prepend(items[items.length - 1]);
}


let autoSlide = setInterval(nextSlide, 3000);


function resetAutoSlide() {
    clearInterval(autoSlide); // Dừng chuyển slide tự động
    autoSlide = setTimeout(() => {
        autoSlide = setInterval(nextSlide, 3000); 
    }, 6000);
}

// Nút next
next.addEventListener('click', function () {
    nextSlide();
    resetAutoSlide(); // Dừng tự động trong 6s
});

// Nút prev
prev.addEventListener('click', function () {
    prevSlide();
    resetAutoSlide(); // Dừng tự động trong 6s
});



// Bắt tất cả các nút lọc
const filterButtons = document.querySelectorAll('.filter-btn');

filterButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    // Xóa class "active" ở tất cả nút
    filterButtons.forEach(b => b.classList.remove('active'));

    // Thêm class "active" vào nút vừa click
    btn.classList.add('active');
  });
});