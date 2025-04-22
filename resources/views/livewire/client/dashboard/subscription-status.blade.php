<div class="px-6 py-4 flex-grow border-e border-dashed dark:border-defaultborder/10">
    <div class="flex items-center justify-between">
        <p class="mb-0 flex-grow text-[0.875rem] font-semibold">Subscription Status</p>
        <div class="ms-0">
            <span class="avatar bg-light !text-danger"><i
                    class="bi bi-activity text-[1rem]"></i></span>
        </div>
    </div>
    <p class="mb-2 text-[1.5rem] font-semibold">
        <span class="badge {{ $customer->status == 'active' ? 'bg-success' : 'bg-danger' }}">
            {{ $customer->status }}
        </span>
    </p>
    {{-- <div class="flex-between">
        <span class="text-[#8c9097] dark:text-white/50 text-[0.75rem] inline-flex">6 min
            ago</span>
        <span class="text-danger"><i
                class="bi bi-arrow-down-right me-1 text-[0.625rem]"></i>1.5%</span>
    </div> --}}
</div>