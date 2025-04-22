(function () {
    "use strict";

    /* stacked column chart */
    var options = {
        series: [
            {
                name: "Generated Vouchers",
                data: [44, 55, 41, 67, 22, 43],
            },
            {
                name: "Manual Vouchers",
                data: [13, 23, 20, 8, 13, 27],
            },
            {
                name: "Recurring Vouchers",
                data: [11, 17, 15, 15, 21, 14],
            },
        ],
        chart: {
            type: "bar",
            height: 320,
            stacked: true,
            toolbar: {
                show: true,
            },
            zoom: {
                enabled: true,
            },
        },
        grid: {
            borderColor: "#f2f5f7",
        },
        colors: ["#845adf", "#23b7e5", "#f5b849", "#e6533c"],
        responsive: [
            {
                breakpoint: 480,
                options: {
                    legend: {
                        position: "bottom",
                        offsetX: -10,
                        offsetY: 0,
                    },
                },
            },
        ],
        plotOptions: {
            bar: {
                horizontal: false,
            },
        },
        xaxis: {
            type: "datetime",
            categories: [
                "01/01/2024 GMT",
                "02/01/2024 GMT",
                "03/01/2024 GMT",
                "04/01/2024 GMT",
                "05/01/2024 GMT",
                "06/01/2024 GMT",
                "07/01/2024 GMT",
                "08/01/2024 GMT",
                "09/01/2024 GMT",
                "10/01/2024 GMT",
                "11/01/2024 GMT",
                "12/01/2024 GMT",
            ],
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: "11px",
                    fontWeight: 600,
                    cssClass: "apexcharts-xaxis-label",
                },
            },
        },
        legend: {
            position: "right",
            offsetY: 40,
        },
        fill: {
            opacity: 1,
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: "11px",
                    fontWeight: 600,
                    cssClass: "apexcharts-xaxis-label",
                },
            },
        },
    };
    var chart = new ApexCharts(
        document.querySelector("#column-stacked"),
        options
    );
    chart.render();
})();
