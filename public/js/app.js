$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $('.challenge-difficulty-settings').find('.choose-badge')
        .each(function(key, item) {
            $(item).click(function() {
                $(this).toggleClass('selected');

                if ($('.challenge-difficulty-settings').find('.choose-badge.selected').length > 0) {
                    $('.update-difficulty-btn').removeClass('disabled');
                } else {
                    $('.update-difficulty-btn').addClass('disabled');
                }
            });
        });

    $('.new-challenge-badge').click(function() {
        if (!($(this).hasClass('selected'))) {
            $('.update-frequency-btn').removeClass('disabled');
            $(this).addClass('selected');
            $('.weekly-badge').removeClass('selected');
        }
    });

    $('.weekly-badge').click(function() {
        if (!($(this).hasClass('selected'))) {
            $('.update-frequency-btn').removeClass('disabled');
            $(this).addClass('selected');
            $('.new-challenge-badge').removeClass('selected');
        }
    });

    $('.update-difficulty-btn').click(function() {
        var _difficulties = $.map(
            $('.challenge-difficulty-settings')
                .find('.choose-badge.selected'),
            function(item) {
                return $(item).data('difficulty-short-id')
            });

        $.post('/settings/difficulties/update', {difficulties: _difficulties})
            .done(function(data) {
                Materialize.toast(data.message, 3000, 'rounded success');
            }).fail(function(data) {
            Materialize.toast(data.responseJSON.message, 3000, 'rounded error');
        }).always(function() {
            $('.update-difficulty-btn').addClass('disabled');
        });
    });

    $('.update-frequency-btn').click(function() {
        var _frequency = $('.email-frequency-settings')
            .find('.choose-badge.selected')
            .first().data('frequency-short-name');

        console.log(_frequency);
        $.post('/settings/frequency/update', {frequency: _frequency})
            .done(function(data) {
                Materialize.toast(data.message, 3000, 'rounded success');
            }).fail(function(data) {
            Materialize.toast(data.responseJSON.message, 3000, 'rounded error');
        }).always(function() {
            $('.update-frequency-btn').addClass('disabled');
        });
    });
});