//вставка символов
$(function () {
    $('#R').click( function() {

        var text = $('#text');
        text.val(text.val() + 'R_0');

    });

    $('#sigma').click( function() {

        var text = $('#text');
        text.val(text.val() + 'sum');

    });
    $('#P').click( function() {

        var text = $('#text');
        text.val(text.val() + 'prod');

    });

    $('#constant').click( function() {

        var text = $('#text');
        text.val(text.val() + 'C_0^0');

    });
    $('#S').click( function() {

        var text = $('#text');
        text.val(text.val() + 'S_0^0');

    });
    $('#U').click( function() {

        var text = $('#text');
        text.val(text.val() + 'U_0^0');

    });
});