/**
 * Created by Станислав on 31.05.17.
 */
var numberOfStructures = 1;
var sections = JSON.parse($('#sections-info').val());
var types = JSON.parse($('#types-info').val());
var generalSettings = JSON.parse($('#general-settings').val());

var page = $('#page');

function parseIdStructure(htmlDivId) {
    return htmlDivId.substr(10);
}

function parseIdSection(htmlTrId) {
    return htmlTrId.substr(11);
}

function reindicate(){
    let indx = 0;
    $('.structure').each(function(){
        $(this).find('header').html('Структура №' + (indx + 1));
        
        $(this).find('[name ^= sections\\[ ]').each(function(){
            let name = $(this).attr('name');
            let a = name.indexOf('[');
            let b = name.indexOf(']');
            name = name.substring(0, a + 1)  +  indx  +  name.substring(b, name.length);
            $(this).attr('name', name);
        });
        
        $(this).find('[name ^= themes\\[ ]').each(function(){
            let name = $(this).attr('name');
            let a = name.indexOf('[');
            let b = name.indexOf(']');
            name = name.substring(0, a + 1)  +  indx  +  name.substring(b, name.length);
            $(this).attr('name', name);
        });
        
        $(this).find('[name ^= types\\[ ]').each(function(){
            let name = $(this).attr('name');
            let a = name.indexOf('[');
            let b = name.indexOf(']');
            name = name.substring(0, a + 1)  +  indx  +  name.substring(b, name.length);
            $(this).attr('name', name);
        });
        
        indx++;
    });
}

 /** add new structure */
