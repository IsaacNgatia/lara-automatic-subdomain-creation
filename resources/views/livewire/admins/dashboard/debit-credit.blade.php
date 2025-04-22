<div class="xl:col-span-4 col-span-12">
    <div class="box">
        <div class="box-header justify-between">
            <div class="box-title">
                Monthly Debit and Credit
            </div>
            <div class="inline-flex rounded-md shadow-sm" role="group" aria-label="Basic example">
                <select wire:model.live="selectedYear" class="mb-4 sm:mb-0 form-select !py-3" id="inlineFormSelectPref">
                    @for ($i = $earliestYear; $i <= $currentYear; $i++)
                        <option value="{{ $i }}" wire:key="{{ $i }}" @selected($i == $currentYear)>
                            {{ $i }}</option>
                    @endfor

                </select>
            </div>
        </div>
        <div class="box-body">
            <script>
                window.monthlyDebit = @json($monthlyDebit);
                window.monthlyCredit = @json($monthlyCredit);
            </script>
            <div id="year-debit-credit" wire:ignore></div>
        </div>
    </div>
</div>
