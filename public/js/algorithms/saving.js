function SavingMtContext(ctx)
{   
    ctx.find('[name = saveTextAsFile]').click(function(){
        let textToWrite = ctx.find("[name = task_text]").val();
        let i=0;
        let DataMassSt=[];
        let DataMassEnd=[];
            
            let rowsStart = ctx.find('[name ^= st_]');
            let rowsEnd = ctx.find('[name ^= end_]');
            let countRows = rowsStart.length;
        
            while( i < countRows ){
                DataMassSt.push( rowsStart.eq(i).val() );
                DataMassEnd.push( rowsEnd.eq(i).val() );
                i++;
            }
            let data={task:textToWrite, "DataMassSt":DataMassSt, "DataMassEnd":DataMassEnd}	
        
        let json=JSON.stringify(data);
        let textFileAsBlob = new Blob([json], {type:'application/json'});
        let fileNameToSaveAs = ctx.find("[name = inputFileNameToSaveAs]").val();

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
        let fileToLoad = ctx.find("[name = fileToLoad]")[0].files[0];
        let fileReader = new FileReader();
        fileReader.onload = function(fileLoadedEvent) 
        {
            let textFromFileLoaded = fileLoadedEvent.target.result;
            let doc = eval('(' + textFromFileLoaded + ')');
            let i=0;
            
            let rowsStart = ctx.find('[name ^= st_]');
            let rowsEnd = ctx.find('[name ^= end_]');
            let countRows = rowsStart.length;
        
            while( i < countRows ){
                rowsStart.eq(i).val( doc.DataMassSt[i] );
                rowsEnd.eq(i).val( doc.DataMassEnd[i] );
                i++;
            }
            ctx.find("[name = task_text]").val( doc.task );
        };
        fileReader.readAsText(fileToLoad, "UTF-8");
    });
}

function destroyClickedElement(event)
{
	document.body.removeChild(event.target);
}


$("[name^=mt-entity]").each(function(){
	new SavingMtContext( $(this) );
});


$("[name^=ham-entity]").each(function(){
	new SavingMtContext( $(this) );
});

