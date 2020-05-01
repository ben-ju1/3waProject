'use strict';

window.addEventListener('DOMContentLoaded', function () {
    $('#settings-user li').on('click', function (e) {
        $.ajax({
            type: 'GET',
            url: "/json/profile",
            success: function (response) {
                if ($(e.target).hasClass('profile')) {
                    $('.display').hide();
                    $('.display-profile').show();
                    /**$('.display').empty().append(
                        `
                               <p id="welcome">Bonjour, <em><strong>${response['currentUser']['username']}</strong></em> vous êtes enregistré sous le nom de <strong>${response['currentUser']['firstname']} ${response['currentUser']['lastname']}</strong>
                                   <br>
                                   Votre adresse email est : <strong>${response['currentUser']['email']}</strong>
                                   <br>
                                   Pour modifiez vos informations veuillez cliquez sur le menu de navigation
                               </p>`);
                     */
                } else if ($(e.target).hasClass('security')) {
                    $('.display-profile').hide();
                    $('.display').show().empty().append(response['formAccountSettingsView']['content']);
                } else if ($(e.target).hasClass('informations')) {
                    $('.display-profile').hide();
                    $('.display').show().empty().append(response['formPersonnalSettingsView']['content'])
                }
            }
        });
    });
});
