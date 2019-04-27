class SymbolsPostContext {
    constructor(imp){
        let ctx = $('[name = post-entity' + imp + ']').first();
        
        let scntDiv = ctx.find('[name = p_scents]');
        let i = scntDiv.find('li').length + 1;
        let focusedElem = null;
        
        ctx.find('[name = addScnt]').on('click', function() {
            $('<li name="p_scnt_' + i + '" class="tile">' +
            '<div class="col-sm-1">' +
            '    <span class="input-group-addon"><b>' + i + '</b></span>' +
            '</div>' +
            '<div class="form-group col-sm-4">' +
            '    <select name="select_' + i + '" name="select_' + i + '" class="form-control" style="width:100px">' +
            '        <option value=" " selected="selected">&nbsp;</option>' +
            '        <option value=">">></option>' +
            '        <option value="<"><</option>' +
            '        <option value="1">1</option>' +
            '        <option value="0">0</option>' +
            '        <option value="?">?</option>' +
            '        <option value="!">!</option>' +
            '    </select>' +
            '</div>' +
            '<div class="col-sm-3" style="">' +
            '        <div class="input-group">' +
            '        <input type="number" min="1" name="goto1_' + i + '" class="form-control" required="">' +
                                                        
            '        <span class="input-group-addon">|</span>' +
                                                        
            '        <input type="number" min="1" name="goto2_' + i + '" class="form-control" required="">' +
            '        <span class="input-group-addon">|</span>' +
            '    </div>' +
            '</div>' +
            '<div class="col-sm-4" style="">' +
            '   <div class="input-group">' +
            '        <input type="text" class="form-control" name="comment_' + i + '" placeholder="Комментарий">' +
            '        <div class="form-control-line"></div>' +
            '    </div>' +
            '</div>' +
            '</li>').appendTo(scntDiv);
            
            i++;
            return false;
        });

        ctx.find('[name = remScnt]').on('click', function() { 
            if( i > 1 ) {
                $(this).parents('li').remove();
                i--;
            }
            return false;
        });


        ctx.find('[name = reset]').on('click', function() { 
            ctx.find('input[type=text]').each(function() {
                $(this).val('');
            });
            ctx.find('input[type=number]').each(function() {
                $(this).val('');
            });
            ctx.find('select').each(function() {
                $(this).val('');
            });
            
            return false;
        });



        ctx.find('input[type=text]').focus( function() {
            focusedElem = $(this);
        });
            
        ctx.find('[name = lambda]').click( function() {
            focusedElem.val(focusedElem.val() + 'λ'); 
        });

        ctx.find('[name = right]').click( function() {
            focusedElem.val(focusedElem.val() + 'R'); 
        });
            
        ctx.find('[name = left]').click( function() {
            focusedElem.val(focusedElem.val() + 'L'); 
        });
        
        ctx.find('[name = here]').click( function() {
            focusedElem.val(focusedElem.val() + 'H'); 
        });
        
        ctx.find('[name = part]').click( function() {
            focusedElem.val(focusedElem.val() + '∂'); 
        });
        
        ctx.find('[name = omega]').click( function() {
            focusedElem.val(focusedElem.val() + 'Ω'); 
        });
        
        ctx.find('[name = one]').click( function() {
            focusedElem.val(focusedElem.val() + 'S₁'); 
        });
        
        ctx.find('[name = zero]').click( function() {
            focusedElem.val(focusedElem.val() + 'S₀');
        });
        
        ctx.find('[name = big_lambda]').click( function() {
            focusedElem.val(focusedElem.val() + 'Λ'); 
        });
        
        ctx.find('[name = one_tild]').click( function() {
            focusedElem.val(focusedElem.val() + 'Õ'); 
        });
        
        ctx.find('[name = sh]').click( function() {
            focusedElem.val(focusedElem.val() + '#'); 
        });
        
        ctx.find('[name = bull]').click( function() {
            focusedElem.val(focusedElem.val() + 'H'); 
        });
    }
}


j = 0;

$("[name=post-entity]").each(function(){
	$(this).attr('name', 'post-entity' + j);
	new SymbolsPostContext(j);
	j++;
});