page.on('click','#add-structure', function(){
    numberOfStructures++;
    var newStructureHtml = '';
    
    if(numberOfStructures > 1) {
        newStructureHtml += '\
            <div class="row" style="margin-bottom: 45px;">\
                <div class="col-sm-11">\
                </div>\
                <div class="col-sm-1" name="add-del-buttons">\
                    <button type="button" class="btn ink-reaction btn-floating-action btn-danger" name="del-structure"><b>-</b></button>\
                </div>\
            </div>';
    }
        
    newStructureHtml += '\
        <div class="col-md-12 structure" id="structure-' + (numberOfStructures - 1) + '">\
            <div class="card card-bordered style-primary card-collapsed">\
                <div class="card-head">\
                    <header>\
                        Структура №' + numberOfStructures +'\
                    </header>\
                </div>\
                <div class="card-body style-default-bright">\
                    <div class="form-group dropdown-label col-md-4 col-sm-4">\
                        <input type="number" min="1" step="1" name="number-of-questions[]" class="form-control number-of-questions" required>\
                        <label for="number_of_questions-1">Число вопросов</label>\
                    </div>\
                    <div class="form-group dropdown-label col-md-4 col-sm-4">\
                        <input type="number" min="1" step="1" name="number_of_access_questions[]" class="form-control number-of-access-questions" disabled>\
                        <label for="number_of_access_questions-1">Доступно вопросов данной структуры</label>\
                    </div>\
            \
                    <div class="sections_and_themes">\
                        <table class="table no-margin">\
                            <thead>\
                                <tr>\
                                    <th width="50%" class="text-lg">Выберите разделы:</th>\
                                    <th width="50%" class="text-lg">Выберите темы:</th>\
                                </tr>\
                            </thead>\
                            <tbody>';
    for (var i = 0; i < sections.length; i++) {
        newStructureHtml += '\
                                <tr class="section-tr" id="section-tr-' + i + '">\
                                    <td rowspan="1" class="section-td">\
                                        <div class="checkbox checkbox-styled checkbox-section">\
                                            <label>\
                                                <input type="checkbox" name="sections[' + (numberOfStructures - 1) + '][]" value="' + sections[i].code + '">\
                                                <span>' + sections[i].name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                    <td style="display: none" class="theme-td">\
                                        <div class="checkbox checkbox-styled checkbox-theme">\
                                            <label>\
                                                <input type="checkbox" name="themes[' + (numberOfStructures - 1) + '][' + i + '][]" value="' + sections[i].themes[0].theme_code + '">\
                                                <span>' + sections[i].themes[0].theme_name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                </tr>';
        for(var j = 1; j < sections[i].themes.length; j++) {
            newStructureHtml += '\
                                <tr class="theme-tr-' + i + '" style="display: none">\
                                    <td></td>\
                                    <td class="theme-td">\
                                        <div class="checkbox checkbox-styled checkbox-theme">\
                                            <label>\
                                                <input type="checkbox" name="themes[' + (numberOfStructures - 1) + '][' + i + '][]" value="' + sections[i].themes[j].theme_code + '">\
                                                <span>' + sections[i].themes[j].theme_name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                </tr>';
        }
    }
    newStructureHtml += '\
                            </tbody>\
                        </table>\
                    </div>\
                    <div class="types">\
                        <table class="table no-margin">\
                            <thead>\
                                <tr>\
                                    <th class="text-lg">Выберите типы:</th>\
                                    <th></th>\
                                    <th></th>\
                                    <th></th>\
                                </tr>\
                            </thead>\
                            <tbody>';
    for (var k = 0; k < types.length; k += 4) {
        newStructureHtml += '\
                                <tr>\
                                    <td class="type-td">';
        if(k < types.length) {
            newStructureHtml += '\
                                        <div class="checkbox checkbox-styled checkbox-type">\
                                            <label>\
                                                <input type="checkbox" name="types[' + (numberOfStructures - 1) + '][]" value="' + types[k].type_code + '">\
                                                <span>' + types[k].type_name + '</span>\
                                            </label>\
                                        </div>';
        }
        newStructureHtml += '\
                                    </td>\
                                    \<td class="type-td">';
        if(k + 1 < types.length) {
            newStructureHtml += '\
                                    <div class="checkbox checkbox-styled checkbox-type">\
                                            <label>\
                                                <input type="checkbox" name="types[' + (numberOfStructures - 1) + '][]" value="' + types[k + 1].type_code + '">\
                                                <span>' + types[k + 1].type_name + '</span>\
                                            </label>\
                                        </div>';
        }
        newStructureHtml += '\
                                    </td>\
                                    \<td class="type-td">';
        if(k + 2 < types.length) {
            newStructureHtml += '\
                                    <div class="checkbox checkbox-styled checkbox-type">\
                                            <label>\
                                                <input type="checkbox" name="types[' + (numberOfStructures - 1) + '][]" value="' + types[k + 2].type_code + '">\
                                                <span>' + types[k + 2].type_name + '</span>\
                                            </label>\
                                        </div>';
        }
        newStructureHtml += '\
                                    </td>\
                                    \<td class="type-td">';
        if(k + 3 < types.length) {
            newStructureHtml += '\
                                        <div class="checkbox checkbox-styled checkbox-type">\
                                            <label>\
                                                <input type="checkbox" name="types[' + (numberOfStructures - 1) + '][]" value="' + types[k + 3].type_code + '">\
                                                <span>' + types[k + 3].type_name + '</span>\
                                            </label>\
                                        </div>';
        }
        newStructureHtml += '\
                                    </td>';
    }
    newStructureHtml += '\
                                </tbody>\
                            </table>\
                        </div>\
                    </div>\
                </div>\
            </div>';
            
    $('#structures').append(newStructureHtml);
});

/** delete last structure */
page.on('click','#del-structure', function(){
    if (numberOfStructures > 1){
        $('#structures').children().last().remove();
        $('#structures').children().last().remove();
        numberOfStructures--;
    }
});

/** delete middle structure */
page.on('click', '[name = del-structure]', function() {
    row = $(this).closest('.row');
    row.prev().remove();
    row.remove();
    reindicate();
    numberOfStructures--;
});

/** show and hide themes of the section when this section checked and unchecked */
page.on('change', '.checkbox-section input', function () {
    var structure = $(this).parents('.structure');
    var sectionTr = $(this).parents('tr');
    var sectionNum = parseIdSection(sectionTr.attr('id'));
    var firstTheme = sectionTr.children('.theme-td');
    var otherThemeTr = $(structure).find('.theme-tr-' + sectionNum);
    var numberOfThemes = 1 + otherThemeTr.length;

    if (!$(this).prop('checked')) {                                                                                     // when uncheck
        $(firstTheme).hide();
        $(otherThemeTr).each(function (i, tr) {
            $(tr).hide();
        });
        sectionTr.attr('rowspan', 1);
    }
    else {                                                                                                              // when check
        $(firstTheme).show();
        $(firstTheme).find('input').prop('checked', false);
        $(otherThemeTr).each(function (i, tr) {
            $(tr).find('input').prop('checked', false);
            $(tr).show();
        });
        sectionTr.attr('rowspan', numberOfThemes);
    }
});

