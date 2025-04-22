<div class="table-responsive md:p-5">
    <table class="table whitespace-nowrap min-w-full">
        <thead class="bg-primary/10">
            <tr class="border-b border-primary/10">
                <th scope="col" class="text-start">Gateway</th>
                @if ($paymentConfigs->where('short_code', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Short Code</th>
                @endif
                @if ($paymentConfigs->where('till_no', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Till Number</th>
                @endif
                @if ($paymentConfigs->where('store_no', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Store Number</th>
                @endif
                @if ($paymentConfigs->where('consumer_key', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Consumer Key</th>
                @endif
                @if ($paymentConfigs->where('consumer_secret', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Consumer Secret</th>
                @endif
                @if ($paymentConfigs->where('pass_key', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Pass Key</th>
                @endif
                @if ($paymentConfigs->where('is_default', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Default</th>
                @endif
                @if (
                    $paymentConfigs->where('short_code', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('till_no', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('store_no', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('consumer_key', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('consumer_secret', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('pass_key', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('is_default', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('is_working', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('output_type', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Status</th>
                @endif
                @if (
                    $paymentConfigs->where('short_code', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('till_no', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('store_no', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('consumer_key', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('consumer_secret', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('pass_key', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('is_default', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('is_working', '!=', null)->count() > 0 ||
                        $paymentConfigs->where('output_type', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentConfigs as $paymentConfig)
                <tr class="border-b border-primary/10" wire:key="{{ $paymentConfig->id }}">
                    <th scope="row" class="text-start">{{ $paymentConfig->paymentGateway->name }}</th>
                    @if ($paymentConfigs->where('short_code', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->short_code }}</td>
                    @endif
                    @if ($paymentConfigs->where('till_no', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->till_no }}</td>
                    @endif
                    @if ($paymentConfigs->where('store_no', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->store_no }}</td>
                    @endif
                    @if ($paymentConfigs->where('consumer_key', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->consumer_key }}</td>
                    @endif
                    @if ($paymentConfigs->where('consumer_secret', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->consumer_secret }}</td>
                    @endif
                    @if ($paymentConfigs->where('pass_key', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->pass_key }}</td>
                    @endif
                    @if ($paymentConfigs->where('is_default', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->is_default ? 'Yes' : 'No'}}</td>
                    @endif
                    @if ($paymentConfigs->where('output_type', '!=', null)->count() > 0)
                        <td>{{ $paymentConfig->output_type }}</td>
                    @endif
                    @if (
                        $paymentConfigs->where('api_key', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('store_no', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('store_no', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('password', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('consumer_secret', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('pass_key', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('is_default', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('is_working', '!=', null)->count() > 0 ||
                            $paymentConfigs->where('output_type', '!=', null)->count() > 0)
                        <td>
                            @if ($paymentConfig->is_working)
                            <span class="badge !rounded-full bg-outline-success">Working</span>
                            @else
                            <span class="badge !rounded-full bg-outline-danger">Erronous</span>
                            @endif
                        </td>
                    @endif
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
            @endforeach
        </tbody>
    </table>
</div>
