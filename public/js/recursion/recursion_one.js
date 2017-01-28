$('#calculate').click(function(){
    var expression = $("#expression").val();
    var q = $("#q").val();
    var func = $("#function").val();
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/recursion/calculate_one',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { expression: expression, q: q, function: func, token: 'token' },
        success: function(data){
            myBlurFunction(0);
            $('#result').text(data);
        }
    });
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