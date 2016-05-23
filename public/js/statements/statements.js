/**
 * Created by Misha on 30/03/16.
 */

$('#show').click(function(){
    var group = $("#group_num").val();
    var type = $('#select-type option:selected').val();
    var token = $('.form').children().eq(0).val();
    myBlurFunction(1);
    //alert(type);
    switch (type) {
        case 'lectures':
            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/uir/public/statements/get-lectures',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { group: group, token: 'token' },
                success: function(data){
                    myBlurFunction(0);
                    $('#statement').html(data);
                }
            });
            break;
        case 'seminars':
            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/uir/public/statements/get-seminars',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { group: group, token: 'token' },
                success: function(data){
                    myBlurFunction(0);
                    $('#statement').html(data);
                }
            });
            break;
        case 'control':
            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/uir/public/statements/get-controls',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { group: group, token: 'token' },
                success: function(data){
                    myBlurFunction(0);
                    $('#statement').html(data);
                }
            });
            break;
        case 'class':
            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/uir/public/statements/get-classwork',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { group: group, token: 'token' },
                success: function(data){
                    myBlurFunction(0);
                    $('#statement').html(data);
                }
            });
            break;
        default:
            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/uir/public/statements/get-resulting',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { group: group, token: 'token' },
                success: function(data){
                    myBlurFunction(0);
                    $('#statement').html(data);
                }
            });
            break;
    }
    return false;
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