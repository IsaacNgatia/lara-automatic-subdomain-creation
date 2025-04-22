<div class="box-body" id="ctc-component-error-tab-preview">
    <!-- Start Stepper -->
    <div data-hs-stepper='{"currentIndex": 1}'>
        <!-- Stepper Nav -->
        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] === true ? 'success' : 'active' }}"
                @if ($isSuccess['1'] === true) data-hs-stepper-nav-item='{"index": 1, "isCompleted":true}'
               @elseif ($isError['1'] === true)
               data-hs-stepper-nav-item='{"index": 1, "hasError":true}'
               @else
                   data-hs-stepper-nav-item='{"index": 1, "isCompleted":false}' @endif>
                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span
                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </span>
                    <span
                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                        Payment Gateway
                    </span>
                </span>
                <div
                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                </div>
            </li>
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] === true ? ($isSuccess['2'] === true ? 'success' : 'active') : '' }}"
                @if ($isSuccess['1'] === true && $isSuccess['2'] === true) data-hs-stepper-nav-item='{"index": 2, "isCompleted":true}'
            @elseif ($isError['2'] === true)
            data-hs-stepper-nav-item='{"index": 2, "hasError":true}'
            @else
                data-hs-stepper-nav-item='{"index": 2}' @endif>
                <span
                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                    <span
                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                        <span
                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">2</span>
                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span
                            class="hidden animate-spin size-4 border-[3px] border-current border-t-transparent text-primary rounded-full dark:text-white hs-stepper-processed:inline-block"
                            role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </span>
                    </span>
                    <span
                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success hs-stepper-error:!text-danger">
                        Payment Configuration
                    </span>
                </span>
                <div
                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                </div>
            </li>
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] === true && $isSuccess['2'] === true ? ($isSuccess['3'] === true ? 'success' : 'active') : '' }}"
                @if ($isSuccess['1'] === true && $isSuccess['2'] === true && $isSuccess['3'] === true) data-hs-stepper-nav-item='{"index": 3, "isCompleted":true}'
            @elseif ($isError['3'] === true)
            data-hs-stepper-nav-item='{"index": 3, "hasError":true}'
            @else
                data-hs-stepper-nav-item='{"index": 3}' @endif>
                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span
                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </span>
                    <span
                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                        Test Payment
                    </span>
                </span>
                <div
                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                </div>
            </li>
        </ul>
        <!-- End Stepper Nav -->

        <!-- Stepper Content -->
        <div class="mt-5 sm:mt-8">
            <!-- First Contnet -->
            <div data-hs-stepper-content-item='{"index": 1}'
                style="display: {{ $currentStep == 1 ? 'block' : 'none' }};">
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                        <div class="lg:col-span-6 col-span-12">
                            <label for="Name1" class="ti-form-label">Payment Type: </label>
                            <select wire:model.live="selectedGateway" class="w-full" name="smsProvider">
                                <option selected>Choose One</option>
                                @foreach ($paymentGateways as $paymentGateway)
                                    <option value="{{ $paymentGateway['id'] }}">{{ $paymentGateway['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($selectedGateway == '1')
                            <div class="lg:col-span-6 col-span-12 flex items-center">
                                <input type="checkbox" id="hs-basic-with-description-checked"
                                    wire:model.live="isOwnPaybill" class="ti-switch" checked>
                                <label for="hs-basic-with-description-checked"
                                    class="text-sm text-gray-500 ms-3 dark:text-white/70">Do you have your own
                                    paybill</label>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <!-- End First Contnet -->
            <!-- First Contnet -->
            <div data-hs-stepper-content-item='{"index": 2}'
                style="display: {{ $currentStep == 2 ? 'block' : 'none' }};">
                @if ($status && $status['type'] == 'add-conf-success')
                    <div class="bg-success/20 border-t-2 border-success rounded-lg p-4 dark:bg-success/20"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-success bg-success/50 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Successfully updated.
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['add-conf-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'register-url-success')
                    <div class="bg-success/20 border-t-2 border-success rounded-lg p-4 dark:bg-success/20"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-success bg-success/50 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="#fff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Successfully updated.
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['register-url-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'add-conf-error')
                    <div class="bg-danger/20 border-s-4 border-danger p-4 dark:bg-danger/20" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-danger bg-danger/40 text-red-800 dark:border-danger dark:bg-danger/20 dark:text-red-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="#fff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Error!
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['add-conf-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'register-url-error')
                    <div class="bg-danger/20 border-s-4 border-danger p-4 dark:bg-danger/20" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-danger bg-danger/40 text-red-800 dark:border-danger dark:bg-danger/20 dark:text-red-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="#fff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Error!
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['register-url-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                        @if (!$selectedGateway)
                            <div class="lg:col-span-12 col-span-12">
                                <div class="text-center">
                                    <p class="text-gray-800 dark:text-white">Please select an Payment Gateway to
                                        proceed.
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if (($gatewayConfig['short_code'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="shortcode"
                                    class="ti-form-label">{{ $selectedGateway == '1' ? 'Paybill' : 'House Number' }}:
                                </label>
                                <input wire:model="paymentConfigForm.shortCode" type="text" id="shortcode"
                                    class="ti-form-input"
                                    placeholder="Enter {{ $selectedGateway == '1' ? 'Paybill' : 'House Number' }}">
                            </div>
                        @endif
                        @if (($gatewayConfig['client_secret'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="clientSecret" class="ti-form-label">Consumer Secret: </label>
                                <input wire:model="paymentConfigForm.clientSecret" type="text" id="clientSecret"
                                    class="ti-form-input" placeholder="Enter Client Secret">
                            </div>
                        @endif
                        @if (($gatewayConfig['client_key'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="clientKey" class="ti-form-label">Consumer Key: </label>
                                <input wire:model="paymentConfigForm.clientKey" type="text" id="clientKey"
                                    class="ti-form-input" placeholder="Enter Client Key">
                            </div>
                        @endif
                        @if (($gatewayConfig['client_id'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="clientId" class="ti-form-label">Consumer ID: </label>
                                <input wire:model="paymentConfigForm.clientKey" type="text" id="clientId"
                                    class="ti-form-input" placeholder="Enter Client Id">
                            </div>
                        @endif
                        @if (($gatewayConfig['pass_key'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="passKey" class="ti-form-label">Pass Key: </label>
                                <input wire:model="paymentConfigForm.passKey" type="text" id="passKey"
                                    class="ti-form-input" placeholder="Enter Pass Key">
                            </div>
                        @endif
                        @if ($gatewayConfig['store_no'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="storeNumber" class="ti-form-label">Store Number: </label>
                                <input wire:model="paymentConfigForm.storeNo" type="text" id="storeNumber"
                                    class="ti-form-input" placeholder="Enter Mobile">
                            </div>
                        @endif
                        @if ($gatewayConfig['till_no'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="tillNumber" class="ti-form-label">Till Number: </label>
                                <input wire:model="paymentConfigForm.tillNo" type="text" id="tillNumber"
                                    class="ti-form-input" placeholder="Enter Till Number">
                            </div>
                        @endif
                        @if ($isOwnPaybill === false)
                            <div class="lg:col-span-12 col-span-12">
                                <div class="text-start">
                                    <p class="text-[.9375rem] font-semibold mb-2">Before you proceed, please read the
                                        following:</p>
                                    <ul class="list-disc list-inside text-gray-800 dark:text-white">
                                        <li>Download the agreement document below and edit it to fit your profile.</li>
                                        <li>Submit the edited document once done.</li>
                                        <li>A commission of 3% is paid to the company, the rest is sent to the mobile
                                            number submitted.</li>
                                        <li>Wait for approval of the document after submission.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lg:col-span-12 col-span-12 my-2">
                                <a href="#" class="ti-btn ti-btn-primary btn-wave">Download Agreement
                                    Document</a>
                            </div>
                            <div class="lg:col-span-6 col-span-12">
                                <label for="mobileno" class="ti-form-label">Mobile: </label>
                                <input wire:model="paymentConfigForm.mobileNo" type="text" id="mobileno"
                                    class="ti-form-input" placeholder="Enter Recipient Mobile">
                            </div>
                        @endif
                        @if (($gatewayConfig['company_name'] ?? 0) == 1 && $isOwnPaybill === true)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="companyName" class="ti-form-label">Company Name: </label>
                                <input wire:model="paymentConfigForm.companyName" type="text" id="companyName"
                                    class="ti-form-input" placeholder="Enter Company Name">
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <!-- End First Contnet -->

            <!-- First Contnet -->
            <div data-hs-stepper-content-item='{"index": 3}'
                style="display: {{ $currentStep == 3 ? 'block' : 'none' }};">
                @if ($status && $status['type'] == 'test-stk-success')
                    <div class="bg-success/20 border-t-2 border-success rounded-lg p-4 dark:bg-success/20"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-success bg-success/50 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="#fff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Successfully updated.
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['test-stk-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'test-stk-error')
                    <div class="bg-danger/20 border-s-4 border-danger p-4 dark:bg-danger/20" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Icon -->
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-1 border-danger bg-danger/40 text-red-800 dark:border-danger dark:bg-danger/20 dark:text-red-400">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="#fff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h6 class="text-gray-800 font-semibold dark:text-white">
                                    Error!
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['test-stk-message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                        <div class="lg:col-span-6 col-span-12">
                            <label for="phoneNumber" class="ti-form-label">Phone Number: </label>
                            <input wire:model="stkMobile" type="text" id="phoneNumber" class="ti-form-input"
                                placeholder="Enter Phone Number">
                        </div>
                        <div class="lg:col-span-6 col-span-12">
                            <label for="amount" class="ti-form-label">Amount: </label>
                            <input wire:model="stkAmount" type="text" id="amount" class="ti-form-input"
                                placeholder="Enter Amount">
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        function checkTransaction() {
                            Livewire.dispatch('check-transaction-status');
                        }

                        function checkPayment() {
                            Livewire.dispatch('check-payment-status');
                        }
                        window.addEventListener('startPollingForTransaction', function() {
                            let transactionInterval = setInterval(checkTransaction, 5000);

                            window.addEventListener('startPollingForPayment', function() {
                                let paymentInterval = setInterval(checkPayment, 5000);

                                window.addEventListener('stopPollingForPayment', function() {
                                    clearInterval(paymentInterval);
                                });
                            })

                            window.addEventListener('stopPollingForTransaction', function() {
                                clearInterval(transactionInterval);
                            });
                        })
                    });
                </script>
            </div>
            <!-- End First Contnet -->

            <!-- Final Contnet -->
            <div data-hs-stepper-content-item='{"isFinal": true}'
                style="display: {{ $currentStep == 4 ? 'block' : 'none' }};">
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="text-center">
                        <i class="ri-checkbox-circle-line text-7xl text-success"></i>
                        <h4 class="text-xl font-semibold mb-1">Hurray !..Your Payment is
                            Successfull</h4>
                    </div>
                </div>
            </div>
            <!-- End Final Contnet -->

            <!-- Button Group -->
            <div class="mt-5 sm:flex justify-between items-center gap-x-2">
                <div class="mt-5 sm:flex justify-between items-center gap-x-5 md:gap-x-2 w-full">
                    <button type="button"
                        class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-back-btn wire:click="goBack"><i
                            class="ri-arrow-left-s-line rtl:rotate-180"></i>
                        Back</button>
                    @if ($currentStep == 2)
                        {{-- @if ($currentStep == 2 && $isStored == false) --}}
                        <button type="button"
                            class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-stepper-back-btn wire:click="validateStep2"
                            @if ($isStored === true) disabled @endif>
                            Submit</button>
                    @endif
                    @if ($currentStep == 2 && $isStored == true)
                        <button type="button"
                            class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-stepper-back-btn wire:click="registerUrl"
                            {{ $isRegistered === false ? '' : 'disabled' }}>
                            {{ $isRegistered ? 'Already Registered' : 'Register Url' }}</button>
                    @endif
                    @if ($currentStep < 3)
                        <button type="button"
                            class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-stepper-next-btn wire:click="checkIndexAndCallFunction"
                            @if ($currentStep == 1 && !$selectedGateway) disabled @endif
                            @if ($currentStep == 2 && !($isStored && $isRegistered)) disabled @endif>Next<i
                                class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                    @endif
                    @if ($currentStep == 3)
                        <button type="button"
                            class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                            data-hs-stepper-finish-btn wire:click="initiateStkPush">

                            <span wire:loading wire:target="initiateStkPush"
                                class="me-2">{{ $stkStatusDesc }}</span>
                            <span wire:loading wire:target="initiateStkPush" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                            <span wire:loading.class="hidden" wire:target="initiateStkPush" class="me-2">Initiate
                                STK
                            </span></button>
                    @endif
                    <button type="button"
                        class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-finish-btn style="display: none;">Finish</button>
                </div>
                <!-- End Button Group -->
            </div>
            <!-- End Stepper Content -->
        </div>
        <!-- End Stepper -->
    </div>
