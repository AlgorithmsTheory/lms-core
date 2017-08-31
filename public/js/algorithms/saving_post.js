function saveTextAsFile()
{	
	var textToWrite = document.getElementById("task_text").value;
	var i=0;
	var DataMassSelect=[];
	var DataMassGoto1=[];
	var DataMassGoto2=[];
	var DataMassComment=[];
		while(document.getElementById('select_'+(i+1))!=null){
			DataMassSelect.push(document.getElementById('select_'+(i+1)).value);
			DataMassGoto1.push(document.getElementById('goto1_'+(i+1)).value);
			DataMassGoto2.push(document.getElementById('goto2_'+(i+1)).value);
			DataMassComment.push(document.getElementById('comment_'+(i+1)).value);
			i++;
			}
		var data={task:textToWrite, "DataMassSelect":DataMassSelect, "DataMassGoto1":DataMassGoto1, "DataMassGoto2":DataMassGoto2, "DataMassComment":DataMassComment}	
	
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
		
		while(document.getElementById('select_'+(i+1))!=null){
			//document.getElementById('select_'+(i+1)).setAttribute('value', doc.DataMassSelect[i]);
			document.getElementById('select_'+(i+1)).value=doc.DataMassSelect[i];
			document.getElementById('goto1_'+(i+1)).value=doc.DataMassGoto1[i];
			document.getElementById('goto2_'+(i+1)).value=doc.DataMassGoto2[i];
			document.getElementById('comment_'+(i+1)).value=doc.DataMassComment[i];
			i++;
			}
			document.getElementById("task_text").value =doc.task;
		
	};
	fileReader.readAsText(fileToLoad, "UTF-8");
}