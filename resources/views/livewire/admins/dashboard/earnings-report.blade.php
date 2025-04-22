<div class="xl:col-span-12 col-span-12">
    <div class="box">
        <div class="box-header justify-between">
            <div class="box-title">Earnings Report</div>
            <div class="inline-flex rounded-md shadow-sm" role="group" aria-label="Basic example">
                <select wire:model.live="selectedMonth" class="mb-4 sm:mb-0 form-select !py-3" id="inlineFormSelectPref">

                    @foreach ($months as $month)
                        <option wire:key="{{ $month['id'] }}" value="{{ $month['id'] }}" @selected($month['id'] == $selectedMonth)>
                            {{ $month['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-body">
            <div id="credit-debit-chart" wire:ignore></div>
            <script>
                window.dailyIncome = @json($dailyIncome);
                window.dailyExpense = @json($dailyExpense);
            </script>
        </div>
    </div>
</div>
