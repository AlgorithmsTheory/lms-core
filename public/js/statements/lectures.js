/**
 * Created by Misha on 31/03/16.
 */
$('.print_to_pdf').on('click', ()=>{
    let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

    mywindow.document.write(`<html><head><title></title>`);
    mywindow.document.write(`</head><body style="border: 2px solid black;">`);
    var printNode = document.getElementById('statement').cloneNode(true);
    printNode.getElementsByClassName('table')[0].setAttribute('border', '1')
    printNode.removeChild(printNode.getElementsByClassName('print_to_pdf')[0])
    //var tra = printNode.getElementsByClassName('functionalty_tr')[0]
    //var pTra = tra.parentNode;
    //pTra.remove(tra);
    mywindow.document.write(printNode.innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();
})
$('.was').on('change', function() {
    var idLecturePlan = $(this).attr('data-id-lecture');
    var idUser = $(this).closest('tr').attr('id');
    var isPresence = false;
    myBlurFunction(1);
    if (this.checked) {
        isPresence = true;
    }
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/lecture/mark_present',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_user: idUser, id_lecture_plan: idLecturePlan, token: 'token', is_presence: isPresence},
        success: function(data){
            myBlurFunction(0);
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


$(".all").click(function() {
    var idLecturePlan = $(this).attr('data-id-lecture');
    var idGroup = this.name;
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/lecture/mark_present_all',
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