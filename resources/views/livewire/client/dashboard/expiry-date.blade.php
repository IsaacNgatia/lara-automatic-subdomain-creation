<div class="px-6 py-4 flex-grow border-b-0 border-dashed dark:border-defaultborder/10">
    <div class="flex items-center justify-between">
        <p class="mb-0 flex-grow text-[0.875rem] font-semibold">Expiry Date</p>
        <div class="ms-2">
            <span class="avatar bg-light !text-warning"><i
                    class="bi bi-calendar-event text-[1rem]"></i></span>
        </div>
    </div>
    <p class="mb-2 text-[1.5rem] font-semibold">{{ \Carbon\Carbon::parse($customer->expiry_date)->format('d-m-Y H:i') }}</p>
    {{-- <div class="flex-between">
        <span class="text-[#8c9097] dark:text-white/50 text-[0.75rem] inline-flex">1 hr
            ago</span>
        <span class="text-warning"><i
                class="bi bi-arrow-down-right me-1 text-[0.625rem]"></i>1.9%</span>
    </div> --}}
</div>