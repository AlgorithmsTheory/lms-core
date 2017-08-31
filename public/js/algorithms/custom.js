var target = document.getElementById('spin');
var spinner = new Spinner();

function logout(){
	$.ajax({ url: "logout.php" })
		.done(function(answer){
			alert(answer);
			window.location.replace("http://localhost/passport/lk1.php");
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
				var message = '';
				if(response.indexOf('register') > -1){
					message += "Ошибка при регистрации пользователя.";			
				}
				else if(response.indexOf('application') > -1){
					message += "Ошибка при добавлении заказа.";	
				}
				else if(response.indexOf('empty') > -1){
					message += "Не пришли данные на сервер";	
				}
				else if(response.indexOf('repeat') > -1){
					if(response.indexOf('visit_date') > -1){
						message += "Блокировка!Выберите другую дату";}
					else{
						message += "Извините, пользователь с таким логином уже существует. Введите другой логин";	
				}
				}
				if(response == 'ok') {
					message = "Вы успешно зарегистрированы! Ваша заявка принята и будет рассмотрена в ближайшее время";	
				}
				alert(message);
				if(response == 'ok')
					window.location.replace("http://localhost/passport/lk.php");
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
					alert("К сожалению, эта дата уже занята. Выберите другую дату");					
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
		if($o.attr('id') == 'fname' || $o.attr('id') == 'lname' || $o.attr('id') == 'surname' || $o.attr('id') == 'gender' || $o.attr('id') == 'bplace' || $o.attr('id') == 'resplace' || $o.attr('id') == 'purpose' || $o.attr('id') == 'receiv') {
			if($o.val().match(/[а-я-]+/ig) == null) {
				setAlert($o, errors, "Используйте русские буквы");
			}
		}
		else if($o.attr('id') == 'login' || $o.attr('id') == 'password') {
			if($o.val().match(/[a-zA-Z\-0-9]+/g) == null) {
				setAlert($o, errors, "Используйте цифры и латинские буквы");
			}
		}
		else if($o.attr('id') == 'email') {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!re.test($o.val())) {
				setAlert($o, errors, "Некорректный E-mail");
			}
		}
		else if($o.attr('id') == 'date' || $o.attr('id') == 'visit_date') {
			if($o.val() == '')
				setAlert($o, errors, "Выберите дату.");
		}
		else if(!isNumber($o.val())) {
				setAlert($o, errors, "Используйте цифры!");
		}
	});
	//checkbox
	if(!$('input:checkbox#personal').prop('checked')) {
		setAlert($('input:checkbox#personal'), errors, "!");
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