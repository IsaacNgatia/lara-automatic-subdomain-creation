/* Debit Credit Report Chart */
export function createDebitCreditChart(debitArray, creditArray) {
    var element = document.getElementById("year-debit-credit");

    if (element !== null) {
        element.innerHTML = ""; // Clear previous chart content

        var options = {
            series: [
                {
                    name: "Debit",
                    data: debitArray,
                    type: "line",
                },
                {
                    name: "Credit",
                    data: creditArray,
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
        var chart1 = new ApexCharts(element, options);
        chart1.render();

        // Optional: Expose chart update method
        return {
            updateColors: function (myVarVal) {
                chart1.updateOptions({
                    colors: ["rgb(" + myVarVal + ")", "rgba(230, 83, 60,0.5)"],
                });
            },
        };
    }
}

// Call the function on page load with the required data
document.addEventListener("DOMContentLoaded", function () {
    const monthlyDebit = window.monthlyDebit || [];
    const monthlyCredit = window.monthlyCredit || [];

    createDebitCreditChart(monthlyDebit, monthlyCredit);
});
Livewire.on("update-yearly-debit-credit", (data) => {
    console.log(data.dailyIncome, data.dailyExpense);
    const chart = createEarningsReportChart(
        data.monthlyIncome ?? [],
        data.monthlyExpense ?? []
    );
});
/* Earnings Report Chart */
