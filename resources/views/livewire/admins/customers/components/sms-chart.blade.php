<div class="box">
    <div class="box-header justify-between">
        <div class="box-title">
            SMS Summary Report
        </div>
        <div class="hs-dropdown ti-dropdown">
            <a aria-label="anchor" href="javascript:void(0);"
                class="flex items-center justify-center w-[1.75rem] h-[1.75rem] ! !text-[0.8rem] !py-1 !px-2 rounded-sm bg-light border-light shadow-none !font-medium"
                aria-expanded="false">
                <i class="fe fe-more-vertical text-[0.8rem]"></i>
            </a>
            <ul class="hs-dropdown-menu ti-dropdown-menu hidden">
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">Week</a></li>
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">Month</a></li>
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">Year</a></li>
            </ul>
        </div>
    </div>
    <div class="box-body overflow-hidden">
        <div class="leads-source-chart flex items-center justify-center">
            <canvas id="leads-source" class="chartjs-chart w-full"></canvas>
            <div class="lead-source-value ">
                <span class="block text-[0.875rem] ">Total</span>
                <span class="block text-[1.5625rem] font-bold">4,145</span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-4 border-t border-dashed dark:border-defaultborder/10">
        <div class="col !p-0">
            <div class="!ps-4 p-[0.95rem] text-center border-e border-dashed dark:border-defaultborder/10">
                <span
                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 crm-lead-legend mobile inline-block">Expiry
                </span>
                <div><span class="text-[1rem]  font-semibold">1,624</span>
                </div>
            </div>
        </div>
        <div class="col !p-0">
            <div class="p-[0.95rem] text-center border-e border-dashed dark:border-defaultborder/10">
                <span
                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 crm-lead-legend desktop inline-block">Composed
                </span>
                <div><span class="text-[1rem]  font-semibold">1,267</span>
                </div>
            </div>
        </div>
        <div class="col !p-0">
            <div class="p-[0.95rem] text-center border-e border-dashed dark:border-defaultborder/10">
                <span
                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 crm-lead-legend laptop inline-block">Acknoledgement
                </span>
                <div><span class="text-[1rem]  font-semibold">1,153</span>
                </div>
            </div>
        </div>
        <div class="col !p-0">
            <div class="!pe-4 p-[0.95rem] text-center">
                <span
                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 crm-lead-legend tablet inline-block">Ticket
                    Notices
                </span>
                <div><span class="text-[1rem]  font-semibold">679</span></div>
            </div>
        </div>
    </div>
</div>
