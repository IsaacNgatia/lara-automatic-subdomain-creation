<div class="table-responsive md:p-5">
    <table class="table whitespace-nowrap min-w-full">
        <thead class="bg-primary/10">
            <tr class="border-b border-primary/10">
                <th scope="col" class="text-start">Provider</th>
                @if ($smsConfigs->where('api_key', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">API Key</th>
                @endif
                @if ($smsConfigs->where('sender_id', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Sender ID</th>
                @endif
                @if ($smsConfigs->where('username', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Username</th>
                @endif
                @if ($smsConfigs->where('password', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Password</th>
                @endif
                @if ($smsConfigs->where('short_code', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Short Code</th>
                @endif
                @if ($smsConfigs->where('api_secret', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">API Secret</th>
                @endif
                @if ($smsConfigs->where('is_default', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Default</th>
                @endif
                @if ($smsConfigs->where('output_type', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Output Type</th>
                @endif
                @if (
                    $smsConfigs->where('api_key', '!=', null)->count() > 0 ||
                        $smsConfigs->where('sender_id', '!=', null)->count() > 0 ||
                        $smsConfigs->where('username', '!=', null)->count() > 0 ||
                        $smsConfigs->where('password', '!=', null)->count() > 0 ||
                        $smsConfigs->where('short_code', '!=', null)->count() > 0 ||
                        $smsConfigs->where('api_secret', '!=', null)->count() > 0 ||
                        $smsConfigs->where('is_default', '!=', null)->count() > 0 ||
                        $smsConfigs->where('is_working', '!=', null)->count() > 0 ||
                        $smsConfigs->where('output_type', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Status</th>
                @endif
                @if (
                    $smsConfigs->where('api_key', '!=', null)->count() > 0 ||
                        $smsConfigs->where('sender_id', '!=', null)->count() > 0 ||
                        $smsConfigs->where('username', '!=', null)->count() > 0 ||
                        $smsConfigs->where('password', '!=', null)->count() > 0 ||
                        $smsConfigs->where('short_code', '!=', null)->count() > 0 ||
                        $smsConfigs->where('api_secret', '!=', null)->count() > 0 ||
                        $smsConfigs->where('is_default', '!=', null)->count() > 0 ||
                        $smsConfigs->where('is_working', '!=', null)->count() > 0 ||
                        $smsConfigs->where('output_type', '!=', null)->count() > 0)
                    <th scope="col" class="text-start">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($smsConfigs as $smsConfig)
                <tr class="border-b border-primary/10" wire:key="{{ $smsConfig->id }}">
                    <th scope="row" class="text-start">{{ $smsConfig->smsProvider->name }}</th>
                    @if ($smsConfigs->where('api_key', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->api_key }}</td>
                    @endif
                    @if ($smsConfigs->where('sender_id', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->sender_id }}</td>
                    @endif
                    @if ($smsConfigs->where('username', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->username }}</td>
                    @endif
                    @if ($smsConfigs->where('password', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->password }}</td>
                    @endif
                    @if ($smsConfigs->where('short_code', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->short_code }}</td>
                    @endif
                    @if ($smsConfigs->where('api_secret', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->api_secret }}</td>
                    @endif
                    @if ($smsConfigs->where('is_default', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->is_default ? 'Yes' : 'No' }}</td>
                    @endif
                    @if ($smsConfigs->where('output_type', '!=', null)->count() > 0)
                        <td>{{ $smsConfig->output_type }}</td>
                    @endif
                    @if (
                        $smsConfigs->where('api_key', '!=', null)->count() > 0 ||
                            $smsConfigs->where('sender_id', '!=', null)->count() > 0 ||
                            $smsConfigs->where('username', '!=', null)->count() > 0 ||
                            $smsConfigs->where('password', '!=', null)->count() > 0 ||
                            $smsConfigs->where('short_code', '!=', null)->count() > 0 ||
                            $smsConfigs->where('api_secret', '!=', null)->count() > 0 ||
                            $smsConfigs->where('is_default', '!=', null)->count() > 0 ||
                            $smsConfigs->where('is_working', '!=', null)->count() > 0 ||
                            $smsConfigs->where('output_type', '!=', null)->count() > 0)
                        <td>
                            @if ($smsConfig->is_working === 1)
                                <span class="badge !rounded-full bg-outline-success">Working</span>
                            @elseif ($smsConfig->is_working === 0)
                                <span class="badge !rounded-full bg-outline-danger">Erronous</span>
                            @else
                                <span class="badge !rounded-full bg-outline-warning">Testing</span>
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
