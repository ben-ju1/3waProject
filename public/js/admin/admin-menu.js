$(document).ready(function() {
   $('#admin-article').on('click', function() {
     $('#admin-article-sub-menu').fadeToggle();
     $('#admin-article-arrow').toggleClass('display-options');
   });

    $('#admin-user').on('click', function() {
        $('#admin-user-sub-menu').fadeToggle();
        $('#admin-user-arrow').toggleClass('display-options');
    });
});