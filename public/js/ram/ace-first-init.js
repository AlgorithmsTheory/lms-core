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