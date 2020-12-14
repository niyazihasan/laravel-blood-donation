$(function () {
    $('body').on('submit', '#user-login', function (event) {
        event.preventDefault();
        let form = $(this);
        $.ajax({
            dataType: 'json',
            type: form.attr('method'),
            data: form.serialize(),
            url: form.attr('action'),
            success: function (data) {
                if (data.fail) {
                    $('#user-login > label > #error-login').text(data.error);
                } else {
                    window.location = data.route;
                }
            }
        });
    });
});
