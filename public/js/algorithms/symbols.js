function SymbolsMtContext(ctx){
    let scntDiv = ctx.find('[name = p_scents]');
    let i = scntDiv.find('li').length + 1;
    let focusedElem = null;
    
    ctx.find('[name = addScnt]').on('click', function () {
        $('<li  name ="p_scnt_' + i + '" class="tile">' +
            '<div class="input-group">' +
                '<div class="input-group-content">' +
                    '<input type="text" name="st_' + i + '" class="form-control" onchange="superScript(this)">' +
                '</div>' +
                '<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>' +
                '<div class="input-group-content">' +
                    '<input type="text" name="end_' + i + '" class="form-control" onchange="superScript(this)">' +
                '</div>' +
            '</div>' +
            '<a class="btn btn-flat ink-reaction btn-default" href="#" name="remScnt"><i class="fa fa-trash"></i></a>' +
          '</li>'
        ).appendTo(scntDiv);
        i++;
        return false;
    });
    
    ctx.find('[name = reset]').on('click', function () {
        ctx.find('input[type=text]').each(function () {
            $(this).val('');
        });
        return false;
    });

    ctx.on('click', '[name = remScnt]', function () {
        if (i > 1) {
            $(this).parents('li').remove();
            i--;
        }
        return false;
    });

    ctx.on('focus', 'input[type=text]', function () {
        focusedElem = $(this);
    });

    ctx.find('[name = lambda]').click(function () {
        focusedElem.val(focusedElem.val() + 'λ');
    });

    ctx.find('[name = right]').click(function () {
        focusedElem.val(focusedElem.val() + 'R');
    });

    ctx.find('[name = left]').click(function () {
        focusedElem.val(focusedElem.val() + 'L');
    });

    ctx.find('[name = here]').click(function () {
        focusedElem.val(focusedElem.val() + 'H');
    });

    ctx.find('[name = part]').click(function () {
        focusedElem.val(focusedElem.val() + '∂');
    });

    ctx.find('[name = omega]').click(function () {
        focusedElem.val(focusedElem.val() + 'Ω');
    });

    ctx.find('[name = one]').click(function () {
        focusedElem.val(focusedElem.val() + 'S₁');
    });

    ctx.find('[name = zero]').click(function () {
        focusedElem.val(focusedElem.val() + 'S₀');
    });

    ctx.find('[name = big_lambda]').click(function () {
        focusedElem.val(focusedElem.val() + 'Λ');
    });

    ctx.find('[name = one_tild]').click(function () {
        focusedElem.val(focusedElem.val() + 'Õ');
    });

    ctx.find('[name = sh]').click(function () {
        focusedElem.val(focusedElem.val() + '#');
    });

    ctx.find('[name = bull]').click(function () {
        focusedElem.val(focusedElem.val() + 'H');
    });

    ctx.find('[name = delete]').click(function () {
        focusedElem.val(focusedElem.val() + '_');
    });
}

j = 0;

$("[name=mt-entity]").each(function(){
	$(this).attr('name', 'mt-entity' + j);
    
	SymbolsMtContext( $(this) );
	j++;
});

j = 0;

$("[name=ham-entity]").each(function(){
	$(this).attr('name', 'ham-entity' + j);
    
	SymbolsMtContext( $(this) );
	j++;
});

j = 0;

$("[name=mt3-entity]").each(function(){
        $(this).attr('name', 'mt3-entity' + j);

        SymbolsMtContext( $(this) );
        j++;
});


ham2_changeSpecialSymbols();

function ham2_changeSpecialSymbols() {
    const ulEl = document.querySelector('.ham2-super-keyboard');
    if (!ulEl) {
        return;
    }
    ulEl.addEventListener('input', ev => {
        const inputEl = ev.target.closest('input');
        if (!inputEl) {
            return;
        }
        if (inputEl.value.includes("\\l")) {
            inputEl.value = inputEl.value.replaceAll('\\l', 'Λ');
        }
    });
}