/**
 * Created by ssorokin on 12.06.2018.
 */

var idTest = parseInt($('#id_test').val());

getTestResults(idTest, -1);

$('#stats').on('change', '#test_results_selector', function(){
    getTestResults(idTest, $(this).val());
});

var types = [];
var frequencies = [];

$.ajax({
    type: 'get',
    cache: true,
    url:   '/stat/get-question-type-frequency-in-test/' + idTest.toString(),
    beforeSend: function (xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    },
    data: { token: 'token' },
    success: function(data){
        var parsedData = JSON.parse(data);
        for (var entry in parsedData) {
            console.log(entry);
            types.push(entry);
            frequencies.push(parsedData[entry]);
        }

        var trace1 = {
            x: types,
            y: frequencies,
            name: 'control',
            marker: {
                color: "#f8910b",
                line: {
                    color:  "#b66802",
                    width: 3
                }
            },
            type: "histogram",
            histfunc: "sum"
        };
        var histData = [trace1];
        var layout = {
            bargap: 0.05,
            bargroupgap: 0.2,
            barmode: "overlay",
            title: "Частота выпадения вопросов разного типа",
            xaxis: {title: "Тип вопроса"},
            yaxis: {title: "Частота"}
        };
        Plotly.newPlot('types_freq', histData, layout);

        $('#stat-down-button').css('display', 'inline');
    }
});


function getTestResults(idTest, idGroup) {
    var url = '/stat/get-test-results/' + idTest.toString();
    if (idGroup > 0) url += '/' + idGroup;
    $.ajax({
        type: 'get',
        cache: true,
        url:   url,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { token: 'token' },
        success: function(data){
            var parsedData = JSON.parse(data);
            var results = [];
            results.push(parsedData['A']);
            results.push(parsedData['B']);
            results.push(parsedData['C']);
            results.push(parsedData['D']);
            results.push(parsedData['E']);
            results.push(parsedData['F']);

            var chartData = [{
                values: results,
                labels: ['A', 'B', 'C', 'D', 'E', 'F'],
                sort: false,
                type: 'pie',
                marker: {
                    colors: ['#169609', '#bddc28', '#3493aa', '#4440aa', '#aa4626', '#aa130f']
                }
            }];

            var layout = {
                title: 'Результаты тестирования',
                height: 400,
                width: 500
            };

            Plotly.newPlot('test_results_pie', chartData, layout);
        }
    });
}
