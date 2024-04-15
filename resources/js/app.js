import './bootstrap';

$(function () {
    $('.invoice-reject').on('click', function (event) {
        event.preventDefault();
        $('#reject').removeClass('hidden');
        $('#reject').addClass('flex');
        $('#reject form').attr('action', $(this).attr('data-url'));
    });

    $('#reject button').on('click', function () {
        $('#reject').removeClass('flex');
        $('#reject').addClass('hidden');
    });

    $('#reject input[tupe="submit"]').on('click', function () {
        $('#reject').removeClass('flex');
        $('#reject').addClass('hidden');
    });
});