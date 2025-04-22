/* Earnings Report Chart */
export function createEarningsReportChart(debitArray, creditArray) {
    var element = document.getElementById("credit-debit-chart");

    if (element !== null) {
        element.innerHTML = ""; // Clear previous chart content

        var options = {
            series: [
                {
                    name: "Debit",
                    data: debitArray,
                },
                {
                    name: "Credit",
                    data: creditArray,
                },
            ],
            chart: {
                height: 340,
                type: "bar",
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
            labels: Array.from({ length: debitArray.length }, (_, i) => i + 1),
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
        var chart1 = new ApexCharts(element, options);
        chart1.render();

        // Optional: Expose chart update method
        return {
            updateColors: function (myVarVal) {
                chart1.updateOptions({
                    colors: ["rgb(" + myVarVal + ")", "#e9e9e9"],
                });
            },
        };
    }
}

// Call the function on page load with the required data
document.addEventListener("DOMContentLoaded", function () {
    const debitData = window.dailyIncome || [];
    const creditData = window.dailyExpense || [];

    createEarningsReportChart(debitData, creditData);
});
Livewire.on("update-earnings-chart", (data) => {
    console.log(data.dailyIncome, data.dailyExpense);
    const chart = createEarningsReportChart(
        data.dailyIncome ?? [],
        data.dailyExpense ?? []
    );
});
/* Earnings Report Chart */
