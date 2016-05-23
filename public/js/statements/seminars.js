/**
 * Created by Misha on 31/03/16.
 */

$('.was').on('change', function() {
    if (this.checked) {
        var userID = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        myBlurFunction(1);
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/statements/seminar/was',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id: userID, column: column, token: 'token' },
            success: function(data){
                myBlurFunction(0);
            }
        });
        return false;
    }
    else{
        var userID = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        myBlurFunction(1);
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/statements/seminar/wasnot',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id: userID, column: column, token: 'token' },
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