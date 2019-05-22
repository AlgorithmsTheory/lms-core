/* Script run after testCreate2.js */
if($('#header_name').length != 0){
    $('#header_name').html("Редактирование структуры теста \"" + generalSettings.test_name + "\"");
}

var structures_data = $('#structures_data').html();

if(structures_data){
    
    structures_data = JSON.parse(structures_data);

    page.off('change', '.checkbox-section, .checkbox-theme, .checkbox-type', get_amount);

    for(s = 0; s < structures_data.length; s++){
        $('#add-structure').trigger('click');
    }

    for(s = 0; s < structures_data.length; s++){
        let amount = structures_data[s]['amount'];
        let sections = structures_data[s]['sections'];
        let themes = structures_data[s]['themes'];
        let types = structures_data[s]['types'];
        
        $('input[name = number-of-questions\\[\\]]').eq(s).val(amount);

        for(i = 0; i < sections.length; i++){
            $('input[type = checkbox][name ^= sections\\[' + s + '\\]][value = ' + sections[i] + ']').trigger("click");
        }
        
        for(i = 0; i < types.length; i++){
            $('input[type = checkbox][name ^= types\\[' + s + '\\]][value = ' + types[i] + ']').trigger("click");
        }
        
        for(i = 0; i < themes.length; i++){
            $('input[type = checkbox][name ^= themes\\[' + s + '\\]][value = ' + themes[i] + ']').trigger("click");
        }
    }

    page.on('change', '.checkbox-section, .checkbox-theme, .checkbox-type', get_amount);

    page.find(".structure").trigger('focusout');
}
else{
    $('#add-structure').trigger('click');
}
