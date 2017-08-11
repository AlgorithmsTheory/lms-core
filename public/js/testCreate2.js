/**
 * Created by Станислав on 31.05.17.
 */
var numberOfStructures = 1;
var sections = JSON.parse($('#sections-info').val());

var page = $('#page');

page.on('click','#add-structure', function(){
    numberOfStructures++;
    var newStructureHtml = '\
        <div class="col-md-12" id="structure-' + numberOfStructures + '">\
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
                                    <th>Выберите разделы:</th>\
                                    <th>Выберите темы:</th>\
                                </tr>\
                            </thead>\
                            <tbody>';
    for (var i = 0; i < sections.length; i++) {
        newStructureHtml += '\
                                <tr class="section-tr">\
                                    <td rowspan="1" class="section-td">\
                                        <div class="checkbox checkbox-styled">\
                                            <label>\
                                                <input type="checkbox" name="sections[' + numberOfStructures + '][]">\
                                                <span>' + sections[i].name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                    <td class="empty-td"></td>\
                                    <td style="display: none" class="theme-td">\
                                        <div class="checkbox checkbox-styled">\
                                            <label>\
                                                <input type="checkbox" name="themes[' + numberOfStructures + '][' + i + '][]">\
                                                <span>' + sections[i].themes[0].theme_name + '</span>\
                                            </label>\
                                        </div>\
                                    </td>\
                                </tr>';
        for(var j = 1; j < sections[i].themes.length; j++) {
            newStructureHtml += '\
                                <tr class="theme-tr" style="display: none">\
                                    <td class="section-td">\
                                        <div class="checkbox checkbox-styled">\
                                            <label>\
                                                <input type="checkbox" name="themes[' + numberOfStructures + '][' + i + '][]">\
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
                </div>\
            </div>\
        </div>';
    $('#structures').append(newStructureHtml);
});

page.on('click','#del-structure', function(){
    if (numberOfStructures > 1){
        $('#structures').children().last().remove();
        numberOfStructures--;
    }
});
