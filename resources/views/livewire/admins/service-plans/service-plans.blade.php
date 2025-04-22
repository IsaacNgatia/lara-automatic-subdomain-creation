<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="box custom-box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Service Plans
                </div>

            </div>
            <div class="box-body space-y-3">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap min-w-full">
                        <thead class="bg-primary/10">
                            <tr class="border-b border-primary/10">
                                <th scope="col" class="text-start">#</th>
                                <th scope="col" class="text-start">Name</th>
                                <th scope="col" class="text-start">Type</th>
                                <th scope="col" class="text-start">Mikrotik Name</th>
                                <th scope="col" class="text-start">Rate Limit / Profile</th>
                                <th scope="col" class="text-start">Price</th>
                                <th scope="col" class="text-start">Billing Cycle</th>
                                <th scope="col" class="text-start">Status</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($servicePlans as $servicePlan)
                                <tr class="border-b border-primary/10">
                                    <th scope="row" class="text-start">{{ $loop->iteration }}</th>
                                    <td>{{ $servicePlan->name }}</td>
                                    <td>
                                        @if ($servicePlan->type == 'static')
                                            STATIC
                                        @elseif ($servicePlan->type == 'pppoe')
                                            PPPoE
                                        @elseif ($servicePlan->type == 'rhsp')
                                            HOSTSPOT
                                        @endif
                                    </td>
                                    <td>{{ $servicePlan->mikrotik->name }}</td>
                                    <td>
                                        @if ($servicePlan->type == 'static')
                                            {{ $servicePlan->rate_limit }}
                                        @elseif ($servicePlan->type == 'pppoe')
                                            {{ $servicePlan->profile }}
                                        @elseif ($servicePlan->type == 'rhsp')
                                            {{ $servicePlan->profile }}
                                        @endif
                                    </td>
                                    <td>{{ $servicePlan->price }}</td>
                                    <td>{{ $servicePlan->billing_cycle }}</td>
                                    <td>
                                        @if ($servicePlan->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">
                                            <button type="button" wire:click="editServicePlan( {{ $servicePlan->id }})"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"><i
                                                    class="ri-edit-line"></i></button>
                                            <button type="button" wire:click="warn({{ $servicePlan->id }})"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-danger !rounded-full"><i
                                                    class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No service plans were found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                {{ $servicePlans->links() }}
            </div>
            <x-modal maxWidth="xl" preventModalClose="true">
                @slot('slot')
                    @if ($updatingId)
                        {{-- <livewire:admins.service-plans.edit-service-plan :id="$updatingId" /> --}}
                        @if ($servicePlanType == 'pppoe')
                            <livewire:admins.service-plans.modals.edit-p-p-po-e-service-plan :id="$updatingId" />
                        @elseif($servicePlanType == 'static')
                            <livewire:admins.service-plans.modals.edit-static-service-plan :id="$updatingId" />
                        @elseif($servicePlanType == 'rhsp')
                            <livewire:admins.service-plans.modals.edit-hotspot-service-plan :id="$updatingId" />
                        @endif
                    @endif

                    @if ($deletingId)
                        <livewire:admins.components.modals.delete-item :title="'Delete package'" :message="'Are you sure you want to delete package id ' . $deletingId" :eventToBeDispatched="'delete-package'"
                            :cancelEvent="'cancel-delete-package'" lazy />
                    @endif
                @endslot
            </x-modal>
        </div>
    </div>
</div>
