    <div>
        <!-- Page Header Close -->
        <!-- Start:: Manual And Recurring VOuchers -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="box custom-box">
                    <div class="box-header justify-between">
                        <div class="box-title">
                            Tickets
                        </div>

                    </div>
                    {{-- <div class="box-body space-y-3">
                        <div class="flex justify-between">
                            <div>
                                <form>
                                    <div class="relative">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                                    <div class="xl:col-span-4 col-span-12 choices-control">
                                                        <label for="invoice-date-issued"
                                                            class="form-label">Customer</label>

                                                    </div>
                                                    <div class="xl:col-span-4 col-span-12">
                                                        <label for="invoice-date-issued" class="form-label">Date
                                                            Issued</label>
                                                        <input type="date"
                                                            class="form-control w-full !rounded-md !bg-light"
                                                            id="invoice-date-issued" wire:model="invoice_date">

                                                    </div>
                                                    <div class="xl:col-span-4 col-span-12">
                                                        <label for="invoice-date-due" class="form-label">Due
                                                            Date</label>
                                                        <input type="date"
                                                            class="form-control w-full !rounded-md !bg-light"
                                                            wire:model="due_date">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                </form>
                            </div>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table whitespace-nowrap table-bordered min-w-full">
                            <thead>
                                <tr class="border-b border-defaultborder">
                                    <th scope="col" class="text-start">#</th>
                                    <th scope="col" class="text-start">Ref No</th>
                                    <th scope="col" class="text-start">Customer</th>
                                    <th scope="col" class="text-start">Topic</th>
                                    <th scope="col" class="text-start">Description</th>
                                    <th scope="col" class="text-start">Status</th>
                                    <th scope="col" class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr class="border-b border-defaultborder">
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->case_number }}</td>
                                        <td>{{ $ticket->customer->official_name }}</td>

                                        <td>{{ $ticket->topic }}</td>
                                        <td>{{ Str::limit($ticket->description, 20) }}</td>
                                        <td>
                                            @if ($ticket->status == 'open')
                                                <span class="badge bg-danger/10 text-danger">open</span>
                                            @else
                                                <span class="badge bg-success/10 text-success">closed</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="hstack flex gap-2 flex-wrap">
                                                <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <a type="button" aria-label="anchor"
                                                        wire:click="replyToTicket({{ $ticket->id }})"
                                                        data-hs-overlay="#hs-vertically-centered-scrollable-modal"
                                                        class="hs-tooltip-toggle hs-dropdown-toggle me-4 text-primary text-[.875rem] leading-none"
                                                        @if ($ticket->status == 'closed') disabled style="pointer-events: none; opacity: 0.6;" @endif>
                                                        <i class="ri-discuss-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-primary !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            Reply
                                                        </span>
                                                    </a>
                                                </div>
                                                
                                                <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <button type="button" aria-label="anchor"
                                                        wire:click="markResolved({{ $ticket->id }})"
                                                        class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none"
                                                        @if ($ticket->status == 'closed') disabled style="pointer-events: none; opacity: 0.6;" @endif>
                                                        <i class="ri-check-double-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            Mark as Resolved
                                                        </span>
                                                    </button>
                                                </div>
                                                
                                                <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <button type="button" aria-label="anchor"
                                                        wire:click="warn({{ $ticket->id }})"
                                                        class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            Delete Ticket
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $tickets->links() }}
                    </div>
                    {{-- {{ $tickets->links() }} --}}

                    <x-modal maxWidth="sm" preventModalClose=false>
                        @slot('slot')
                            @if ($deletingId)
                                <livewire:admins.components.modals.delete-item :title="'Delete Ticket'" :message="'Are you sure you want to delete ticket id ' . $deletingId"
                                    :eventToBeDispatched="'delete-ticket'" />
                            @endif
                        @endslot
                    </x-modal>
                    <x-modal maxWidth="xl" preventModalClose=false>
                        @slot('slot')
                            @if ($selectedTicketId)
                                <livewire:admins.support.admin-support-reply :id="$selectedTicketId" />
                            @endif
                        @endslot
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
    </div>
