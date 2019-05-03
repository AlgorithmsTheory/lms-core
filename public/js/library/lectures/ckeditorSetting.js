var ckEditorInstanceReady = false;
$(document).ready(function(){
    var editor = CKEDITOR.replace( 'lecture_text' , {
        customConfig: $('#path_ckeditor_config').val()
    });
    //Проверка существования редактора ckEditor
    editor.on( 'instanceReady', function() {
        ckEditorInstanceReady = true;
    } );
    var ckeditorThemeAnchors = $('#ckeditor_theme_anchors');
    if (ckeditorThemeAnchors) {
        //Вставка тем в select диалога дбавления якоря
        var anchorThemes = JSON.parse(ckeditorThemeAnchors.val());
        CKEDITOR.on( 'dialogDefinition', function( ev ) {
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;
            if ( dialogName == 'anchor' ){
                var infoTab = dialogDefinition.getContents( 'info' );
                var protocolDropdown = infoTab.get( 'selectName' );
                $.each(anchorThemes,function(index,value){
                    protocolDropdown.items.push( [value.theme_name, value.anchor_name] );
                });
        }
    });

    //Проверка что все якоря всех тем были проставлены
        $('form button[type=submit]').on("click",function(e) {
            var errorArray = validStoreLecture(editor, anchorThemes);
            if($.isEmptyObject(errorArray)) {

            } else {
                e.preventDefault();
                alert(errorArray);
            }
        });
    }
});



function validStoreLecture(editor, anchorThemes) {
    var errorArray = [];
     if (ckEditorInstanceReady)  {
         var allAnchorsLecture = CKEDITOR.plugins.linkMephi22.getEditorAnchors(editor);
         $.each(anchorThemes,function(index,anchorThemesValue){
             var resultSearch = allAnchorsLecture.find(anchor => anchor.name === anchorThemesValue.anchor_name);
             if (!resultSearch) {
                 errorArray.push('Нет якоря на тему "' + anchorThemesValue.theme_name + '"');
             }
         });
     }  else {
         errorArray.push('Объект редактора ещё не создан');
     }

    return errorArray;

}