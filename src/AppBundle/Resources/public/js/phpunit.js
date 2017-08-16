var color = Chart.helpers.color;

var phpunitCoverage = function (phpunitClover) {
    return [
        Math.round(phpunitClover.coveredmethods * 100 / phpunitClover.methods),
        Math.round(phpunitClover.coveredconditionals * 100 / phpunitClover.conditionals),
        Math.round(phpunitClover.coveredstatements * 100 / phpunitClover.statements),
        Math.round(phpunitClover.coveredelements * 100 / phpunitClover.elements),
    ];
};

var buildDataset = function (data, serviceName) {
    var result = [];
    $.each(data, function (i, historyData) {
        $.each(historyData, function (i, service) {
            if (serviceName === service.name) {
                var _color = getRandomColor();
                result.push({
                    label: getFormattedDate(new Date(service.createdAt)),
                    backgroundColor: color(_color).alpha(0.5).rgbString(),
                    borderColor: color(_color),
                    borderWidth: 1,
                    data: phpunitCoverage(service.phpunitClover)
                });
            }
        });
    });

    return result;
};

var getMin = function (datasets) {
    var lowest = 100;
    var isNaN = NaN;
    $.each(datasets, function (i, dataset) {
        $.each(dataset.data, function (i, value) {
            if (value < lowest && !isNaN(value)) {
                lowest = value;
                isNaN = false;
            }
        });
    });

    return !isNaN ? lowest : 0;
};

var buildMetricChart = function (elementName, datasets) {
    var yAxesMinValue = getMin(datasets);
    var ctx = document.getElementById(elementName).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Methods', 'Conditionals', 'Statements', 'Elements'],
            datasets: datasets,
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        max: 100,
                        min: yAxesMinValue
                    }
                }]
            }
        }
    });
};

var loadPhpunitCharts = function (data, redmineId, apps) {
    var datasets = [];
    $.each(apps, function (i, serviceName) {
        datasets[serviceName] = buildDataset(data, serviceName);
        buildMetricChart('chart-' + redmineId + '-phpunit-' + serviceName, datasets[serviceName])
    });
};

var getFormattedDate = function (date) {
    var year = date.getFullYear();

    var month = (1 + date.getMonth()).toString();
    month = month.length > 1 ? month : '0' + month;

    var day = date.getDate().toString();
    day = day.length > 1 ? day : '0' + day;

    return year + '-' + month + '-' + day;
};

var getRandomColor = function () {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
};
