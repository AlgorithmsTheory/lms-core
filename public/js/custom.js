var target = document.getElementById('spin');
var spinner = new Spinner();

function logout(){
	$.ajax({ url: "logout.php" })
		.done(function(answer){
			alert(answer);
			window.location.replace("http://localhost/credit/lk1.php");
		});
}

function send_register()
{
	var errors = validate($('#test > input'));
	if(errors.length > 0)
		return;
	var msg = serialize('#test');
	$.ajax({
		type: "POST", 
		url: "save_user.php",
		data: msg 
		}).done(function(response){
			startSpin();
			setTimeout(function(){
				stopSpin();
				var message = ''
				if(response.indexOf('register') > -1){
					message += "Ошибка при регистрации пользователя.";			
				}
				else if(response.indexOf('application') > -1){
					message += "Ошибка при добавлении заявки.";	
				}
				else if(response.indexOf('empty') > -1){
					message += "Не пришли данные на сервер";	
				}
				else if(response.indexOf('repeat') > -1){
					if(response.indexOf('visit_date') > -1)
						message += "Блокировка!!!";
					else
						message += "Такой пользователь уже существует";	
				}
				if(response == 'ok') {
					message = "Ваша заявка принята!";	
				}
				alert(message);
				if(response == 'ok')
					window.location.replace("http://localhost/credit/lk.php");
			},5000);
		});
}

function send_application(){
	var errors = validate($('#form-x > input'));
	if(errors.length > 0)
		return;
	var msg = serialize('#form-x');
	$.ajax({
		type: "POST", 
		url: "success.php",
		data: msg 
		}).done(function(response){
			startSpin();
			setTimeout(function(){
				stopSpin();
				if(response == "true") {
				alert("Ваша заявка принята!");
				}
				else if(response.indexOf('visit_date') > -1){
					alert("Блокировка! Выберите другую дату приема");					
				}
				else {
					alert("Ошибка при добавлении заявки!");
				}
			},5000);
		});
}

function serialize(form) {
	return $(form).serializeArray();
}

function validate($inputs) {
	$('input').removeClass('alert');
	$('span.alert_inner_text').text('');
	var errors = [];
	$inputs.each(function(i, o) {
		$o = $(o);
		if($o.attr('id') == 'fname' || $o.attr('id') == 'lname' || $o.attr('id') == 'surname') {
			if($o.val().match(/[а-я-]+/ig) == null) {
				setAlert($o, errors, "Только русские буквы");
			}
		}
		else if($o.attr('id') == 'login' || $o.attr('id') == 'password') {
			if($o.val().match(/[a-zA-Z\-0-9]+/g) == null) {
				setAlert($o, errors, "Только цифры и латинские буквы");
			}
		}
		else if($o.attr('id') == 'email') {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!re.test($o.val())) {
				setAlert($o, errors, "Некорректный e-mail");
			}
		}
		else if($o.attr('id') == 'date' || $o.attr('id') == 'visit_date') {
			if($o.val() == '')
				setAlert($o, errors, "Некорректная дата");
		}
		else if(!isNumber($o.val())) {
				setAlert($o, errors, "Только цифры");
		}
	});
	//checkbox
	if(!$('input:checkbox#personal').prop('checked')) {
		setAlert($('input:checkbox#personal'), errors, "!!!");
	}
	return errors;	
}

function isNumber(n)
{
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function setAlert($obj,errors, text)
{
	$obj.next('.alert_inner_text').text(text);
	errors.push(text);
	$obj.addClass('alert');
}

function startSpin() {
	$("body").addClass('opaque');
	spinner.spin(target);
}

function stopSpin() {
	$("body").removeClass('opaque');
	spinner.stop();
}

function sleep(ms) {
	ms += new Date().getTime();
	while (new Date() < ms){}
} 