$(function () {
    $('body').on('submit', '#user-register', function (event) {
        event.preventDefault();
        let form = $(this);
        $.ajax({
            dataType: 'json',
            type: form.attr('method'),
            data: form.serialize(),
            url: form.attr('action'),
            success: function (data) {
                if (data.fail) {
                    $('form#user-register > label > span#error-email').text('');
                    $('form#user-register > label > span#error-password').text('');
                    for (control in data.errors) {
                        $('#error-' + control).html(data.errors[control]);
                    }
                } else {
                    window.location = data.route;
                }
            }
        });
    });
});
