<div>
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12  col-span-12">
            <div class="box">
                <div class="box-body">
                    <div class="md:flex block flex-wrap items-center justify-between">
                        <div class="flex-grow">
                            <nav class="nav nav-pills nav-style-3 flex md:mb-0 mb-4" aria-label="Tabs" role="tablist">
                                <a class="nav-link text-defaulttextcolor !py-[0.35rem] !px-4 text-sm !font-medium text-center rounded-md hover:text-primary cursor-pointer active"
                                    id="portfolio-item" data-hs-tab="#Stocksportfolio" aria-controls="Stocksportfolio">
                                    Transactions
                                </a>
                                {{-- <a class="nav-link text-defaulttextcolor !py-[0.35rem] !px-4 text-sm !font-medium text-center rounded-md hover:text-primary cursor-pointer"
                                    id="market-item" data-hs-tab="#Stocksmarket" aria-controls="Stocksmarket">
                                    Invoices
                                </a> --}}
                            </nav>
                        </div>
                        {{-- <div class="flex flex-wrap items-center md:mt-0 justify-evenly gap-6">
                            <div class="md:text-end">
                                <span class="block font-semibold">Balance</span>
                                <span class="!text-primary">$8.89k</span>
                            </div>
                            <div class="md:text-end">
                                <span class="block font-semibold">Subscriptions</span>
                                <span class="!text-warning">50</span>
                            </div>
                            <div class="md:text-end">
                                <span class="block font-semibold">Total Paid</span>
                                <span class="!text-secondary">KES 300k</span>
                            </div>
                            <div class="md:text-end">
                                <button type="button" class="ti-btn ti-btn-primary-full btn-wave">Generate
                                    Statement</button>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="tab-content">
                <div class="tab-pane show active !p-0 !border-0" id="Stocksportfolio" aria-labelledby="portfolio-item"
                    role="tabpanel">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="col-span-12">
                            <div class="box">
                                <div class="box-header justify-between">
                                    <div class="box-title">
                                        Transactions
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <div class="me-2">
                                            <input class="ti-form-control form-control-sm" type="text"
                                                placeholder="Search Any Stock" aria-label=".form-control-sm example">
                                        </div>
                                        <div class="hs-dropdown ti-dropdown">
                                            <a href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-primary !py-1 !px-2 !text-[0.75rem] !m-0 !gap-0 !font-medium"
                                                aria-expanded="false">
                                                Sort By<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                            </a>
                                            <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">New</a></li>
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">Popular</a></li>
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">Relevant</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table whitespace-nowrap table-bordered border-primary/10 min-w-full">
                                            <thead>
                                                <tr class="border-b border-defaultborder">
                                                    <th scope="col" class="text-start">#</th>
                                                    <th scope="col" class="text-start">Name</th>
                                                    <th scope="col" class="text-start">Amount</th>
                                                    <th scope="col" class="text-start">Mpesa Code</th>
                                                    <th scope="col" class="text-start">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($transactions as $transaction)
                                                    <tr class="border-b border-defaultborder">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $transaction->first_name }}
                                                            {{ $transaction->middle_name }}
                                                            {{ $transaction->last_name }}</td>
                                                        <td>{{ $transaction->trans_amount }}</td>
                                                        <td>{{ $transaction->trans_id }}</td>
                                                        <td>{{ $transaction->trans_time }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr colspan="5">
                                                        <td>
                                                            No transactions were found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $transactions->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="tab-pane hidden !p-0 !border-0" id="Stocksmarket" aria-labelledby="market-item"
                    role="tabpanel">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="col-span-12">
                            <div class="box">
                                <div class="box-header justify-between">
                                    <div class="box-title">
                                        Invoices
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <div class="me-2">
                                            <input class="ti-form-control form-control-sm" type="text"
                                                placeholder="Search Any Stock" aria-label=".form-control-sm example">
                                        </div>
                                        <div class="hs-dropdown ti-dropdown">
                                            <a href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-primary !py-1 !px-2 !text-[0.75rem] !m-0 !gap-0 !font-medium"
                                                aria-expanded="false">
                                                Sort By<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                            </a>
                                            <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">New</a></li>
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">Popular</a></li>
                                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                        href="javascript:void(0);">Relevant</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table whitespace-nowrap table-bordered border-primary/10 min-w-full">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-start">Symbol</th>
                                                    <th scope="col" class="text-start">Name</th>
                                                    <th scope="col" class="text-start">Price</th>
                                                    <th scope="col" class="text-start">1D Change</th>
                                                    <th scope="col" class="text-start">1D Return %</th>
                                                    <th scope="col" class="text-start">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    class="border border-inherit border-solid dark:border-defaultborder/10">
                                                    <th scope="row" class="text-start">
                                                        APPL
                                                    </th>
                                                    <td>
                                                        App1e Inc.<span
                                                            class="font-normal text-primary text-[.625rem] ms-1">NASDAQ</span>
                                                    </td>
                                                    <td>
                                                        <span>$1,116.90</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">$28.9<i
                                                                class="ti ti-arrow-bear-right"></i></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">6.8%</span>
                                                    </td>
                                                    <td>
                                                        12,389.30
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border border-inherit border-solid dark:border-defaultborder/10">
                                                    <th scope="row" class="text-start">
                                                        TTR
                                                    </th>
                                                    <td>
                                                        Twiter.com Inc.<span
                                                            class="font-normal text-primary text-[.625rem] ms-1">NYSE</span>
                                                    </td>
                                                    <td>
                                                        <span>$993.21</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">$11.6<i
                                                                class="ti ti-arrow-bear-right"></i></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">10.25%</span>
                                                    </td>
                                                    <td>
                                                        32,125.03
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border border-inherit border-solid dark:border-defaultborder/10">
                                                    <th scope="row" class="text-start">
                                                        BS
                                                    </th>
                                                    <td>
                                                        Boostrap.com.<span
                                                            class="font-normal text-primary text-[.625rem] ms-1">NSE</span>
                                                    </td>
                                                    <td>
                                                        <span>$11.00</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">$16.0<i
                                                                class="ti ti-arrow-narrow-down"></i></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">9.0%</span>
                                                    </td>
                                                    <td>
                                                        27,911.16
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border border-inherit border-solid dark:border-defaultborder/10">
                                                    <th scope="row" class="text-start">
                                                        NFLX
                                                    </th>
                                                    <td>
                                                        Netfilx.com Inc.<span
                                                            class="font-normal text-primary text-[.625rem] ms-1">LSE</span>
                                                    </td>
                                                    <td>
                                                        <span>$161.72</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">$9.8<i
                                                                class="ti ti-arrow-narrow-down"></i></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">17.8%</span>
                                                    </td>
                                                    <td>
                                                        27,161.89
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border border-inherit border-solid dark:border-defaultborder/10">
                                                    <th scope="row" class="text-start">
                                                        ION
                                                    </th>
                                                    <td>
                                                        Ion.com Corp.<span
                                                            class="font-normal text-primary text-[.625rem] ms-1">FSX</span>
                                                    </td>
                                                    <td>
                                                        <span>$52.65</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">$14.2<i
                                                                class="ti ti-arrow-bear-right"></i></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">30.2%</span>
                                                    </td>
                                                    <td>
                                                        65,785.01
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
