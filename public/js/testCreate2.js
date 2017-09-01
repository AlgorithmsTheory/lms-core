/**
 * Created by Станислав on 31.05.17.
 */
var numberOfStructures = 1;
var sections = JSON.parse($('#sections-info').val());
var types = JSON.parse($('#types-info').val());

var page = $('#page');

 /** add new structure */
page.on('click','#add-structure', function(){
    numberOfStructures++;
    var newStructureHtml = '\
        <div class="col-md-12 structure" id="structure-' + numberOfStructures + '">\
            <div class="card card-bordered style-primary card-collapsed">\
                <div class="card-head">\
                    <header>\
                        Структура №' + numberOfStructures +'\
                    </header>\
                </div>\
                <div class="card-body style-default-bright">\
                    <div class="form-group dropdown-label col-md-4 col-sm-4">\
                        <input type="number" min="1" step="1" name="number_of_questions[]" class="form-control number_of_questions" required>\
                        <label for="number_of_questions-1">Число вопросов</label>\
                    </div>\
                    <div class="form-group dropdown-label col-md-4 col-sm-4">\
                        <input type="number" min="1" step="1" name="number_of_access_questions[]" class="form-control number_of_access_questions" disabled>\
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
                                                <input type="checkbox" name="sections[' + numberOfStructures + '][]" value="' + sections[i].code + '">\
                                                <span>' + sections[i].name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                    <td style="display: none" class="theme-td">\
                                        <div class="checkbox checkbox-styled checkbox-fst-theme">\
                                            <label>\
                                                <input type="checkbox" name="themes[' + numberOfStructures + '][' + i + '][]" value="' + sections[i].themes[0].theme_code + '">\
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
                                                <input type="checkbox" name="themes[' + numberOfStructures + '][' + i + '][]" value="' + sections[i].themes[j].theme_code + '">\
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
                                                <input type="checkbox" name="types[' + i + '][]" value="' + types[k].type_code + '">\
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
                                                <input type="checkbox" name="types[' + i + '][]" value="' + types[k + 1].type_code + '">\
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
                                                <input type="checkbox" name="types[' + i + '][]" value="' + types[k + 2].type_code + '">\
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
                                                <input type="checkbox" name="types[' + i + '][]" value="' + types[k + 3].type_code + '">\
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
        numberOfStructures--;
    }
});

/** show and hide themes of the section when this section checked and unchecked */
page.on('change', '.checkbox-section input', function () {
    var structure = $(this).parents('.structure');
    var sectionTr = $(this).parents('tr');
    var sectionNum = sectionTr.attr('id').substr(11);
    var firstTheme = sectionTr.children('.theme-td');
    var otherThemeTr = $(structure).find('.theme-tr-' + sectionNum);
    var numberOfThemes = 1 + otherThemeTr.size();

    if (!$(this).prop('checked')) {
        $(firstTheme).hide();
        $(otherThemeTr).each(function (i, tr) {
            $(tr).hide();
        });
        sectionTr.attr('rowspan', 1);
    }
    else {
        $(firstTheme).show();
        $(otherThemeTr).each(function (i, tr) {
            $(tr).show();
        });
        sectionTr.attr('rowspan', numberOfThemes);
    }
});
