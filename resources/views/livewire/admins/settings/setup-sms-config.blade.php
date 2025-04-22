<div class="box-body">
    <!-- Start Stepper -->
    <div data-hs-stepper>
        <!-- Stepper Nav -->
        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] == true ? 'success' : 'active' }}"
                @if ($isSuccess['1'] == true) data-hs-stepper-nav-item='{"index": 1, "isCompleted":true}'
               @elseif ($isError['1'] == true)
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
                        SMS Provider
                    </span>
                </span>
                <div
                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                </div>
            </li>
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] == true ? ($isSuccess['2'] == true ? 'success' : 'active') : '' }}"
                @if ($isSuccess['1'] == true && $isSuccess['2'] == true) data-hs-stepper-nav-item='{"index": 2, "isCompleted":true}'
            @elseif ($isError['2'] == true)
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
                        Configuration Details
                    </span>
                </span>
                <div
                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                </div>
            </li>
            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $isSuccess['1'] == true && $isSuccess['2'] == true ? ($isSuccess['3'] == true ? 'success' : 'active') : '' }}"
                @if ($isSuccess['1'] == true && $isSuccess['2'] == true && $isSuccess['3'] == true) data-hs-stepper-nav-item='{"index": 3, "isCompleted":true}'
            @elseif ($isError['2'] == true)
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
                        Test SMS
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
                            <label for="Name1" class="ti-form-label">SMS Provider: </label>
                            <select wire:model.live="selectedProvider" class="w-full" name="smsProvider">
                                <option selected>Choose One</option>
                                @foreach ($providers as $smsProvider)
                                    <option wire:key="{{ $smsProvider['id'] }}" value="{{ $smsProvider['id'] }}">
                                        {{ $smsProvider['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End First Contnet -->

            <!-- First Contnet -->
            <div data-hs-stepper-content-item='{"index": 2}''
                style="display: {{ $currentStep == 2 ? 'block' : 'none' }};">
                @if ($status && $status['type'] == 'write-to-db-success')
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
                                    {{ $status['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'write-to-db-error')
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
                                    {{ $status['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2">
                        @if (!$selectedProvider)
                            <div class="lg:col-span-12 col-span-12">
                                <div class="text-center">
                                    <p class="text-gray-800 dark:text-white">Please select an SMS provider to proceed.
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($providerConfig['api_key'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <div class="flex justify-between items-center">
                                    <label for="apiKey" class="ti-form-label">API Key: </label>
                                    <button type="button" class="hs-dropdown-toggle"
                                        data-hs-overlay="#exampleModalScrollable4">
                                        <i class="bi bi-question-circle"></i>
                                    </button>
                                </div>
                                <div id="exampleModalScrollable4" class="hs-overlay hidden ti-modal">
                                    <div
                                        class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                                        <div class="ti-modal-content w-full">
                                            <div class="ti-modal-header">
                                                <h6 class="modal-title text-[1rem] font-semibold"
                                                    id="staticBackdropLabel4">
                                                    How to get the API Key
                                                </h6>
                                                <button type="button" class="hs-dropdown-toggle ti-modal-close-btn"
                                                    data-hs-overlay="#exampleModalScrollable4">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="w-3.5 h-3.5" width="8" height="8"
                                                        viewBox="0 0 8 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="ti-modal-body">
                                                <h5>Popover in a modal</h5>
                                                <div class="mb-2">This
                                                    <div
                                                        class="hs-tooltip ti-main-tooltip [--trigger:click] [--placement:right]">
                                                        <a class="hs-tooltip-toggle ti-main-tooltip-toggle ti-btn  btn-wave ti-btn-secondary me-2"
                                                            href="javascript:void(0);">button
                                                            <div class="hs-tooltip-content ti-main-tooltip-content dark:bg-bodybg !p-0 !max-w-[276px]"
                                                                role="tooltip">
                                                                <div
                                                                    class="!border-b !border-solid dark:border-defaultborder/10 !rounded-t-md !py-2  !px-4 text-defaulttextcolor border-defaultborder text-start w-full text-[1rem]">
                                                                    <h6>Popover Title</h6>
                                                                </div>
                                                                <p
                                                                    class="!text-defaulttextcolor !text-[0.8rem] !py-4 !px-4 text-start">
                                                                    Popover body content is set in this attribute.</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    triggers a popover on click.
                                                </div>
                                                <hr class="my-2">
                                                <h5>Tooltips in a modal</h5>
                                                <div>
                                                    <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                        <p class="text-muted mb-0">
                                                            <a href="javascript:void(0);">
                                                                <span class="hs-tooltip-toggle !text-primary">
                                                                    This link
                                                                    <span
                                                                        class="hs-tooltip-content ti-main-tooltip-content py-1 px-2 !bg-black !text-xs !font-medium !text-white shadow-sm"
                                                                        role="tooltip">
                                                                        Tooltip
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </p>
                                                    </div> and
                                                    <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                        <p class="text-muted mb-0"> <a href="javascript:void(0);">
                                                                <span class="hs-tooltip-toggle !text-primary">
                                                                    That link
                                                                    <span
                                                                        class="hs-tooltip-content ti-main-tooltip-content py-1 px-2 !bg-black !text-xs !font-medium !text-white shadow-sm"
                                                                        role="tooltip">
                                                                        Tooltip
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </p>
                                                    </div>
                                                    have tooltips on hover.
                                                </div>
                                            </div>
                                            <div class="ti-modal-footer">
                                                <button type="button"
                                                    class="hs-dropdown-toggle ti-btn  btn-wave ti-btn-secondary-full"
                                                    data-hs-overlay="#exampleModalScrollable4">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input wire:model.blur="setupAccountForm.apiKey" type="text" id="apiKey"
                                    class="ti-form-input" placeholder="Enter Api Key">
                            </div>
                            @error('setupAccountForm.apiKey')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['sender_id'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="senderId" class="ti-form-label">Sender Id: </label>
                                <input wire:model.blur="setupAccountForm.senderId" type="text" id="senderId"
                                    class="ti-form-input" placeholder="Enter Sender Id">
                            </div>
                            @error('setupAccountForm.senderId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['username'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="username" class="ti-form-label">Username: </label>
                                <input wire:model.blur="setupAccountForm.username" type="text" id="username"
                                    class="ti-form-input" placeholder="Enter Username">
                            </div>
                            @error('setupAccountForm.username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['password'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="password" class="ti-form-label">Password: </label>
                                <input wire:model.blur="setupAccountForm.password" type="text" id="password"
                                    class="ti-form-input" placeholder="Enter Password">
                            </div>
                            @error('setupAccountForm.password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['short_code'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="shortCode" class="ti-form-label">Shortcode: </label>
                                <input wire:model.blur="setupAccountForm.shortCode" type="text" id="shortCode"
                                    class="ti-form-input" placeholder="Enter Shortcode">
                            </div>
                            @error('setupAccountForm.shortCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['api_secret'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="apiSecret" class="ti-form-label">API Secret: </label>
                                <input wire:model.blur="setupAccountForm.apiSecret" type="text" id="apiSecret"
                                    class="ti-form-input" placeholder="Enter API Secret">
                            </div>
                            @error('setupAccountForm.apiSecret')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        @if ($providerConfig['output_type'] ?? false)
                            <div class="lg:col-span-6 col-span-12">
                                <label for="outputType" class="ti-form-label">Output Type: </label>
                                <select wire:model.blur="setupAccountForm.outputType"
                                    class="js-example-basic-single w-full" name="outputType" id="outputType"
                                    disabled>
                                    <option selected>json</option>
                                    <option>plain</option>
                                </select>
                            </div>
                            @error('setupAccountForm.outputType')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                    </div>
                </div>
            </div>
            <!-- End First Contnet -->

            <!-- First Contnet -->
            <div data-hs-stepper-content-item='{"index": 3}'
                style="display: {{ $currentStep == 3 ? 'block' : 'none' }};">
                @if ($status && $status['type'] == 'test-sms-config-success')
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
                                    Message Sent Successfully
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($status && $status['type'] == 'test-sms-config-error')
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
                                    {{ $status['message'] }}
                                </h6>
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $status['reason'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                        <div class="col-span-12">
                            <label for="phone" class="ti-form-label">Phone Number:
                            </label>
                            <input type="tel" id="phone" class="ti-form-input" wire:model="phone"
                                placeholder="07XXXXXXXX">
                        </div>
                        <div class="col-span-12">
                            <label for="card1" class="ti-form-label">Message: </label>
                            <textarea id="hs-autoheight-textarea" class="ti-form-input" rows="3" placeholder="Test SMS Integration"
                                wire:model="message"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End First Contnet -->

            <!-- Final Contnet -->
            <div data-hs-stepper-content-item='{"isFinal": true}'
                style="display: {{ $currentStep == 4 ? 'block' : 'none' }};">
                <div
                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                    <div class="text-center">
                        <i class="ri-checkbox-circle-line text-7xl text-success"></i>
                        <h4 class="text-xl font-semibold mb-1">Hurray !..Your SMS Configuration is
                            Successfull</h4>
                    </div>
                </div>
            </div>
            <!-- End Final Contnet -->

            <!-- Button Group -->
            <div class="mt-5 sm:flex justify-between items-center gap-x-5 md:gap-x-2">
                <button type="button" class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-stepper-back-btn wire:click="goBack"><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                    Back</button>
                @if ($currentStep == 2)
                    <button type="button"
                        class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-back-btn wire:click="validateStep2"
                        @if ($isStored == true) disabled @endif>
                        Submit</button>
                @endif
                @if ($currentStep < 3)
                    <button type="button"
                        class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-next-btn wire:click="checkIndexAndCallFunction"
                        @if ($currentStep == 1 && !$selectedProvider) disabled @endif
                        @if ($currentStep == 2 && !$isStored) disabled @endif>Next<i
                            class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                    {{-- <button type="button"
                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-stepper-next-btn>Next<i class="ri-arrow-right-s-line rtl:rotate-180"></i></button> --}}
                @endif
                @if ($currentStep == 3)
                    <button type="button"
                        class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-finish-btn wire:click="sendTestSMS"><span wire:loading
                            wire:target="sendTestSMS" class="me-2">Sending
                            SMS</span>
                        <span wire:loading wire:target="sendTestSMS" class="loading"><i
                                class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                        <span wire:loading.class="hidden" wire:target="sendTestSMS" class="me-2">Send
                            SMS</span></button>
                @endif
                @if ($currentStep == 4)
                    <button type="button"
                        class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-stepper-finish-btn style="display: none;">Finish</button>
                @endif
            </div>
            <!-- End Button Group -->
        </div>
        <!-- End Stepper Content -->
    </div>
    <!-- End Stepper -->
</div>
