var markerLine = 0, markerID = -1;
var markers = []; var m_lines = [];
var is_halt = false;
var is_highlight_execline = false;
var not_highlight_execline = true;
var number_reg = 5;

function clear_regs() {
	for(var i=0; i<number_reg; i++){
		$("#r" + i).val("0");
	}
}

function drawLine(line){
	not_highlight_execline = false;
	var Range = ace.require('ace/range').Range;
	markerID = editor.session.addMarker(new Range(line, 0, line, 1), "myMarker", "fullLine");
}

function clearLine(){
	if(!not_highlight_execline){
		not_highlight_execline = true;
		editor.session.removeMarker(markerID);
	}
}

function check_text(){
	var txt = editor.getValue();
	var regexp = /(JUMP|JGTZ|JZERO)\b\s*(\w+)/g;
	var err = true;
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

function scane_markers() {
	markers = []; m_lines = [];
	var len = editor.session.getLength();
	for(var i=0; i < len; i++){
		var line = editor.session.getLine(i);
		if(a = /^\s*\w+:/.exec(line)){
			var mark = a[0].substr(0,a[0].length-1);
			set_mark(i, mark);
		}
	}
}

function execute_line(line){
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

//--------------------------------implementation--------------------------------------------

function get_relate(num_relate, arg){
	while(num_relate > 0){
		arg = $("#r" + arg).val();
		num_relate--;
	}
	return arg;
}

function set_mark(num_row, mark){
	if(markers.indexOf(mark) == -1){
	markers.push(mark);
	m_lines.push(num_row);
	}
}

function do_read(){
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

function do_write(){
	output.value = output.value + " " + r0.value;
}

function do_halt(){
	alert("Job's done");
	btn_next.disabled = true;
	is_halt = true;
}

function do_store(num_relate, arg){
	arg = get_relate(num_relate - 1, arg);
	$("#r" + arg).val($("#r0").val());
}

function do_load(num_relate, arg){
	arg = get_relate(num_relate, arg);
	$("#r0").val(arg);
}

function do_add(num_relate, arg){
	arg = get_relate(num_relate, arg);
	$("#r0").val($("#r0").val()*1 + arg*1);
}

function do_sub(num_relate, arg){
	arg = get_relate(num_relate, arg);
	$("#r0").val($("#r0").val() - arg);
}

function do_mult(num_relate, arg){
	arg = get_relate(num_relate, arg);
	$("#r0").val($("#r0").val() * arg);
}

function do_div(num_relate, arg){
	arg = get_relate(num_relate, arg);
	$("#r0").val(   ($("#r0").val() - $("#r0").val() % arg) / arg  );
}

function do_jump(mark){
	markerLine = m_lines[markers.indexOf(mark)] - 1;
}

function do_jgtz(mark){
	if($("#r0").val() > 0){
		markerLine = m_lines[markers.indexOf(mark)] - 1;
	}
}

function do_jzero(mark){
	if($("#r0").val() == 0){
		markerLine = m_lines[markers.indexOf(mark)] - 1;
	}
}
