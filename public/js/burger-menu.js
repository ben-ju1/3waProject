'use strict';

window.addEventListener('DOMContentLoaded', function (e) {

    document.getElementById('button').addEventListener('click', function (e) {

        document.getElementById('firstDiv').classList.toggle('firstDiv');
        document.getElementById('secondDiv').classList.toggle('secondDiv');
        document.getElementById('thirdDiv').classList.toggle('thirdDiv');
    });

    document.addEventListener('click', function (e) {

        let overlay = document.querySelector('.overlay-menu');
        let burgerButton = document.querySelector('#burger-button');
        if (burgerButton.contains(e.target)) {
            return;
        }

        if (e.target !== overlay && !overlay.contains(e.target)) {
            $('.overlay-menu').fadeOut();
            document.getElementById('firstDiv').classList.remove('firstDiv');
            document.getElementById('secondDiv').classList.remove('secondDiv');
            document.getElementById('thirdDiv').classList.remove('thirdDiv');
        }
    });


    // Fade de l'overlay menu mobile en JQuery
    $('#button').on('click', function () {
        $('.overlay-menu').fadeToggle();
    });
});