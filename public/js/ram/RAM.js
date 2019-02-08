//...................................classes................................................

class Functional_{
	set_markers(markers_, m_lines_){
		this.markers = markers_;
		this.m_lines = m_lines_;
	}
	
	get_relate(num_relate, arg){
		while(num_relate > 0){
			arg = $("#r" + arg).val();
			num_relate--;
		}
		return arg;
	}

	do_read(){
		var input_line = input.value;
		var space = 0; var number = "";
		while(space == 0){
			space = input_line.indexOf(" ");
			if(space == -1){
				number = input_line;
				input_line = "";
			}
			else{
				number = input_line.substr(0, space);
				input_line = input_line.substr(space + 1);
			}
		}
		input.value = input_line;
		r0.value = number;
	}

	do_write(){
		output.value = output.value + " " + r0.value;
	}

	do_halt(){
		clearInterval(timerId);
		$("#btn_pause").html("Пауза");
		btn_pause.disabled = true;
		btn_next.disabled = true;
		if(RAM.no_notice == false)
			alert("Работа выполнена");
		return true;
	}

	do_store(num_relate, arg){
		arg = this.get_relate(num_relate - 1, arg);
		$("#r" + arg).val($("#r0").val());
	}

	do_load(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		$("#r0").val(arg);
	}

	do_add(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		$("#r0").val($("#r0").val()*1 + arg*1);
	}

	do_sub(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		$("#r0").val($("#r0").val() - arg);
	}

	do_mult(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		$("#r0").val($("#r0").val() * arg);
	}

	do_div(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		$("#r0").val(   ($("#r0").val() - $("#r0").val() % arg) / arg  );
	}

	do_jump(mark){
		return this.m_lines[this.markers.indexOf(mark)] - 1;
	}

	do_jgtz(mark){
		if($("#r0").val() > 0){
			return this.m_lines[this.markers.indexOf(mark)] - 1;
		}
		return -1;
	}

	do_jzero(mark){
		if($("#r0").val() == 0){
			return this.m_lines[this.markers.indexOf(mark)] - 1;
		}
		return -1;
	}
}




class TextEditor_{
	constructor() {
		this.is_highlight_execline = false;
		this.not_highlight_execline = true;
		this.markerID = -1;
	}
	
	set_highlight(t){
		this.is_highlight_execline = t;
	}
	
	set_text(txt){
		editor.setValue(txt, 0); 
	}
	
	get_text() {
		return editor.getValue();
	}
	
	get_line(i) {
		return editor.session.getLine(i);
	}
	
	get_length(){
		return editor.session.getLength();
	}
	
	set_readOnly(t){
		editor.setReadOnly(t);
	}
	
	gotoLine(i){
		editor.gotoLine(i);
	}
	
	drawLine(line){
		if(this.is_highlight_execline){
			if(this.not_highlight_execline){
				this.not_highlight_execline = false;
				var Range = ace.require('ace/range').Range;
				this.markerID = editor.session.addMarker(new Range(line, 0, line, 1), "myMarker", "fullLine");
			}
		}
	}

	clearLine(){
		if(this.is_highlight_execline){
			if(!this.not_highlight_execline){
				this.not_highlight_execline = true;
				editor.session.removeMarker(this.markerID);
			}
		}
	}
	
	is_syntax_error(){
		return (editor.session.getState(editor.session.getLength()) == "error");
	}
}



class RegisterManager_ {
	constructor(){
		this.num_registers = 1;
	}
	
	add_register(){
		this.num_registers++;
		$("#registerContainer").append("\n" +
			"<div class = \"input-group\" >" + "\n" +
			"<span class=\"input-group-addon\"><b>R" + this.num_registers + "</b></span>" + "\n" +
			"<input type = \"number\" class = \"form-control\" value = \"0\" id = \"r" + this.num_registers + "\">" + "\n" +
			"</div>" + "\n")
	}
	
	del_register(){
		if(this.num_registers > 0){
			$("#r" + this.num_registers--).parent().remove();
		}
	}
	
	reset_values(){
		for(var i = 0; i <= this.num_registers; i++){
			$("#r" + i).val(0);
		}
	}
	
	reset(){
		this.num_registers = 0;
		$("#r0").val(0);
		$("#registerContainer").html("");
		for(var i=0; i < 13; i++){
			this.add_register();
		}
	}
}





class RAM_ {
	constructor(){
		this.Functional = new Functional_();
		this.TextEditor = new TextEditor_();
		this.RegisterManager = new RegisterManager_();
		this.RegisterManager.reset();
		this.markerLine = 0;
		this.markers = []; 
		this.m_lines = [];
		this.is_halt = false;
		this.counterOperations = 0;
		this.is_error = false;
		this.no_notice = false;
	}
	
