function saveTextAsFile()
{	
	var textToWrite = document.getElementById("task_text").value;
	var i=0;
	var DataMassSt=[];
	var DataMassEnd=[];
		while(document.getElementById('st_'+(i+1))!=null){
			DataMassSt.push(document.getElementById('st_'+(i+1)).value);
			DataMassEnd.push(document.getElementById('end_'+(i+1)).value);
			i++;
			}
		var data={task:textToWrite, "DataMassSt":DataMassSt, "DataMassEnd":DataMassEnd}	
	
	var json=JSON.stringify(data);
	var textFileAsBlob = new Blob([json], {type:'application/json'});
	var fileNameToSaveAs = document.getElementById("inputFileNameToSaveAs").value;

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
}

function destroyClickedElement(event)
{
	document.body.removeChild(event.target);
}

function loadFileAsText()
{
	var fileToLoad = document.getElementById("fileToLoad").files[0];

	var fileReader = new FileReader();
	fileReader.onload = function(fileLoadedEvent) 
	{
		var textFromFileLoaded = fileLoadedEvent.target.result;
		var doc = eval('(' + textFromFileLoaded + ')');
		var i=0;
		
		while(document.getElementById('st_'+(i+1))!=null){
			document.getElementById('st_'+(i+1)).value=doc.DataMassSt[i];
			document.getElementById('end_'+(i+1)).value=doc.DataMassEnd[i];
			i++;
			}
			document.getElementById("task_text").value =doc.task;
		
	};
	fileReader.readAsText(fileToLoad, "UTF-8");
}