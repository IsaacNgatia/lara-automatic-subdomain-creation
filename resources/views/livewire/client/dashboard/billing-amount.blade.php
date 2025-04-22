<div class="px-6 py-4 flex-grow border-e border-dashed dark:border-defaultborder/10">
    <div class="flex items-center justify-between">
        <p class="mb-0 flex-grow text-[0.875rem] font-semibold">Billing Amount</p>
        <div class="ms-1">
            <span class="avatar bg-light !text-info"><i
                    class="bi bi-cash-coin text-[1rem]"></i></span>
        </div>
    </div>
    <p class="mb-2 text-[1.5rem] font-semibold">{{ $customer->billing_amount }}</p>
    {{-- <div class="flex-between">
        <span class="text-[#8c9097] dark:text-white/50 text-[0.75rem] inline-flex">1 day
            ago</span>
        <span class="text-info"><i
                class="bi bi-arrow-up-right me-1 text-[0.625rem]"></i>1.9%</span>
    </div> --}}
</div>