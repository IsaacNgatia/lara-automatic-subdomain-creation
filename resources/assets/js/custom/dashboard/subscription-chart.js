var element = document.getElementById("subscriptions-chart");
if (element !== null) {
    element.innerHTML = "";
    const subscriptions = window.subscriptions || [];
    // First, let's make sure we have proper numerical data
    const monthlyData = subscriptions.map(Number);

    var options = {
        series: monthlyData, // Just use the array directly for donut charts
        chart: {
            height: 257,
            type: "donut",
        },
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ],
        plotOptions: {
            pie: {
                donut: {
                    size: "70%",
                },
            },
        },
        dataLabels: {
            enabled: false,
            formatter: function (val) {
                return val.toFixed(1) + "%"; // Format the value as percentage
            },
        },
        legend: {
            show: false,
            position: "bottom",
            horizontalAlign: "center",
            formatter: function (seriesName, opts) {
                // Show the value alongside the label
                return (
                    seriesName + ": " + opts.w.globals.series[opts.seriesIndex]
                );
            },
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return value;
                },
            },
        },
        colors: [
            "#008FFB",
            "#00E396",
            "#FEB019",
            "#FF4560",
            "#775DD0",
            "#4CAF50",
            "#FF9800",
            "#E91E63",
            "#2196F3",
            "#607D8B",
            "#9C27B0",
            "#3F51B5",
            // "rgba(132, 90, 223, 1)",
            // "rgba(35, 183, 229, 1)",
            // "rgba(38, 191, 148, 1)",
            // "rgba(245, 184, 73, 1)", // Amber
            // "rgba(255, 99, 132, 1)", // Red
            // "rgba(54, 162, 235, 1)", // Blue
            // "rgba(75, 192, 192, 1)", // Aqua
            // "rgba(255, 206, 86, 1)", // Yellow
            // "rgba(153, 102, 255, 1)", // Purple
            // "rgba(255, 159, 64, 1)", // Orange
            // "rgba(104, 132, 245, 1)", // Soft Indigo
            // "rgba(144, 238, 144, 1)", // Light Green
        ],
    };

    try {
        var chart = new ApexCharts(element, options);
        chart.render();
    } catch (error) {
        console.error("Chart Error:", error);
    }
}
