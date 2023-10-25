var focusedElem;

var scntDiv = $('#b_scents');
var i = $('#b_scents li').length + 1;

$('#addScnt_2').on('click', function () {
    $('<li  id ="b_scnt_' + i + '" class="tile ui-sortable-handle"><div class="input-group"><div class="input-group-content"><input rows="1" type="text" id="bst_' + i + '" class="form-control" name="start" onchange="superScript(this)"></input></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="bend_' + i + '" class="form-control" rows="1" name="end" onchange="superScript(this)"></input></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt_2"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

    i++;
    return false;
});

$('section').on('click', '#remScnt_2', function () {
    if (i > 1) {
        $(this).parents('li').remove();
        i--;
    }
    return false;
});

$('#reset_2').live('click', function () {
    $('input[type=text]').each(function () {

        $(this).val('');
    });
    return false;

});

$('#lambda2').click(function () {
    focusedElem.val(focusedElem.val() + 'λ');
});

$('#right2').click(function () {
    focusedElem.val(focusedElem.val() + 'R');
});

$('#left2').click(function () {
    focusedElem.val(focusedElem.val() + 'L');
});

$('#here2').click(function () {
    focusedElem.val(focusedElem.val() + 'H');
});

$('#part2').click(function () {
    focusedElem.val(focusedElem.val() + '∂');
});

$('#omega2').click(function () {
    focusedElem.val(focusedElem.val() + 'Ω');
});

$('#one2').click(function () {;
    focusedElem.val(focusedElem.val() + 'S₁');
});

$('input[type=text]').focus(function () {
    focusedElem = $(this);
});

$('#zero2').click(function () {
    focusedElem.val(focusedElem.val() + 'S₀');
});

$('#big_lambda2').click(function () {
    focusedElem.val(focusedElem.val() + 'Λ');
});

$('#one_tild2').click(function () {
    focusedElem.val(focusedElem.val() + 'Õ');
});

$('#sh2').click(function () {
    focusedElem.val(focusedElem.val() + '#');
});

$('#bull2').click(function () {
    focusedElem.val(focusedElem.val() + 'H');
});

$('#delete2').click(function () {
    focusedElem.val(focusedElem.val() + '_');
});

