//...................................classes................................................

class Functional_{
	get_relate(num_relate, arg){
		while(num_relate > 0){
			arg = $("#r" + arg).val();
			num_relate--;
		}
		return arg;
	}

	set_mark(num_row, mark){
		if(markers.indexOf(mark) == -1){
			markers.push(mark);
			m_lines.push(num_row);
		}
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
		alert("Job's done");
		btn_next.disabled = true;
		is_halt = true;
	}

	do_store(num_relate, arg){
		arg = get_relate(num_relate - 1, arg);
		$("#r" + arg).val($("#r0").val());
	}

	do_load(num_relate, arg){
		arg = get_relate(num_relate, arg);
		$("#r0").val(arg);
	}

	do_add(num_relate, arg){
		arg = get_relate(num_relate, arg);
		$("#r0").val($("#r0").val()*1 + arg*1);
	}

	do_sub(num_relate, arg){
		arg = get_relate(num_relate, arg);
		$("#r0").val($("#r0").val() - arg);
	}

	do_mult(num_relate, arg){
		arg = get_relate(num_relate, arg);
		$("#r0").val($("#r0").val() * arg);
	}

	do_div(num_relate, arg){
		arg = get_relate(num_relate, arg);
		$("#r0").val(   ($("#r0").val() - $("#r0").val() % arg) / arg  );
	}

	do_jump(mark){
		markerLine = m_lines[markers.indexOf(mark)] - 1;
	}

	do_jgtz(mark){
		if($("#r0").val() > 0){
			markerLine = m_lines[markers.indexOf(mark)] - 1;
		}
	}

	do_jzero(mark){
		if($("#r0").val() == 0){
			markerLine = m_lines[markers.indexOf(mark)] - 1;
		}
	}
}


class RAM_ {
	constructor(){
		this.Functional = new Functional_();
		this.markerLine = 0;
		this.markerID = -1;
		this.markers = []; 
		this.m_lines = [];
		this.is_halt = false;
		this.is_highlight_execline = false;
		this.not_highlight_execline = true;
		this.number_reg = 5;
	}
	
	clear_regs() {
		for(var i=0; i<number_reg; i++){
			$("#r" + i).val("0");
		}
	}

	drawLine(line){
		RAM.not_highlight_execline = false;
		var Range = ace.require('ace/range').Range;
		this.markerID = editor.session.addMarker(new Range(line, 0, line, 1), "myMarker", "fullLine");
	}

	clearLine(){
		if(!not_highlight_execline){
			not_highlight_execline = true;
			editor.session.removeMarker(markerID);
		}
	}

	check_text(){
		var txt = editor.getValue();
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
		var len = editor.session.getLength();
		for(var i=0; i < len; i++){
			var line = editor.session.getLine(i);
			var a;
			if(a = /^\s*\w+:/.exec(line)){
				var mark = a[0].substr(0,a[0].length-1);
				set_mark(i, mark);
			}
		}
	}

	execute_line(line){
		if(is_halt){
			return;
		}
		if(a = /^\s*\w+:/.exec(line)){
			line = line.substr(a.index + a[0].length);
			execute_line(line);
		}
		else if(a = /^\s*(READ|WRITE|HALT)\b/.exec(line)){
			if(a[1] == "READ"){
				do_read();
			}
			else if(a[1] == "WRITE"){
				do_write();
			}
			else if(a[1] == "HALT"){
				do_halt();
			}
			line = line.substr(a.index + a[0].length);
			execute_line(line);
		}
		else if(a = /^\s*(STORE)\s*(\[[0-9]+\]|\[\[[0-9]+\]\])/.exec(line)){
			var sym = 0;
			while(a[2][sym] == '['){
				sym = sym + 1;
			}
			do_store(sym, /[0-9]+/.exec(a[2])[0]);
			line = line.substr(a.index + a[0].length);
			execute_line(line);
		}
		else if(a = /^\s*(LOAD|ADD|SUB|MULT|DIV)\s*([0-9]+|\[[0-9]+\]|\[\[[0-9]+\]\])/.exec(line)){
			var sym = 0;
			while(a[2][sym] == '['){
				sym = sym + 1;
			}
			if(a[1] == "LOAD"){
				do_load(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "ADD") {
				do_add(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "SUB") {
				do_sub(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "MULT") {
				do_mult(sym, /[0-9]+/.exec(a[2])[0]);
			}
			else if(a[1] == "DIV") {
				do_div(sym, /[0-9]+/.exec(a[2])[0]);
			}
			line = line.substr(a.index + a[0].length);
			execute_line(line);
		}
		else if(a = /^\s*(JUMP|JGTZ|JZERO)\b\s*(\w+)/.exec(line)){
			if(a[1] == "JUMP"){
				do_jump(a[2]);
			}
			else if(a[1] == "JGTZ"){
				do_jgtz(a[2]);
			}
			else if(a[1] == "JZERO"){
				do_jzero(a[2]);
			}
			line = line.substr(a.index + a[0].length);
			execute_line(line);
		}	
	}
}


class ButtonFunctional{
	static change_mode() {
		$("#btn_animate").text($(this).text());
	}
	
	static run(){
		while(!is_halt){
			btn_next.dispatchEvent(new Event("click"));
		}
	}
	
	constructor(){
		btn_animate.onclick = function() {
			if(editor.session.getState(editor.session.getLength()) == "error"){
				alert('There are some error in code!');
				return;
			}
			if(!RAM.check_text()){
				alert('There are some JUMPs is brake');
				return;
			}
			RAM.is_halt = false;
			RAM.markerLine = 0;
			RAM.scane_markers();
			editor.setReadOnly(true);
			editor.gotoLine(1);
			btn_animate.disabled = true;
			if($("#btn_animate").html() == "Debug"){
				RAM.is_highlight_execline = true;
				btn_next.disabled = false;
				btn_pause.disabled = true;
				RAM.drawLine(RAM.markerLine);
			}
			else if($("#btn_animate").html() == "Run"){
				RAM.is_highlight_execline = false;
				btn_next.disabled = true;
				btn_pause.disabled = true;
				run();
			}
			else{
				RAM.is_highlight_execline = true;
				btn_next.disabled = true;
				btn_pause.disabled = false;
				RAM.drawLine(RAM.markerLine);
			}
		};
		
		btn_pause.onclick = function() {
			alert('aaa');
		};
		
		btn_next.onclick = function() {
			// data work
			var line = editor.session.getLine(markerLine);
			RAM.execute_line(line);
			// editor work
			if(RAM.is_highlight_execline){
				RAM.clearLine();
				RAM.markerLine = RAM.markerLine + 1;
				RAM.drawLine(markerLine);
			}
			else{
				RAM.markerLine = RAM.markerLine + 1;
			}
			if(!RAM.is_halt && RAM.markerLine >= editor.session.getLength()){
				RAM.Functional.do_halt();
				return;
			}
		};

		btn_reset.onclick = function() {
			btn_animate.disabled = false;
			btn_pause.disabled = true;
			btn_next.disabled = true;
			editor.setReadOnly(false);
			RAM.clearLine();
			RAM.clear_regs();
		};

		btn_help.onclick = function() {
			alert('aaa');
		};

		btn_save_doc.onclick = function() {
			alert('aaa');
		};

		btn_load_doc.onclick = function() {
			alert('aaa');
		};
		drop_debug.onclick = ButtonFunctional.change_mode;
		drop_run.onclick = ButtonFunctional.change_mode;
		drop_animate.onclick = ButtonFunctional.change_mode;
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
