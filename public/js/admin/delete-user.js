'use strict';

window.addEventListener('DOMContentLoaded', function () {
    let deleteArticle = document.querySelectorAll('.delete-user');

    for (let i = 0; i < deleteArticle.length; i++) {
        deleteArticle[i].addEventListener('click', function(e) {

            if (!window.confirm("Souhaitez vous vraiment supprimer cet utilisateur ?")) {
                e.preventDefault();
            }
        });
    }

});