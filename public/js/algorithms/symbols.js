var focusedElem;

var scntDiv = $('#p_scents');
var i = $('#p_scents li').length + 1;

$('#addScnt').on('click', function () {
    $('<li  id ="p_scnt_' + i + '" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="st_' + i + '" class="form-control" name="start" onchange="superScript(this)"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="end_' + i + '" class="form-control" name="end" onchange="superScript(this)"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

    i++;
    return false;
});

$('#body').on('click', '#remScnt', function () {
    if (i > 1) {
        $(this).parents('li').remove();
        i--;
    }
    return false;
});

$('#reset').on('click', function () {
    $('input[type=text]').each(function () {

        $(this).val('');
    });
    return false;

});

$('input[type=text]').focus(function () {

    focusedElem = $(this);
});

$('#lambda').click(function () {
    focusedElem.val(focusedElem.val() + 'λ');
});

$('#right').click(function () {
    focusedElem.val(focusedElem.val() + 'R');
});

$('#left').click(function () {
    focusedElem.val(focusedElem.val() + 'L');
});

$('#here').click(function () {
    focusedElem.val(focusedElem.val() + 'H');
});

$('#part').click(function () {
    focusedElem.val(focusedElem.val() + '∂');
});

$('#omega').click(function () {
    focusedElem.val(focusedElem.val() + 'Ω');
});

$('#one').click(function () {
    focusedElem.val(focusedElem.val() + 'S₁');
});

$('#zero').click(function () {
    focusedElem.val(focusedElem.val() + 'S₀');
});

$('#big_lambda').click(function () {
    focusedElem.val(focusedElem.val() + 'Λ');
});

$('#one_tild').click(function () {
    focusedElem.val(focusedElem.val() + 'Õ');
});

$('#sh').click(function () {
    focusedElem.val(focusedElem.val() + '#');
});

$('#bull').click(function () {
    focusedElem.val(focusedElem.val() + 'H');
});

$('#delete').click(function () {
    focusedElem.val(focusedElem.val() + '_');
});