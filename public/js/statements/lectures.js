/**
 * Created by Misha on 31/03/16.
 */

$('.was').on('change', function() {
    var idLecturePlan = $(this).attr('data-id-lecture');
    var idUser = $(this).closest('tr').attr('id');
    myBlurFunction(1);
    if (this.checked) {
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/statements/lecture/was',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id_user: idUser, id_lecture_plan: idLecturePlan, token: 'token' },
            success: function(data){
                myBlurFunction(0);
            }
        });
        return false;
    }
    else{
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/statements/lecture/wasnot',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id_user: idUser, id_lecture_plan: idLecturePlan, token: 'token' },
            success: function(data){
                myBlurFunction(0);
            }
        });
        return false;
    }
});

var myBlurFunction = function(state) {
    /* state can be 1 or 0 */
    var containerElement = document.getElementById('main_container');
    var overlayEle = document.getElementById('overlay');

    if (state) {
        var winHeight = $(window).height()/2 - 24;
        winHeight = winHeight.toString()

        overlayEle.style.display = 'block';
        overlayEle.style.top = winHeight.concat('px');
        containerElement.setAttribute('class', 'blur');
    } else {
        overlayEle.style.display = 'none';
        containerElement.setAttribute('class', null);
    }
};


$(".all").click(function() {
    var idLecturePlan = $(this).attr('data-id-lecture');
    var idGroup = this.name;
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/lecture/wasall',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_lecture_plan: idLecturePlan, id_group: idGroup, token: 'token' },
        success: function(data){
            $( ".was").filter(function(index) {
                return $(this).attr('data-id-lecture') === idLecturePlan;
            }).prop( "checked", true );
            myBlurFunction(0);
        }
    });
    return false;
});