	set_mark(num_row, mark){
		if(this.markers.indexOf(mark) == -1){
			this.markers.push(mark);
			this.m_lines.push(num_row);
		}
	}

	check_text(){
		var txt = this.TextEditor.get_text();
		var regexp = /(JUMP|JGTZ|JZERO)\b\s*(\w+)/g;
		var err = true;
		var result;
		while(result = regexp.exec(txt)){
			var check = new RegExp("\\b" + result[2] + ":");
			var pos = txt.search(check);
			if(pos == -1){
				err = false;
				break;
			}
		}
		return err;
	}

	scane_markers() {
		this.markers = []; this.m_lines = [];
		var len = this.TextEditor.get_length();
		for(var i=0; i < len; i++){
			var line = this.TextEditor.get_line(i);
			var a;
			if(a = /^\s*\w+:/.exec(line)){
				var mark = a[0].substr(0,a[0].length-1);
				this.set_mark(i, mark);
			}
		}
		this.Functional.set_markers(this.markers, this.m_lines);
	}

	execute_line(line){
		if(this.is_halt){
			return;
		}
		if(this.counterOperations > 300){
			this.is_halt = this.Functional.do_halt();
			this.is_error = true;
			return;
		}
		
		var a;
		if(a = /^\s*\w+:/.exec(line)){
			this.counterOperations++;
			line = line.substr(a.index + a[0].length);
			this.execute_line(line);
		}
		else if(a = /^\s*(READ|WRITE|HALT)\b/.exec(line)){
			this.counterOperations++;
			if(a[1] == "READ"){
				this.Functional.do_read();
			}
			else if(a[1] == "WRITE"){
				this.Functional.do_write();
			}
			else if(a[1] == "HALT"){
				this.is_halt = this.Functional.do_halt();
			}
			line = line.substr(a.index + a[0].length);
			this.execute_line(line);
		}
		else if(a = /^\s*(STORE)\s*(\[[0-9]+\]|\[\[[0-9]+\]\])/.exec(line)){
			this.counterOperations++;
			var sym = 0;
			while(a[2][sym] == '['){
				sym = sym + 1;
			}
			this.Functional.do_store(sym, /[0-9]+/.exec(a[2])[0]);
			line = line.substr(a.index + a[0].length);
			this.execute_line(line);
		}
		else if(a = /^\s*(LOAD|ADD|SUB|MULT|DIV)\s*([0-9]+|\[[0-9]+\]|\[\[[0-9]+\]\])/.exec(line)){
			this.counterOperations++;
			var sym = 0;
			while(a[2][sym] == '['){
				sym = sym + 1;
			}
			if(a[1] == "LOAD"){
				this.Functional.do_load(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "ADD") {
				this.Functional.do_add(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "SUB") {
				this.Functional.do_sub(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "MULT") {
				this.Functional.do_mult(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "DIV") {
				this.Functional.do_div(sym, /[0-9]+/.exec(a[2])[0]);
			}
			line = line.substr(a.index + a[0].length);
			this.execute_line(line);
		}
		else if(a = /^\s*(JUMP|JGTZ|JZERO)\b\s*(\w+)/.exec(line)){
			this.counterOperations++;
			if(a[1] == "JUMP"){
				this.markerLine = this.Functional.do_jump(a[2]);
			}
			else if(a[1] == "JGTZ"){
				var next_line = this.Functional.do_jgtz(a[2]);
				if(next_line != -1){
					this.markerLine = next_line;
				}
				else{
					line = line.substr(a.index + a[0].length);
					this.execute_line(line);
				}
			}
			else if(a[1] == "JZERO"){
				var next_line = this.Functional.do_jzero(a[2]);
				if(next_line != -1){
					this.markerLine = next_line;
				}
				else{
					line = line.substr(a.index + a[0].length);
					this.execute_line(line);
				}
			}
		}	
	}
	
	isHalt(){
		return this.is_halt;
	}
	
	isError(){
		return this.is_error;
	}
	
	start(){
		this.counterOperations = 0;
		this.is_halt = false;
		this.is_error = false;
		this.markerLine = 0;
		this.scane_markers();
		this.TextEditor.set_readOnly(true);
		this.TextEditor.gotoLine(1);
		this.TextEditor.drawLine(this.markerLine);
	}
	
	runNext(){
		var line = this.TextEditor.get_line(this.markerLine);
		this.execute_line(line);
		this.TextEditor.clearLine();
		this.markerLine = this.markerLine + 1;
		this.TextEditor.drawLine(this.markerLine);
		if(!this.isHalt() && this.markerLine >= this.TextEditor.get_length()){
			this.is_halt = this.Functional.do_halt();
		}
	}
	
	reset(){
		this.TextEditor.set_readOnly(false);
		this.TextEditor.clearLine();
		this.RegisterManager.reset_values();
	}
}





var timerId;
class ButtonFunctional{
	static change_mode() {
		$("#mod").text($(this).text());
	}
	
	static run(){
		while(!RAM.isHalt()){
			btn_next.dispatchEvent(new Event("click"));
		}
	}
	
	constructor(){
		btn_start.onclick = function() {
			if(RAM.TextEditor.is_syntax_error()){
				if(RAM.no_notice == false){ // ignore syntax in this case
					alert('Есть некоторые ошибки в коде!');
					return;
				}
			}
			if(!RAM.check_text()){
				if(RAM.no_notice == false){
					alert('Одна из команд JUMP с ошибкой!');
				}
				return;
			}
			
			btn_start.disabled = true;
			if($("#mod").html() == "Отладка"){
				btn_next.disabled = false;
				btn_pause.disabled = true;
				btn_load_doc.disabled = true;
				RAM.TextEditor.set_highlight(true);
				RAM.start();
			}
			else if($("#mod").html() == "Исполнение"){
				btn_next.disabled = true;
				btn_pause.disabled = true;
				btn_load_doc.disabled = true;
				RAM.TextEditor.set_highlight(false);
				RAM.start();
				ButtonFunctional.run();
			}
			else{
				btn_next.disabled = true;
				btn_pause.disabled = false;
				btn_load_doc.disabled = true;
				RAM.TextEditor.set_highlight(true);
				RAM.start();
				timerId = setInterval(function() { btn_next.dispatchEvent(new Event("click")); }, 500);
			}
		};
		
		btn_pause.onclick = function() {
			if($("#btn_pause").html() == "Пауза"){
				clearInterval(timerId);
				$("#btn_pause").html("Продолжить");
			}
			else{
				timerId = setInterval(function() { btn_next.dispatchEvent(new Event("click")); }, 500);
				$("#btn_pause").html("Пауза");
			}
		};
		
		btn_next.onclick = function() {
			RAM.runNext();
		};

		btn_reset.onclick = function() {
			clearInterval(timerId);
			btn_pause.disabled = true;
			$("#btn_pause").html("Пауза");
			
			btn_start.disabled = false;
			btn_next.disabled = true;
			btn_load_doc.disabled = false;
			RAM.reset();
		};

		btn_save_doc.onclick = function() {
			var textToWrite = RAM.TextEditor.get_text();
			textToWrite = textToWrite.replace(/\r/g, "");
			textToWrite = textToWrite.replace(/\n/g, "\r\n");
			var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
			var fileNameToSaveAs = "Программа RAM";

			var downloadLink = document.createElement("a");
			downloadLink.download = fileNameToSaveAs;
			downloadLink.innerHTML = "Download File";
			if (window.URL != null)
			{
				// Chrome allows the link to be clicked
				// without actually adding it to the DOM.
				downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
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
		};

		btn_load_doc.onclick = function() {
			var fileToLoad = document.getElementById("fileToLoad").files[0];
			var fileReader = new FileReader();
			fileReader.onload = function(fileLoadedEvent) 
			{
				var textFromFileLoaded = fileLoadedEvent.target.result;
				RAM.TextEditor.set_text(textFromFileLoaded)
			};
			fileReader.readAsText(fileToLoad, "UTF-8");
		};
		
		drop_debug.onclick = ButtonFunctional.change_mode;
		drop_run.onclick = ButtonFunctional.change_mode;
		drop_animate.onclick = ButtonFunctional.change_mode;
		btn_reg_plus.onclick = function() { RAM.RegisterManager.add_register(); }
		btn_reg_minus.onclick = function() { RAM.RegisterManager.del_register(); }
		btn_reg_default.onclick = function() { RAM.RegisterManager.reset(); }
	}
}

//..........................................initial............................................
// disable mousewheel on a input number field when in focus
$('.input-group').on('focus', 'input[type=number]', function (e) {
  $(this).on('mousewheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('input-group').on('blur', 'input[type=number]', function (e) {
  $(this).off('mousewheel.disableScroll')
})
// set editor
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/ram");
	editor.setOptions({
		selectionStyle: "text",
		highlightActiveLine: true,
		highlightSelectedWord: false,
		readOnly: false,
		cursorStyle: "ace",
		fontSize: 25,
	})
// create classes
let RAM = new RAM_();
let buttonFunctional = new ButtonFunctional();
