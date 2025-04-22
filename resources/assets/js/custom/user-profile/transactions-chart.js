var element = document.getElementById("transactions-chart");

if (element !== null) {
    const monthlyTransactions = window.monthlyTransactions || [];

    element.innerHTML = "";
    var options1 = {
        series: [
            {
                name: "Total Payments Received",
                data: monthlyTransactions,
            },
        ],
        chart: {
            type: "bar",
            height: 200,
        },
        grid: {
            borderColor: "#f2f6f7",
        },
        colors: getGraphColors(monthlyTransactions),
        plotOptions: {
            bar: {
                columnWidth: "25%",
                distributed: true,
                borderRadius: 7,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        yaxis: {
            title: {
                style: {
                    color: "#adb5be",
                    fontSize: "12px",
                    fontFamily: "Montserrat, sans-serif",
                    fontWeight: 500,
                    cssClass: "apexcharts-yaxis-label",
                },
            },
            labels: {
                formatter: function (y) {
                    return y.toFixed(0) + "";
                },
            },
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
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            axisBorder: {
                show: true,
                color: "rgba(119, 119, 142, 0.05)",
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: true,
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
    };
    var chart1 = new ApexCharts(
        document.querySelector("#transactions-chart"),
        options1
    );
    chart1.render();
}

function getGraphColors(data) {
    const firstSixColor = "rgba(132, 90, 223, 0.3)";
    const highestColor = "rgb(132, 90, 223)";
    const lastSixColor = "#e4e7ed";

    // Find the highest number in the array
    const maxValue = Math.max(...data);

    return data.map((value, index) => {
        if (index < 6) {
            // First 6 months
            return value === maxValue ? highestColor : firstSixColor;
        } else {
            // Last 6 months
            return value === maxValue ? highestColor : lastSixColor;
        }
    });
}
