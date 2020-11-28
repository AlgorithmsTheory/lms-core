class SavingPostContext {
    constructor(imp){
        let ctx = $('[name = post-entity' + imp + ']').first();
        
        ctx.find('[name = saveTextAsFile]').click(function(){
            let textToWrite = ctx.find('[name = task_text]').val();
            let i=0;
            let DataMassSelect=[];
            let DataMassGoto1=[];
            let DataMassGoto2=[];
            let DataMassComment=[];
            
            while(ctx.find('[name = select_' + (i+1) + ']').length != 0){
                DataMassSelect.push(ctx.find('[name = select_' + (i+1) + ']').val());
                DataMassGoto1.push(ctx.find('[name = goto1_' + (i+1) + ']').val());
                DataMassGoto2.push(ctx.find('[name = goto2_' + (i+1) + ']').val());
                DataMassComment.push(ctx.find('[name = comment_' + (i+1) + ']').val());
                i++;
            }
            
            let data = {task:textToWrite, "countRows":i, "DataMassSelect":DataMassSelect, "DataMassGoto1":DataMassGoto1, "DataMassGoto2":DataMassGoto2, "DataMassComment":DataMassComment}	
            
            let json=JSON.stringify(data);
            let textFileAsBlob = new Blob([json], {type:'application/json'});
            let fileNameToSaveAs = ctx.find('[name = inputFileNameToSaveAs]').val();
            
            let downloadLink = document.createElement("a");
                downloadLink.download = fileNameToSaveAs;
                downloadLink.innerHTML = "Download File";
                if (window.webkitURL != null)
                {
                    // Chrome allows the link to be clicked
                    // without actually adding it to the DOM.
                    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
                }
                else
                {
                    // Firefox requires the link to be added to the DOM
                    // before it can be clicked.
                    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
                    downloadLink.onclick = destroyClickedElement;
                    downloadLink.style.display = "none";
                    document.body.appendChild(downloadLink);
                }

                downloadLink.click();
        });
        
        ctx.find('[name = loadFileAsText]').click(function(){
            let fileToLoad = ctx.find('[name = fileToLoad]')[0].files[0];
            
            let fileReader = new FileReader();
                fileReader.onload = function(fileLoadedEvent) {
                    let textFromFileLoaded = fileLoadedEvent.target.result;
                    let doc = eval('(' + textFromFileLoaded + ')');
                    let i=0; let j=0;
                    
                    let countRows = doc.countRows;
                    let currRows = ctx.find('[name ^= select_]').length;
                    
                    while( j < countRows - currRows ){
                        ctx.find('[name = addScnt]').trigger('click');
                        j++;
                    }
                    
                    while(ctx.find('[name = select_' + (i+1) + ']').length != 0){
                          ctx.find('[name = select_' + (i+1) + ']').val( doc.DataMassSelect[i] );
                          ctx.find('[name = goto1_' + (i+1) + ']').val( doc.DataMassGoto1[i] );
                          ctx.find('[name = goto2_' + (i+1) + ']').val( doc.DataMassGoto2[i] );
                          ctx.find('[name = comment_' + (i+1) + ']').val( doc.DataMassComment[i] );
                          i++;
                    }
                    
                    ctx.find('[name = task_text]').val( doc.task );
                    
                };
                
                fileReader.readAsText(fileToLoad, "UTF-8");
        });
    }
}

function destroyClickedElement(event)
{
	document.body.removeChild(event.target);
}

j = 0;

$("[name^=post-entity]").each(function(){
	new SavingPostContext(j);
	j++;
});
