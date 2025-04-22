<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="box custom-box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Expense Type Table
                </div>
                <button wire:click="addingExpenseType" type="button"
                    class="hs-dropdown-toggle ti-btn btn-wave ti-btn-primary-full">
                    Add Expense Type
                </button>
            </div>
            <div class="box-body space-y-3">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap min-w-full">
                        <thead class="bg-primary/10">
                            <tr class="border-b border-primary/10">
                                <th scope="col" class="text-start">Id</th>
                                <th scope="col" class="text-start">Expense Type Name</th>
                                <th scope="col" class="text-start">Description</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenseTypes as $expenseType)
                                <tr wire:key="{{ $expenseType->id }}" class="border-b border-primary/10">
                                    <th scope="row" class="text-start">
                                        {{ $loop->iteration + ($expenseTypes->currentPage() - 1) * $expenseTypes->perPage() }}
                                    </th>
                                    <th scope="row" class="text-start">{{ $expenseType->name }}</th>
                                    <td>{{ $expenseType->description }}</td>
                                    <td>
                                        <div class="hstack flex gap-3 text-[.9375rem]">
                                            <a aria-label="Edit" href="javascript:void(0);"
                                                class="ti-btn btn-wave ti-btn-sm ti-btn-info !rounded-full"
                                                wire:click="editExpenseType({{ $expenseType->id }})"><i
                                                    class="ri-edit-line"></i></a>
                                            <button wire:click="warn({{ $expenseType->id }})" type="button"
                                                aria-label="anchor"
                                                class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                <i class="ri-delete-bin-line"></i>
                                                <span
                                                    class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                    role="tooltip">
                                                    Delete Mikrotik
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $expenseTypes->links() }}
                <x-modal maxWidth="sm" preventModalClose=true>
                    @slot('slot')
                        @if ($addExpenseType)
                            <livewire:admins.expenses.modals.create-expense-type />
                        @elseif ($deletingId)
                            <livewire:admins.components.modals.delete-item :title="'Delete Expense Type'" :message="'Are you sure you want to delete Expense Type id ' . $deletingId"
                                :eventToBeDispatched="'delete-expense-type'" />
                        @endif
                    @endslot
                </x-modal>
            </div>
        </div>
    </div>
</div>