/** count all accessible questions with specified restrictions in the structure */
function get_amount() {
    var structure = $(this).parents('.structure');
    var maxNumberOfQuestionsInput = $(structure).find('.number-of-access-questions').first();
    var numberOfQuestionsInput = $(structure).find('.number-of-questions').first();
    var sections = [];
    $(structure).find('.checkbox-section input:checked').each(function(i, section) {
        sections.push($(section).val());
    });
    var themes = [];
    $(structure).find('.checkbox-theme input:checked').each(function (i, theme){
       themes.push($(theme).val());
    });
    var types = [];
    $(structure).find('.checkbox-type input:checked').each(function (i, type) {
        types.push($(type).val());
    });
    var testType = generalSettings.test_type;
    var printable = generalSettings.only_for_print;

    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/get-amount',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { section: sections, theme: themes, type: types, test_type: testType, printable: printable, token: 'token' },
        success: function(data){
            $(maxNumberOfQuestionsInput).val(data);
            $(numberOfQuestionsInput).attr('max', data);
        },
        error: function (error) {

        }
    });
}

page.on('change', '.checkbox-section, .checkbox-theme, .checkbox-type', get_amount);

/** When structure block focused out */
page.on('focusout', '.structure', function () {
    var $elem = $(this);
    setTimeout(function () {
        if (!$elem.find(':focus').length) {
            var card = $elem.find('.card').first();
            var maxNumberOfQuestionsInput = $elem.find('.number-of-access-questions').first();
            var numberOfQuestionsInput = $elem.find('.number-of-questions').first();
            var checkedThemes = $elem.find('.checkbox-theme input:checked');
            var checkedTypes = $elem.find('.checkbox-type input:checked');

            // TODO: put error message into structure block's header

            /** if section checked, but no themes checked in it - uncheck this section */
            $elem.find('.checkbox-section input:checked').each(function(i, section) {
                var sectionTr = $(section).parents('.section-tr');
                var sectionNum = parseIdSection($(sectionTr).attr('id'));
                var firstTheme = $(sectionTr).find('.checkbox-theme input:checked');
                var otherThemeTr = $elem.find('.theme-tr-' + sectionNum + ' .checkbox-theme input:checked');
                if (firstTheme.length === 0 && otherThemeTr.length === 0) {
                    var sectionCheckbox = $(sectionTr).find('.checkbox-section input');
                    $(sectionCheckbox).click();
                }
            });

            /** check acceptability of question number and at least one theme and one type is checked */
            card.removeClass('style-primary');
            card.removeClass('style-success');
            card.removeClass('style-danger');
            if (parseInt($(numberOfQuestionsInput).val()) > parseInt($(maxNumberOfQuestionsInput).val()) ||
                parseInt($(numberOfQuestionsInput).val()) <= 0 ||
                $(numberOfQuestionsInput).val() == "" ||
                $(checkedThemes).length === 0 ||
                $(checkedTypes).length === 0
            ) {
                card.addClass('style-danger');
            }
            else {
                card.addClass('style-success');
            }
            // TODO: show only checked inputs in non-focused structures and show full structure on focus
        }
    }, 1000);
});

page.on('click', '#add-test-button', function () {
    var submit = true;
    $('.structure').each(function (i, structure) {
       if (!$(structure).find('.card').first().hasClass('style-success')) {
           alert('Структура ' + (parseInt(i) + 1) + ' заполнена неверно!');
           $(structure).find('.number-of-questions').trigger('focus');
           submit = false;
           return false;
       }
    });

    if (submit) {
        $.ajax({
            cache: false,
            type: 'POST',
            url: '/tests/validate-test-structure',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {form: $('.form').first().serializeJSON()},                                                           // use user function for processing complicated web-form via jquery AJAX (url: https://github.com/marioizquierdo/jquery.serializeJSON)
            success: function (data) {
                if (data == true) {
                    $('.form').first().submit();
                }
                else {
                    alert('Данный набор струтктур не может обеспечить, чтобы каждая из них была наполнена вопросами! Попробуйте уменьшить число вопросов и повторите попытку!');
                    submit = false;
                }
            },
            error: function (error) {
                alert('Критическая ошибка! Обратитесь к администраторам системы!');
            }
        });
    }
});



