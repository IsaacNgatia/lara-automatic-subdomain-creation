<div class="xl:col-span-5 col-span-12">
    <div class="box">
        <div class="box-header justify-between">
            <div class="box-title">
                Admin Logs
            </div>
            <div>
                <button type="button" class="ti-btn-light py-1 px-2 rounded-sm">View All</button>
            </div>
        </div>
        <div class="box-body !p-0">
            <div class="table-responsive">
                <table class="table whitespace-nowrap min-w-full">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-start">Name</th>
                            <th scope="col" class="text-start">Agent</th>
                            <th scope="col" class="text-start">Platform</th>
                            <th scope="col" class="text-start">Last login</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminLogs as $adminLog)
                            <tr wire:key="{{ $adminLog->id }}">
                                <th scope="row">
                                    <div class="flex items-center">
                                        <div class="me-2">
                                            <span class="avatar avatar-rounded">
                                                <img src="{{ $adminLog->admin_profile ?? asset('build/assets/images/faces/13.jpg') }}"
                                                    alt="">
                                            </span>
                                        </div>
                                        <div>
                                            <span class="blockfont-semibold">{{ $adminLog->admin_name }}</span>
                                            <span
                                                class="block text-[0.75rem] text-[#8c9097] dark:text-white/50">{{ $adminLog->admin_email }}</span>

                                        </div>
                                    </div>
                                </th>
                                <td>{{ $adminLog->user_agent }}</td>
                                <td>{{ $adminLog->platform }}</td>
                                <td>
                                    <div><span class="blockfont-semibold">{{ $adminLog->created_at }}</span>
                                        <span
                                            class="block text-[0.75rem] text-[#8c9097] dark:text-white/50">{{ $adminLog->ip_address }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
