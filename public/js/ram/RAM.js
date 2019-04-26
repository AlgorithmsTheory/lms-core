//...................................classes................................................

class Context {
	constructor(impl_){
		this.impl = impl_;
		this.timerId = 0;
		this.no_notice = false;
		this.btn_start = $("[name = ram-entity" + this.impl + "] [name='btn_start']");
		this.btn_pause = $("[name = ram-entity" + this.impl + "] [name='btn_pause']");
		this.btn_next = $("[name = ram-entity" + this.impl + "] [name='btn_next']");
		this.btn_reset = $("[name = ram-entity" + this.impl + "] [name='btn_reset']");
		this.btn_save_doc = $("[name = ram-entity" + this.impl + "] [name='btn_save_doc']");
		this.btn_load_doc = $("[name = ram-entity" + this.impl + "] [name='btn_load_doc']")
		this.drop_debug = $("[name = ram-entity" + this.impl + "] [name='drop_debug']");
		this.drop_run = $("[name = ram-entity" + this.impl + "] [name='drop_run']");
		this.drop_animate = $("[name = ram-entity" + this.impl + "] [name='drop_animate']");
		this.btn_reg_plus = $("[name = ram-entity" + this.impl + "] [name='btn_reg_plus']");
		this.btn_reg_minus = $("[name = ram-entity" + this.impl + "] [name='btn_reg_minus']");
		this.btn_reg_default =  $("[name = ram-entity" + this.impl + "] [name='btn_reg_default']");
		
		this.input = $("[name = ram-entity" + this.impl + "] [name='input']");
		this.output = $("[name = ram-entity" + this.impl + "] [name='output']");
		this.r0 = $("[name = ram-entity" + this.impl + "] [name='r0']");
		
		this.registerContainer = $("[name = ram-entity" + this.impl + "] [name='registerContainer']");
		this.mod = $("[name = ram-entity" + this.impl + "] [name='mod']");
		this.editorField = $("[name = ram-entity" + this.impl + "] [name='editor']");
		
		this.editor = ace.edit(this.editorField.get(0));
		this.editor.setTheme("ace/theme/monokai");
		this.editor.session.setMode("ace/mode/ram");
		this.editor.setOptions({
			selectionStyle: "text",
			highlightActiveLine: true,
			highlightSelectedWord: false,
			readOnly: false,
			cursorStyle: "ace",
			fontSize: 25,
		});
	}
	
	get_elem(str){
		return $("[name = ram-entity" + this.impl + "]").find("[name='" + str + "']");
	}
}




class Functional_{
	constructor(ctx){
		this.ctx = ctx;
	}
	
	set_markers(markers_, m_lines_){
		this.markers = markers_;
		this.m_lines = m_lines_;
	}
	
	get_relate(num_relate, arg){
		while(num_relate > 0){
			arg = this.ctx.get_elem("r" + arg).val();
			num_relate--;
		}
		return arg;
	}

	do_read(){
		var input_line = this.ctx.input.val();
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
		this.ctx.input.val(input_line);
		this.ctx.r0.val(number);
	}

	do_write(){
		this.ctx.output.val(this.ctx.output.val() + " " + this.ctx.r0.val());
	}

	do_halt(){
		clearInterval(this.ctx.timerId);
		this.ctx.btn_pause.html("Пауза");
		this.ctx.btn_pause.prop( "disabled", true );
		this.ctx.btn_next.prop( "disabled", true );
		if(this.ctx.no_notice == false)
			alert("Работа выполнена");
		return true;
	}

	do_store(num_relate, arg){
		arg = this.get_relate(num_relate - 1, arg);
		this.ctx.get_elem("r" + arg).val(this.ctx.r0.val());
	}

	do_load(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		this.ctx.r0.val(arg);
	}

	do_add(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		this.ctx.r0.val(this.ctx.r0.val()*1 + arg*1);
	}

	do_sub(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		this.ctx.r0.val(this.ctx.r0.val() - arg);
	}

	do_mult(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		this.ctx.r0.val(this.ctx.r0.val() * arg);
	}

	do_div(num_relate, arg){
		arg = this.get_relate(num_relate, arg);
		this.ctx.r0.val(   (this.ctx.r0.val() - this.ctx.r0.val() % arg) / arg  );
	}

