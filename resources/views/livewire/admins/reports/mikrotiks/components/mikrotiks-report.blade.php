<div class="xl:col-span-6 col-span-12">
    <div class="box">
        <div class="box-header sm:flex justify-between">
            <div class="box-title">
                Report for <span class="text-primary">{{ sizeof($mikrotikIds) }}</span> Mikrotiks
            </div>
            <div>
                <span class="badge bg-primary/10 text-primary">
                    {{ $startingDate }} - {{ $endingDate }}
                </span>
            </div>
        </div>
        <div class="card-body !p-0">
            <div class="table-responsive">
                <table class="table whitespace-nowrap min-w-full">
                    <thead>
                        <tr>
                            <th class="text-start min-w-[22rem]">Mikrotik Name</th>
                            @foreach ($results['labels'] as $label)
                                <th scope="col" class="text-start">{{ $label }}</th>
                            @endforeach
                            <th scope="col" class="text-start">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($results['data'] as $mikrotik)
                            <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                                <td class="p-2 border font-medium">{{ $mikrotik['name'] }}</td>
                                @foreach ($results['labels'] as $label)
                                    <td class="p-2 border text-right">
                                        {{ number_format($mikrotik['data'][$label] ?? 0, 2) }}
                                    </td>
                                @endforeach
                                <td class="p-2 border font-medium">{{ $mikrotik['total'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                            @if (sizeof($results['labels']) > 2)
                                <td colspan="{{ sizeof($results['labels']) }}"></td>
                            @endif
                            <td colspan="1">
                                <div class="font-semibold text-end">Total Transactions :</div>
                            </td>
                            <td>
                                {{ $results['total_count'] }}
                            </td>
                        </tr>
                        <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                            @if (sizeof($results['labels']) > 2)
                                <td colspan="{{ sizeof($results['labels']) }}"></td>
                            @endif
                            <td colspan="1">
                                <div class="font-semibold text-end">Mikrotiks:</div>
                            </td>
                            <td>
                                {{ sizeof($mikrotikIds) }}
                            </td>
                        </tr>
                        <tr>
                            @if (sizeof($results['labels']) > 2)
                                <td colspan="{{ sizeof($results['labels']) }}"></td>
                            @endif
                            <td colspan="1">
                                <div class="font-semibold text-end">Total Amount :</div>
                            </td>
                            <td>
                                <span class="text-[1rem] font-semibold">{{ $results['total_amount'] }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer border-t-0">
            <div class="btn-list ltr:float-right rtl:float-left">
                <button aria-label="button" type="button"
                    class="ti-btn btn-wave bg-primary text-white !py-1 !px-2 !font-medium"
                    onclick="javascript:window.print();"><i
                        class="ri-printer-line me-1 align-middle inline-block"></i>Print</button>
                <button aria-label="button" type="button"
                    class="ti-btn btn-wave bg-secondary text-white !py-1 !px-2 !font-medium"><i
                        class="ri-share-forward-line me-1 align-middle inline-block"></i>Share Details</button>
            </div>
        </div>
    </div>
</div>
