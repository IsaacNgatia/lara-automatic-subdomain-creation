<div class="xl:col-span-12 col-span-12">
    <div class="box">
        <div class="box-header justify-between">
            <div class="box-title">
                Subscriptions
            </div>
            <div>
                <button type="button" class="ti-btn btn-wave ti-btn-primary 1 !text-[0.85rem] !m-0 !font-medium">View
                    All</button>
            </div>
        </div>
        <div class="box-body !my-2 !py-6 !px-2">
            <script>
                window.subscriptions = @json($subscriptions);
            </script>
            <div id="subscriptions-chart"></div>
        </div>
        <div class="box-footer !p-0 overflow-hidden">
            <div class="flex gap-2 overflow-auto">
                @foreach ($months as $month)
                    <div wire:key="{{ $month['id'] }}" class=" text-center">
                        <div class="sm:p-4  p-2 ">
                            <span class="text-[#8c9097] dark:text-white/50 text-[0.6875rem]">{{ $month['name'] }}</span>
                            <span
                                class="block text-[1rem] font-semibold">{{ round(($subscriptions[$month['id'] - 1] / ($total > 0 ? $total : 1)) * 100, 1) }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
