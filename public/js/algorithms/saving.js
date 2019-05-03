function SavingMtContext(inst)
{
    let ctx = $('[name = mt-entity' + inst + ']');
    
    ctx.find('[name = saveTextAsFile]').click(function(){
        var textToWrite = ctx.find("[name = task_text]").val();
        var i=0;
        var DataMassSt=[];
        var DataMassEnd=[];
            while( ctx.find('[name = st_' + (i+1) + ']').length != 0 ){
                DataMassSt.push(ctx.find('[name = st_' + (i+1) + ']').val());
                DataMassEnd.push(ctx.find('[name = end_' + (i+1) + ']').val());
                i++;
                }
            var data={task:textToWrite, "DataMassSt":DataMassSt, "DataMassEnd":DataMassEnd}	
        
        var json=JSON.stringify(data);
        var textFileAsBlob = new Blob([json], {type:'application/json'});
        var fileNameToSaveAs = ctx.find("[name = inputFileNameToSaveAs]").val();

        var downloadLink = document.createElement("a");
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
        var fileToLoad = ctx.find("[name = fileToLoad]")[0].files[0];
        var fileReader = new FileReader();
        fileReader.onload = function(fileLoadedEvent) 
        {
            var textFromFileLoaded = fileLoadedEvent.target.result;
            var doc = eval('(' + textFromFileLoaded + ')');
            var i=0;
            
            while( ctx.find('[name = st_' + (i+1) + ']').length != 0 ){
                ctx.find('[name = st_' + (i+1) + ']').val( doc.DataMassSt[i] );
                ctx.find('[name = end_' + (i+1) + ']').val( doc.DataMassEnd[i] );
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

j = 0;

$("[name^=mt-entity]").each(function(){
	new SavingMtContext(j);
	j++;
});
