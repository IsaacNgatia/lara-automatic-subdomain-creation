@extends('layouts.master')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
@endsection

@section('content')
    <!-- Start::row-1 -->
    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Basic Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Start Stepper -->
                    <div data-hs-stepper>
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 1}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 2}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 3}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Payment
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
                            <div data-hs-stepper-content-item='{"index": 1}'>
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name1" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name1" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email1" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email1" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone1" class="ti-form-label">Telephone: </label>
                                            <input type="text" id="Telephone1" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile2" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile2" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder1" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder1" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card1" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card1" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry1" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry1" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv1" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv1" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                                    Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn>Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn style="display: none;">Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Non-linear Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Start Stepper -->
                    <div data-hs-stepper='{"mode": "non-linear"}'>
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 1}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 2}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 3}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Payment
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
                            <div data-hs-stepper-content-item='{"index": 1}'>
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name2" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name2" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email2" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email2" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone2" class="ti-form-label">Telephone: </label>
                                            <input type="text" id="Telephone2" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile3" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile3" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder2" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder2" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card2" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card2" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry2" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry2" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv2" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv2" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                                    Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-skip-btn style="display: none;">Skip</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-complete-step-btn='{"completedText": "This step is completed"}'>Complete
                                    Step</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn>Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn style="display: none;">Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
    </div>
    <!-- End::row-1 -->

    <!-- Start::row-2 -->
    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Skipped Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Start Stepper -->
                    <div data-hs-stepper>
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active"
                                data-hs-stepper-nav-item='{"index": 1,"isOptional": true}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active"
                                data-hs-stepper-nav-item='{"index": 2 ,"isOptional": true}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 3,"isOptional": true}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Payment
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
                            <div data-hs-stepper-content-item='{"index": 1}'>
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name5" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name5" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email5" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email5" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone5" class="ti-form-label">Telephone:
                                            </label>
                                            <input type="text" id="Telephone5" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile5" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile5" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder5" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder5" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card5" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card5" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry5" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry5" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv5" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv5" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                                    Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-skip-btn style="display: none;">Skip</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn>Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn style="display: none;">Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Active Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Start Stepper -->
                    <div data-hs-stepper='{"currentIndex": 2}'>
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success"
                                data-hs-stepper-nav-item='{"index": 1,"isCompleted": true}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active"
                                data-hs-stepper-nav-item='{"index": 2}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 3}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Payment
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-bodybg group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                        </ul>
                        <!-- End Stepper Nav -->

                        <!-- Stepper Content -->
                        <div class="mt-5 sm:mt-8">
                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 1}'>
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name3" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name3" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email3" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email3" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone3" class="ti-form-label">Telephone: </label>
                                            <input type="text" id="Telephone3" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile1" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile1" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder3" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder3" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card3" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card3" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry3" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry3" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv3" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv3" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                                    Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn>Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn style="display: none;">Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
    </div>
    <!-- End::row-2 -->

    <!-- Start::row-3 -->
    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Error Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body" id="ctc-component-error-tab-preview">
                    <!-- Start Stepper -->
                    <div data-hs-stepper='{"currentIndex": 2}'>
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success"
                                data-hs-stepper-nav-item='{"index": 1,"isCompleted": true}'>
                                <span
                                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                                        <span
                                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active"
                                data-hs-stepper-nav-item='{"index": 2 , "hasError": true}'>
                                <span
                                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                                        <span
                                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                                data-hs-stepper-nav-item='{"index": 3}'>
                                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-active:!text-white hs-stepper-success:!bg-primary hs-stepper-success:!text-white hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success">
                                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>
                                    <span
                                        class="ms-2 text-sm font-medium text-gray-800 dark:text-white hs-stepper-active:!text-primary hs-stepper-success:!text-primary hs-stepper-completed:!text-success">
                                        Payment
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
                            <div data-hs-stepper-content-item='{"index": 1}'>
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name4" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name4" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email4" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email4" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone4" class="ti-form-label">Telephone: </label>
                                            <input type="text" id="Telephone4" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile4" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile4" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder4" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder4" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card4" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card4" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry4" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry4" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv4" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv4" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn><i class="ri-arrow-left-s-line rtl:rotate-180"></i>
                                    Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn>Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn style="display: none;">Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
        <div class="col-span-12 xxl:col-span-6">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Success Stepper
                    </div>
                    <div class="prism-toggle">
                        <button type="button"
                            class="ti-btn !py-1 !px-2 ti-btn-primary !text-[0.75rem] !font-medium btn-wave">Show
                            Code<i class="ri-code-line ms-2 inline-block align-middle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Start Stepper -->
                    <div data-hs-stepper='{"isCompleted": true}' class="completed">
                        <!-- Stepper Nav -->
                        <ul class="relative sm:flex flex-row gap-x-2 sm:space-y-0 space-y-4">
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success"
                                data-hs-stepper-nav-item='{"index": 1,"isCompleted": true}'>
                                <span
                                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                                        <span
                                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">1</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                        Name &amp; Email
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success"
                                data-hs-stepper-nav-item='{"index": 2,"isCompleted": true}'>
                                <span
                                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                                        <span
                                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">2</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                        Contact
                                    </span>
                                </span>
                                <div
                                    class="hidden sm:block w-full h-px flex-1 bg-gray-200 dark:bg-defaultborder/10 group-last:hidden hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success">
                                </div>
                            </li>
                            <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success"
                                data-hs-stepper-nav-item='{"index": 3,"isCompleted": true}'>
                                <span
                                    class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <span
                                        class="size-7 flex justify-center items-center flex-shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-bodybg dark:text-white dark:group-focus:bg-gray-600 hs-stepper-active:!bg-primary hs-stepper-success:!bg-primary hs-stepper-completed:!bg-success hs-stepper-completed:group-focus:!bg-success hs-stepper-error:!bg-danger hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 hs-stepper-processed:dark:border-white/10">
                                        <span
                                            class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">3</span>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-success:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <svg class="hidden flex-shrink-0 size-3 hs-stepper-error:block"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                        Payment
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
                            <div data-hs-stepper-content-item='{"index": 1,"isCompleted": true}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Name6" class="ti-form-label">Name: </label>
                                            <input type="text" id="Name6" class="ti-form-input"
                                                placeholder="Enter Name">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Email6" class="ti-form-label">Email: </label>
                                            <input type="email" id="Email6" class="ti-form-input"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 2,"isCompleted": true}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Telephone6" class="ti-form-label">Telephone:
                                            </label>
                                            <input type="text" id="Telephone6" class="ti-form-input"
                                                placeholder="Enter Telephone">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Mobile6" class="ti-form-label">Mobile: </label>
                                            <input type="text" id="Mobile6" class="ti-form-input"
                                                placeholder="Enter Mobile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- First Contnet -->
                            <div data-hs-stepper-content-item='{"index": 3,"isCompleted": true}' style="display: none;">
                                <div
                                    class="p-6 bg-gray-50 dark:bg-bodybg border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                        <div class="col-span-12">
                                            <label for="cardholder4" class="ti-form-label">CardHolder Name:
                                            </label>
                                            <input type="text" id="cardholder6" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="card6" class="ti-form-label">Card number: </label>
                                            <input type="text" id="card6" class="ti-form-input"
                                                placeholder="Enter card Details">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="Expiry6" class="ti-form-label">Expiry: </label>
                                            <input type="text" id="Expiry6" class="ti-form-input"
                                                placeholder="Enter Expiry Date">
                                        </div>
                                        <div class="lg:col-span-6 col-span-12">
                                            <label for="cvv6" class="ti-form-label">CVV: </label>
                                            <input type="text" id="cvv6" class="ti-form-input"
                                                placeholder="Enter CVV">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End First Contnet -->

                            <!-- Final Contnet -->
                            <div data-hs-stepper-content-item='{"isFinal": true}'>
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
                                <button type="button"
                                    class="ti-btn ti-btn-light disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-back-btn style="display: none;"><i
                                        class="ri-arrow-left-s-line rtl:rotate-180"></i> Back</button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-next-btn style="display: none;">Next<i
                                        class="ri-arrow-right-s-line rtl:rotate-180"></i></button>
                                <button type="button"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-finish-btn style="display: none;">Finish</button>
                                <button type="reset"
                                    class="ti-btn ti-btn-primary-full disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-stepper-reset-btn>Reset</button>
                            </div>
                            <!-- End Button Group -->
                        </div>
                        <!-- End Stepper Content -->
                    </div>
                    <!-- End Stepper -->
                </div>
            </div>
        </div>
    </div>
    <!-- End::row-3 -->
@endsection

@section('scripts')
    <!-- Internal Stepper JS -->
    @vite('resources/assets/js/stepper.js')
@endsection
