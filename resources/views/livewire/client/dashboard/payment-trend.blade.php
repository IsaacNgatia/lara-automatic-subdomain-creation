<div class="box">
    <div class="box-header">
        <div class="box-title">
            Payment Trend
        </div>
    </div>
    <div class="box-body">
        <div id="payment-trends"></div>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                var options = {
                    chart: {
                        type: 'bar'
                    },
                    series: @json($chartData['series']),
                    xaxis: {
                        categories: @json($chartData['categories']),
                    },
                    title: {
                    text: 'Monthly Transaction Totals',
                    align: 'center',
                },
                }

                var chart = new ApexCharts(document.querySelector("#payment-trends"), options);
                chart.render();
            });
        </script>
    </div>
</div>
