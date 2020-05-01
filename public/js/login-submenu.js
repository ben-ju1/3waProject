window.addEventListener('DOMContentLoaded', function () {

    $('.user-login').on('click', function () {
        $('.sub-menu').fadeToggle();
    });

    document.addEventListener('click', function (e) {
        if (document.querySelector('.menu') !== null) {
            let menu = document.querySelector('.menu');

            if (e.target !== menu && !menu.contains(e.target)) {
                $('.sub-menu').fadeOut();
            }
        }
    });
});