	do_jump(mark){
		return this.m_lines[this.markers.indexOf(mark)] - 1;
	}

	do_jgtz(mark){
		if(this.ctx.r0.val() > 0){
			return this.m_lines[this.markers.indexOf(mark)] - 1;
		}
		return -1;
	}

	do_jzero(mark){
		if(this.ctx.r0.val() == 0){
			return this.m_lines[this.markers.indexOf(mark)] - 1;
		}
		return -1;
	}
}




class TextEditor_{
	constructor(ctx) {
		this.ctx = ctx;
		this.is_highlight_execline = false;
		this.not_highlight_execline = true;
		this.markerID = -1;
	}
	
	set_highlight(t){
		this.is_highlight_execline = t;
	}
	
	set_text(txt){
		this.ctx.editor.setValue(txt, 0); 
	}
	
	get_text() {
		return this.ctx.editor.getValue();
	}
	
	get_line(i) {
		return this.ctx.editor.session.getLine(i);
	}
	
	get_length(){
		return this.ctx.editor.session.getLength();
	}
	
	set_readOnly(t){
		this.ctx.editor.setReadOnly(t);
	}
	
	gotoLine(i){
		this.ctx.editor.gotoLine(i);
	}
	
	drawLine(line){
		if(this.is_highlight_execline){
			if(this.not_highlight_execline){
				this.not_highlight_execline = false;
				var Range = ace.acequire('ace/range').Range;
				this.markerID = this.ctx.editor.session.addMarker(new Range(line, 0, line, 1), "myMarker", "fullLine");
			}
		}
	}

	clearLine(){
		if(this.is_highlight_execline){
			if(!this.not_highlight_execline){
				this.not_highlight_execline = true;
				this.ctx.editor.session.removeMarker(this.markerID);
			}
		}
	}
	
	is_syntax_error(){
		return (this.ctx.editor.session.getState(this.ctx.editor.session.getLength()) == "error");
	}
}



class RegisterManager_ {
	constructor(ctx){
		this.ctx = ctx;
		this.num_registers = 1;
	}
	
	add_register(){
		this.num_registers++;
		this.ctx.registerContainer.append("\n" +
			"<div class = \"input-group\" >" + "\n" +
			"<span class=\"input-group-addon\"><b>R" + this.num_registers + "</b></span>" + "\n" +
			"<input type = \"number\" class = \"form-control\" value = \"0\" name = \"r" + this.num_registers + "\">" + "\n" +
			"</div>" + "\n")
	}
	
	del_register(){
		if(this.num_registers > 0){
			this.ctx.get_elem("r" + this.num_registers--).parent().remove();
		}
	}
	
	reset_values(){
		for(var i = 0; i <= this.num_registers; i++){
			this.ctx.get_elem("r" + i).val(0);
		}
	}
	
	reset(){
		this.num_registers = 0;
		this.ctx.r0.val(0);
		this.ctx.registerContainer.html("");
		for(var i=0; i < 13; i++){
			this.add_register();
		}
	}
}





