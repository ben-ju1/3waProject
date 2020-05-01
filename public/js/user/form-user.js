window.addEventListener('DOMContentLoaded', function () {
console.log('formfifds');
    $('#personnalSettingsForm').on('submit', function (e) {
        e.preventDefault();
        console.log('click');
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                if (data.message === "error") {
                    console.log('erreur');
                    $('.display').empty().append(data.personnalSettings.content);
                }
                if (data.message === "success") {
                    console.log("success");
                    location.reload();
                }
            }
        });
    });
});