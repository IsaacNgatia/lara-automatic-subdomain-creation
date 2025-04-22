@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                View All Expenses</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Expenses
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                View Expenses
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Expense Table -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Expense Table
                    </div>

                </div>
                <div class="box-body space-y-3">
                    <div class="table-responsive">
                        <table class="table whitespace-nowrap min-w-full">
                            <thead class="bg-primary/10">
                                <tr class="border-b border-primary/10">
                                    <th scope="col" class="text-start">Expense Name</th>
                                    <th scope="col" class="text-start">Mikrotik Name</th>
                                    <th scope="col" class="text-start">Rate Limit</th>
                                    <th scope="col" class="text-start">Price</th>
                                    <th scope="col" class="text-start">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Harshrath</th>
                                    <td>#5182-3467</td>
                                    <td>24 May 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Zozo Hadid</th>
                                    <td>#5182-3412</td>
                                    <td>02 July 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Martiana</th>
                                    <td>#5182-3423</td>
                                    <td>15 April 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Alex Carey</th>
                                    <td>#5182-3456</td>
                                    <td>17 March 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1 px-2">
                        <div class="flex ">
                            <div class="flex space-x-4 items-center mb-3">
                                <label class="w-32 text-sm font-medium ">Per Page</label>
                                <select
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End:: Expense Table -->
    <!-- Start:: Expense Table -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        PPPoE Expense Table
                    </div>

                </div>
                <div class="box-body space-y-3">
                    <div class="table-responsive">
                        <table class="table whitespace-nowrap min-w-full">
                            <thead class="bg-primary/10">
                                <tr class="border-b border-primary/10">
                                    <th scope="col" class="text-start">Expense Name</th>
                                    <th scope="col" class="text-start">Mikrotik Name</th>
                                    <th scope="col" class="text-start">Profile</th>
                                    <th scope="col" class="text-start">Price</th>
                                    <th scope="col" class="text-start">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Harshrath</th>
                                    <td>#5182-3467</td>
                                    <td>24 May 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Zozo Hadid</th>
                                    <td>#5182-3412</td>
                                    <td>02 July 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Martiana</th>
                                    <td>#5182-3423</td>
                                    <td>15 April 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">

                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">Alex Carey</th>
                                    <td>#5182-3456</td>
                                    <td>17 March 2022</td>
                                    <td>1500</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1 px-2">
                        <div class="flex ">
                            <div class="flex space-x-4 items-center mb-3">
                                <label class="w-32 text-sm font-medium ">Per Page</label>
                                <select
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End:: Expense Table -->
@endsection

@section('scripts')
@endsection