class RAM_ {
	constructor(ctx){
		this.ctx = ctx;
		this.Functional = new Functional_(ctx);
		this.TextEditor = new TextEditor_(ctx);
		this.RegisterManager = new RegisterManager_(ctx);
		this.RegisterManager.reset();
		this.markerLine = 0;
		this.markers = []; 
		this.m_lines = [];
		this.is_halt = false;
		this.counterOperations = 0;
		this.is_error = false;
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




class EmulatorEnviroment{
	change_mode(ptr) {
		this.ctx.mod.text($(ptr).text());
	}
	
	run(){
		while(!this.RAM.isHalt()){
			this.ctx.btn_next.trigger("click");
		}
	}
	
	constructor(impl_){
		this.ctx = new Context(impl_);
		this.RAM = new RAM_(this.ctx);
		
		this.ctx.btn_start.click(function() {
			if(envs[impl_].RAM.TextEditor.is_syntax_error()){
				if(envs[impl_].ctx.no_notice == false){ // ignore syntax in this case
					alert('Есть некоторые ошибки в коде!');
					return;
				}
			}
			if(!envs[impl_].RAM.check_text()){
				if(envs[impl_].ctx.no_notice == false){
					alert('Одна из команд JUMP с ошибкой!');
				}
				return;
			}
			
			envs[impl_].ctx.btn_start.prop( "disabled", true );
			if(envs[impl_].ctx.mod.html() == "Отладка"){
				envs[impl_].ctx.btn_next.prop( "disabled", false );
				envs[impl_].ctx.btn_pause.prop( "disabled", true );
				envs[impl_].ctx.btn_load_doc.prop( "disabled", true );
				envs[impl_].RAM.TextEditor.set_highlight(true);
				envs[impl_].RAM.start();
			}
			else if(envs[impl_].ctx.mod.html() == "Исполнение"){
				envs[impl_].ctx.btn_next.prop( "disabled", true );
				envs[impl_].ctx.btn_pause.prop( "disabled", true );
				envs[impl_].ctx.btn_load_doc.prop( "disabled", true );
				envs[impl_].RAM.TextEditor.set_highlight(false);
				envs[impl_].RAM.start();
				envs[impl_].run();
			}
			else{
				envs[impl_].ctx.btn_next.prop( "disabled", true );
				envs[impl_].ctx.btn_pause.prop( "disabled", false );
				envs[impl_].ctx.btn_load_doc.prop( "disabled", true );
				envs[impl_].RAM.TextEditor.set_highlight(true);
				envs[impl_].RAM.start();
				envs[impl_].ctx.timerId = setInterval(function() { envs[impl_].ctx.btn_next.trigger("click"); }, 500);
			}
		});
		
		this.ctx.btn_pause.click(function() {
			if(envs[impl_].ctx.btn_pause.html() == "Пауза"){
				clearInterval(envs[impl_].ctx.timerId);
				envs[impl_].ctx.btn_pause.html("Продолжить");
			}
			else{
				envs[impl_].ctx.timerId = setInterval(function() { envs[impl_].ctx.btn_next.trigger("click"); }, 500);
				envs[impl_].ctx.btn_pause.html("Пауза");
			}
		});
		
		this.ctx.btn_next.click(function() {
			envs[impl_].RAM.runNext();
		});

		this.ctx.btn_reset.click(function() {
			clearInterval(envs[impl_].ctx.timerId);
			envs[impl_].ctx.btn_pause.prop( "disabled", true );
			envs[impl_].ctx.btn_pause.html("Пауза");
			
			envs[impl_].ctx.btn_start.prop( "disabled", false );
			envs[impl_].ctx.btn_next.prop( "disabled", true );
			envs[impl_].ctx.btn_load_doc.prop( "disabled", false );
			envs[impl_].RAM.reset();
		});
		
		this.ctx.btn_save_doc.click(function() {
			var textToWrite = envs[impl_].RAM.TextEditor.get_text();
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
		});

		this.ctx.btn_load_doc.click(function() {
			var fileToLoad =  envs[impl_].ctx.get_elem("fileToLoad")[0].files[0];
			var fileReader = new FileReader();
			fileReader.onload = function(fileLoadedEvent) 
			{
				var textFromFileLoaded = fileLoadedEvent.target.result;
				envs[impl_].RAM.TextEditor.set_text(textFromFileLoaded);
			};
			fileReader.readAsText(fileToLoad, "UTF-8");
		});
		
		this.ctx.drop_debug.click( function(){ envs[impl_].change_mode(this) });
		this.ctx.drop_run.click( function(){ envs[impl_].change_mode(this) });
		this.ctx.drop_animate.click( function(){ envs[impl_].change_mode(this) });
		this.ctx.btn_reg_plus.click( function() { envs[impl_].RAM.RegisterManager.add_register(); } );
		this.ctx.btn_reg_minus.click( function() { envs[impl_].RAM.RegisterManager.del_register(); } );
		this.ctx.btn_reg_default.click( function() { envs[impl_].RAM.RegisterManager.reset(); } );
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
});


// create emulator enviroment
var env_counter = 0;
var envs = [];

$("[name=ram-entity]").each(function(){
	$(this).attr('name', 'ram-entity' + env_counter);
	envs.push(new EmulatorEnviroment(env_counter));
	env_counter++;
});
