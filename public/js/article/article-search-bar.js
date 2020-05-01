'use strict';

$(document).ready(function () {

    $('#search-bar').on('keyup', delay(function (e) {
        e.preventDefault();

        $('#ajax-list').empty();

        const FOLDER_UPLOADS = 'uploads/article_image/';

        let input = $(this).val();
        let minLength = 3;
        if (input.length < minLength) {
            $('#articles').fadeIn(1000);
        }
        if (input.length >= 3) {
            $.ajax({
                type: 'GET',
                url: "search",
                processData: "false",
                data: 'search=' + input,
                success: function (response) {

                    if ($(response).length === 0) {
                        $('<h3 id="no-result"><img src="https://img.icons8.com/ios-glyphs/60/000000/nothing-found.png"> Aucun resultat ne correspond à votre recherche.</h3>').hide().appendTo('#ajax-list').show('slow');
                        $('#articles').fadeOut();
                    } else {
                        $('#articles').hide('slow');
                        $(response).each(function (index) {
                            let date = new Date(response[index].created_at);
                            $(`<article>
                                    <figure>
                                        <h3>${response[index].title}</h3>
                                        <div>
                                        <a href="article/${response[index].id}">
                                            <img src="${FOLDER_UPLOADS}${response[index].image}" alt="${response[index].title}" title="${response[index].title}">
                                        </a>
                                        </div>
                                        <figcaption>${response[index].content.slice(0, 100)}</figcaption>
                                        <a href="article/${response[index].id}" class="read-more">Lire l'article</a>
                                        <p><strong class="date">${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}</strong></p>
                                    </figure>
                            </article>`
                            ).hide().appendTo('#ajax-list').show('slow');
                        });
                    }
                },
                error: function () {
                    $('<h3 id="no-result"> <img src="https://img.icons8.com/ios-glyphs/60/000000/nothing-found.png"> Aucun resultat ne correspond à votre recherche.</h3>').hide().appendTo('#ajax-list').fadeIn(500);
                }
            })
        }
    }, 1000));


    // Fonction qui permet d'eviter de spam la recherche

    function delay(fn, ms) {
        let timer = 0;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }

    // Fonction qui permet d'échapper certains caractères html

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

});