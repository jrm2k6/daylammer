$(document).ready(function() {
    $('#new-challenge').change(function() {
        if ($('#new-challenge').is(':checked')) {
            $('#frequency').val('new-challenge');
        }
    });

    $('#weekly').change(function() {
        if ($('#weekly').is(':checked')) {
            $('#frequency').val('weekly');
        }
    });

    $('.register-btn').click(function() {
        window.location = '/';
    });
});