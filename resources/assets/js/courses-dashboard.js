/* Earnings Report Chart */
var element = document.getElementById("credit-debit");
// var chartInitialized = false;
if (element !== null) {
    element.innerHTML = "";
    var options = {
        series: [
            {
                name: "Debit",
                data: window.dailyIncome,
            },
            {
                name: "Credit",
                data: window.dailyExpense,
            },
        ],
        chart: {
            height: 340,
            type: "bar",
            // events: {
            //     rendered: function () {
            //         chartInitialized = true; // Set flag to true once rendered
            //         console.log("Chart initialized.");
            //     },
            // },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: [1.1, 1.1],
            show: true,
            curve: ["smooth", "smooth"],
        },
        grid: {
            borderColor: "#f3f3f3",
            strokeDashArray: 3,
        },
        xaxis: {
            axisBorder: {
                color: "rgba(119, 119, 142, 0.05)",
            },
        },
        legend: {
            show: false,
        },
        labels: Array.from(
            { length: window.dailyIncome.length },
            (_, i) => i + 1
        ),
        markers: {
            size: 0,
        },
        colors: ["rgb(132, 90, 223)", "#e9e9e9"],
        plotOptions: {
            bar: {
                columnWidth: "50%",
                borderRadius: 2,
            },
        },
    };
    var chart1 = new ApexCharts(
        document.querySelector("#credit-debit-chart"),
        options
    );
    chart1.render();
}

export function earningsReport(myVarVal) {
    chart1.updateOptions({
        colors: ["rgb(" + myVarVal + ")", "#e9e9e9"],
    });
    // if (chartInitialized) {
    //     chart1.updateOptions({
    //         colors: ["rgb(" + myVarVal + ")", "#e9e9e9"],
    //     });
    // }
}
/* Earnings Report Chart */
/* Payouts Chart */
var element = document.getElementById("course-payouts");
if (element !== null) {
    element.innerHTML = "";
    var options2 = {
        series: [
            {
                name: "Debit",
                data: [55, 55, 42, 42, 55, 55, 38, 40],
                type: "line",
            },
            {
                name: "Credit",
                data: [10, 10, 3, 3, 0, 5, 0, 0],
                type: "line",
            },
        ],
        chart: {
            height: 265,
            toolbar: {
                show: false,
            },
            background: "none",
            fill: "#fff",
        },
        grid: {
            borderColor: "#f2f6f7",
        },
        colors: ["rgb(132, 90, 223)", "rgba(230, 83, 60,0.5)"],
        background: "transparent",
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "smooth",
            width: 2,
            dashArray: [0, 5],
        },
        xaxis: {
            type: "month",
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: "top",
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false,
                color: "rgba(119, 119, 142, 0.05)",
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: false,
                borderType: "solid",
                color: "rgba(119, 119, 142, 0.05)",
                width: 6,
                offsetX: 0,
                offsetY: 0,
            },
            labels: {
                rotate: -90,
            },
        },
        yaxis: {
            show: false,
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        tooltip: {
            x: {
                format: "dd/MM/yy HH:mm",
            },
        },
    };
    var chart2 = new ApexCharts(
        document.querySelector("#course-payouts"),
        options2
    );
    chart2.render();
}

export function coursePayouts(myVarVal) {
    chart2.updateOptions({
        colors: ["rgb(" + myVarVal + ")", "rgba(230, 83, 60,0.5)"],
    });
}
/* Payouts Chart */
