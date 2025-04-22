<div class="box">
    <div class="box-body">
        <div class="flex justify-between mb-6">
            <div class="me-1">
                <h6 class="text-[0.9375rem] font-medium mb-1">Account Balance</h6>
                <a href="{{ route('client.make-payment') }}"
                    class="text-[0.75rem] text-primary opacity-[8]">
                    Make Payment<i
                        class="bi bi-box-arrow-up-right text-[0.6875rem] ms-1"></i></a>
            </div>
            <div class="min-w-fit">
                <div class="avatar bg-primary/10 !text-primary">
                    <i class="ri-paypal-fill text-[1.125rem]"></i>
                </div>
            </div>
        </div>
        <p class="text-[1.5rem] font-semibold mb-4">Ksh {{ $accountBalance }}</p>
        <p class="mb-1 text-[0.875rem]">Account Number: {{ $customer->reference_number }}</p>
    </div>
</div>