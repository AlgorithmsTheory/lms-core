/**
 * Created by ssorokin on 11.06.2018.
 */
var rightCount = 0;
var wrongCount = 0;

var idQuestion = parseInt($('#id_question').val());

$.ajax({
    type: 'get',
    cache: true,
    url:   '/stat/get-question-success/' + idQuestion.toString(),
    beforeSend: function (xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    },
    data: { token: 'token' },
    success: function(data){
        var parsedData = JSON.parse(data);
        rightCount = parsedData["right"];
        wrongCount = parsedData["wrong"];

        var chartData = [{
            values: [rightCount, wrongCount],
            labels: ['Верно', 'Неверно'],
            type: 'pie',
            marker: {
                colors: ['#169609', '#dc0a0a']
            }
        }];

        var layout = {
            title: 'Успешность выполнения задания',
            height: 400,
            width: 500
        };

        myPlotly.newPlot('success_pie', chartData, layout);
    }
});

var difficulties = [];
var discriminants = [];
var currentDifficulty = [];
var currentDiscriminant = [];

$.ajax({
    type: 'get',
    cache: true,
    url:   '/stat/get-questions-diff-and-det/' + idQuestion.toString(),
    beforeSend: function (xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    },
    data: { token: 'token' },
    success: function(data){
        var parsedData = JSON.parse(data);
        difficulties = parsedData["difficulties"];
        discriminants = parsedData["discriminants"];
        currentDifficulty = parsedData["current_difficulty"];
        currentDiscriminant = parsedData["current_discriminant"];

        var trace1 = {
            x: difficulties,
            y: discriminants,
            mode: 'markers',
            type: 'scatter',
            name: 'Все вопросы',
            marker: {
                size: 8,
                color: '#f8910b'
            }
        };

        var trace2 = {
            x: currentDifficulty,
            y: currentDiscriminant,
            mode: 'markers',
            type: 'scatter',
            name: 'Текущий вопрос',
            marker: {
                size: 8,
                color: '#169609'
            }
        };

        var chartData = [ trace1, trace2 ];

        var layout = {
            autosize: true,
            xaxis: {
                range: [-3, 3],
                title: 'Сложность'
            },
            yaxis: {
                range: [-2.8, 2.8],
                title: 'Дискриминант'
            },
            title:'Диаграмма рассеяния сложности и дискриминанта вопросов'
        };

        myPlotly.newPlot('diff_and_disc_scatter', chartData, layout);
    }
});

var months = ['Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь', 'Январь', 'Февраль', 'Другой'];
var frequencies = [];

$.ajax({
    type: 'get',
    cache: true,
    url:   '/stat/get-question-frequency-by-month/' + idQuestion.toString(),
    beforeSend: function (xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    },
    data: { token: 'token' },
    success: function(data){
        var parsedData = JSON.parse(data);
        frequencies.push(parsedData['january']);
        frequencies.push(parsedData['february']);
        frequencies.push(parsedData['september']);
        frequencies.push(parsedData['october']);
        frequencies.push(parsedData['november']);
        frequencies.push(parsedData['december']);
        frequencies.push(parsedData['others']);

        var trace1 = {
            x: months,
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
            title: "Частота выпадения вопроса",
            xaxis: {title: "Месяц"},
            yaxis: {title: "Частота"}
        };
        myPlotly.newPlot('month_hist_frequency', histData, layout);
    }
});

var groups = [];
var totals = [];
var successes = [];
$.ajax({
    type: 'get',
    cache: true,
    url:   '/stat/get-question-group-success/' + idQuestion.toString(),
    beforeSend: function (xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    },
    data: { token: 'token' },
    success: function(data){
        var parsedData = JSON.parse(data);
        for (var i = 0; i < parsedData.length; i++) {
            groups.push(parsedData[i]['group']);
            totals.push(parsedData[i]['total']);
            successes.push(parsedData[i]['success']);
        }

        var trace1 = {
            x: groups,
            y: totals,
            name: 'Всего',
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
        var trace2 = {
            x: groups,
            y: successes,
            name: 'Верно',
            marker: {
                color: "#169609",
                line: {
                    color:  "#117807",
                    width: 1
                }
            },
            type: "histogram",
            histfunc: "sum"
        };
        var chartData = [trace1, trace2];
        var layout = {
            bargap: 0.05,
            bargroupgap: 0.2,
            barmode: "overlay",
            title: "Успешность решения вопроса по группам",
            xaxis: {title: "Группа"},
            yaxis: {title: "Количество"}
        };
        myPlotly.newPlot('success_group_hist', chartData, layout);

        $('#stat-down-button').css('display', 'inline');
    }
});

