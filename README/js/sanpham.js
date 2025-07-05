$(document).ready(function(){
  $(".loaitin").hide(300);
  $(".theloai").click(function(){
    $(".loaitin").slideUp(300);
    $(this).next(".loaitin").slideToggle(300);
  });
});
