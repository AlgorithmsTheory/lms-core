//вставка символов
$(function () {
    $('#R').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'R_0');

    });

    $('#sigma').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'sum');

    });
    $('#P').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'prod');

    });

    $('#constant').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'C_0^0');

    });
    $('#S').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'S_0^0');

    });
    $('#U').click( function() {

        var text = $('#rec_func');
        text.val(text.val() + 'U_0^0');

    });
    $('#R2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'R_0');

    });

    $('#sigma2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'sum');

    });
    $('#P2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'prod');

    });

    $('#constant2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'C_0^0');

    });
    $('#S2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'S_0^0');

    });
    $('#U2').click( function() {

        var text = $('#rec_func2');
        text.val(text.val() + 'U_0^0');

    });
});