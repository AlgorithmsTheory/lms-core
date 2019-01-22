function startTimer() {
    var my_timer = document.getElementById("my_timer");
    var time = my_timer.innerHTML;
    var arr = time.split(":");
    var m = arr[0];
    var s = arr[1];
    if (s <= 0) {
        if (m <= 0) {                                                                                                   //если время вышло
            $('.question-form').first().trigger('submit');                                                                         //генерируем событие submit
            return;
        }
        m--;
        if (m < 10) m = "0" + m;
        s = 59;
    }
    else s--;
    if (s < 10) s = "0" + s;
    document.getElementById("my_timer").innerHTML = m+":"+s;
    setTimeout(startTimer, 1000);
}

$(document).on('click', '#check-button', function () {
    $('.question-form').submit();
});
