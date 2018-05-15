function change_mode() {
	$("#btn_animate").text($(this).text());
}
drop_debug.onclick = change_mode;
drop_run.onclick = change_mode;
drop_animate.onclick = change_mode;

function run(){
	while(!is_halt){
		btn_next.dispatchEvent(new Event("click"));
	}
}

btn_animate.onclick = function() {
	if(editor.session.getState(editor.session.getLength()) == "error"){
		alert('There are some error in code!');
		return;
	}
	if(!check_text()){
		alert('There are some JUMPs is brake');
		return;
	}
	is_halt = false;
	markerLine = 0;
	scane_markers();
	editor.setReadOnly(true);
	editor.gotoLine(1);
	btn_animate.disabled = true;
	if($("#btn_animate").html() == "Debug"){
		is_highlight_execline = true;
		btn_next.disabled = false;
		btn_pause.disabled = true;
		drawLine(markerLine);
	}
	else if($("#btn_animate").html() == "Run"){
		is_highlight_execline = false;
		btn_next.disabled = true;
		btn_pause.disabled = true;
		run();
	}
	else{
		is_highlight_execline = true;
		btn_next.disabled = true;
		btn_pause.disabled = false;
		drawLine(markerLine);
	}
};

btn_pause.onclick = function() {
	alert('aaa');
};

btn_next.onclick = function() {
	// data work
	var line = editor.session.getLine(markerLine);
	execute_line(line);
	// editor work
	if(is_highlight_execline){
		clearLine();
		markerLine = markerLine + 1;
		drawLine(markerLine);
	}
	else{
		markerLine = markerLine + 1;
	}
	if(!is_halt && markerLine >= editor.session.getLength()){
		do_halt();
		return;
	}
};

btn_reset.onclick = function() {
	btn_animate.disabled = false;
	btn_pause.disabled = true;
	btn_next.disabled = true;
	editor.setReadOnly(false);
	clearLine();
	clear_regs();
};

btn_help.onclick = function() {
	RegisterManager.add_register(100);
};

btn_save_doc.onclick = function() {
	RegisterManager.reset_values();
};

btn_load_doc.onclick = function() {
	RegisterManager.reset();
};