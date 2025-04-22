@extends('admins.layouts.master')

@section('styles')
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <!-- Tom Select Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/tom-select/css/tom-select.default.min.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Cash Purchase
            </h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Payments
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Cash Purchase
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Voucher Type -->
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Add New Vouchers
                    </div>
                </div>
                <div class="box-body">
                    <form class="sm:grid grid-cols-3 gap-4 items-center">
                        <div>
                            <label for="select-1" class="ti-form-select rounded-sm !py-2 !px-0 label">Label</label>
                            <div class="relative">
                                <select id="select-1"
                                    class="ti-form-select rounded-sm !py-2 !px-3 pe-16 !border-red focus:border-red focus:ring-red">
                                    <option selected>Select User Tpe</option>
                                    <option>Static</option>
                                    <option>PPPoE</option>
                                    <option>Recurring</option>
                                </select>
                                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-8">
                                    <svg class="h-4 w-4 text-red" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-red-600 mt-2">Please select a valid User Type.</p>
                        </div>
                        <div>
                            <label class="ti-form-label">Select Users</label>
                            <!-- Select -->
                            <div class="relative">
                                <!-- Select -->
                                <select multiple=""
                                    data-hs-select='{
                                                                "hasSearch": true,
                                                                "searchPlaceholder": "Search...",
                                                                "placeholder": "Select option...",
                                                                "toggleTag": "<button type=\"button\"></button>",
                                                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer bg-white border border-defaultborder rounded-sm text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-bodybg dark:border-defaultborder/10 dark:text-neutral-400",
                                                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-sm overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-sm focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                                                "mode": "tags",
                                                                "wrapperClasses": "relative ps-0.5 pe-9 min-h-[46px] flex items-center flex-wrap text-nowrap w-full border border-defaultborder rounded-sm text-start text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-bodybg dark:border-defaultborder/10 dark:text-neutral-400",
                                                                "tagsItemTemplate": "<div class=\"flex flex-nowrap items-center relative z-10 bg-white border border-gray-200 rounded-full p-1 m-1 dark:bg-neutral-900 dark:border-neutral-700\"><div class=\"size-6 me-1\" data-icon></div><div class=\"whitespace-nowrap text-gray-800 dark:text-neutral-200\" data-title></div><div class=\"inline-flex flex-shrink-0 justify-center items-center size-5 ms-2 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 text-sm dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer\" data-remove><svg class=\"flex-shrink-0 size-3\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6 6 18\"/><path d=\"m6 6 12 12\"/></svg></div></div>",
                                                                "tagsInputClasses": "absolute inset-0 w-full py-3 px-4 pe-9 flex-1 text-sm rounded-sm focus-visible:ring-0 !border-0 dark:bg-bodybg dark:text-white/70 dark:placeholder:text-white/50",
                                                                "optionTemplate": "<div class=\"flex items-center\"><div class=\"size-8 me-2\" data-icon></div><div><div class=\"text-sm font-semibold text-gray-800 dark:text-neutral-200\" data-title></div><div class=\"text-xs text-gray-500 dark:text-neutral-500\" data-description></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
                                                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"flex-shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                                }'
                                    class="hidden">
                                    <option value="">Choose</option>
                                    <option selected="" value="1"
                                        data-hs-select-option='{
                                                                    "description": "chris",
                                                                    "icon": "<img class=\"inline-block rounded-full\" src=\"{{ asset('build/assets/images/faces/1.jpg') }}\" />"
                                                                    }'>
                                        Christina</option>
                                    <option value="2"
                                        data-hs-select-option='{
                                                                    "description": "david",
                                                                    "icon": "<img class=\"inline-block rounded-full\" src=\"{{ asset('build/assets/images/faces/9.jpg') }}\" />"
                                                                    }'>
                                        David</option>
                                    <option value="3"
                                        data-hs-select-option='{
                                                                    "description": "alex27",
                                                                    "icon": "<img class=\"inline-block rounded-full\" src=\"{{ asset('build/assets/images/faces/10.jpg') }}\" />"
                                                                    }'>
                                        Alex</option>
                                    <option value="4"
                                        data-hs-select-option='{
                                                                    "description": "samia_samia",
                                                                    "icon": "<img class=\"inline-block rounded-full\" src=\"{{ asset('build/assets/images/faces/2.jpg') }}\" />"
                                                                    }'>
                                        Samia</option>
                                </select>
                                <!-- End Select -->
                            </div>
                            <!-- End Select -->
                        </div>

                        <button type="submit" class="ti-btn btn-wave ti-btn-primary-full !mb-0 mt-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Hotspot Manual Form -->
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Cash Purchase Form
                    </div>
                </div>
                <div class="box-body">
                    <form class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-0">
                        <div>
                            <div class="text-sm md:text-base font-semibold box-header text-primary">Client Information</div>
                            <div class="grid grid-cols-12 gap-4 mt-4">
                                <div class=" col-span-12">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" value="Jane Doe" aria-label="username"
                                        disabled>
                                </div>
                                <div class="col-span-12">
                                    <label class="form-label">Official Name</label>
                                    <input type="text" class="form-control" value="First name" aria-label="First name"
                                        disabled>
                                </div>
                                <div class="col-span-12">
                                    <label for="inputEmail4" class="form-label">Status</label>
                                    <select class="ti-form-select rounded-sm !p-2" id="select-beast-disabled"
                                        autocomplete="off" disabled>
                                        <option value="1">Inactive</option>
                                        <option value="3" selected>Active</option>
                                    </select>
                                </div>
                                <div class=" col-span-12">
                                    <label class="form-label">Bill Amount</label>
                                    <input type="text" class="form-control" placeholder="Last name"
                                        aria-label="Last name" value="2500" disabled>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm md:text-base font-semibold box-header text-primary">Payment Information
                            </div>
                            <div class="grid grid-cols-12 gap-4 mt-4">
                                <div class="col-span-12">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" value="0712345678" aria-label="phone"
                                        disabled>
                                </div>
                                <div class=" col-span-12">
                                    <label for="inputState" class="form-label">Reference Number</label>
                                    <input type="text" class="form-control" value="546ftyub"
                                        aria-label="Reference Number" disabled>
                                </div>
                                <div class=" col-span-12">
                                    <label class="form-label">Amount Received</label>
                                    <input type="text" class="form-control" placeholder="Last name"
                                        aria-label="Last name">
                                </div>
                                <div class="col-span-12">
                                    <label class="form-label">Transaction Comment (Optional)</label>
                                    <input type="text" class="form-control" placeholder="Last name"
                                        aria-label="Last name">
                                </div>

                            </div>

                        </div>
                        <div class="col-span-2">
                            <button type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Choices JS -->
    <script src="{{ asset('build/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    @vite('resources/assets/js/choices.js')


    <!-- Tom Select JS -->
    <script src="{{ asset('build/assets/libs/tom-select/js/tom-select.complete.min.js') }}"></script>
    @vite('resources/assets/js/tom-select.js')
@endsection
